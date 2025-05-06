<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\CheckRole::class.':teacher');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Not needed as lessons are accessed through modules
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $moduleId = request('module_id');

        if (!$moduleId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Module ID is required to create a lesson.');
        }

        $module = Module::findOrFail($moduleId);

        // Check if the teacher owns this module
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add lessons to this module.');
        }

        return view('teacher.lessons.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required_if:content_type,text',
            'content_url' => 'required_if:content_type,video,file|nullable|url',
            'content_file' => 'required_if:content_type,upload|nullable|file|max:10240',
            'module_id' => 'required|exists:modules,id',
            'content_type' => 'required|in:text,video,file,upload',
            'order' => 'nullable|integer|min:0',
        ]);

        // Check if the teacher owns this module
        $module = Module::findOrFail($request->module_id);
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add lessons to this module.');
        }

        // If order is not provided, set it to the last position
        if (!$request->filled('order')) {
            $lastLesson = Lesson::where('module_id', $request->module_id)
                ->orderBy('order', 'desc')
                ->first();
            $order = $lastLesson ? $lastLesson->order + 1 : 0;
        } else {
            $order = $request->order;
        }

        // Handle file upload if content type is 'upload'
        $contentUrl = null;
        if ($request->content_type === 'upload' && $request->hasFile('content_file')) {
            $path = $request->file('content_file')->store('lesson_files', 'public');
            $contentUrl = $path;
        } else if ($request->content_type === 'video' || $request->content_type === 'file') {
            $contentUrl = $request->content_url;
        }

        $lesson = Lesson::create([
            'title' => $request->title,
            'content' => $request->content_type === 'text' ? $request->content : null,
            'module_id' => $request->module_id,
            'content_type' => $request->content_type,
            'content_url' => $contentUrl,
            'order' => $order,
        ]);

        return redirect()->route('teacher.modules.edit', $module)
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        // Check if the teacher owns this lesson
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to view this lesson.');
        }

        return view('teacher.lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        // Check if the teacher owns this lesson
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this lesson.');
        }

        // Get all modules from courses owned by the teacher
        $modules = Module::whereHas('course', function ($query) {
            $query->where('teacher_id', auth()->id());
        })->get();

        return view('teacher.lessons.edit', compact('lesson', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        // Check if the teacher owns this lesson
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this lesson.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required_if:content_type,text',
            'content_url' => 'required_if:content_type,video,file|nullable|url',
            'content_file' => 'nullable|file|max:10240',
            'module_id' => 'required|exists:modules,id',
            'content_type' => 'required|in:text,video,file,upload',
            'order' => 'nullable|integer|min:0',
        ]);

        // Check if the teacher owns the target module
        $module = Module::findOrFail($request->module_id);
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to move this lesson to the selected module.');
        }

        // Handle file upload if content type is 'upload' and a new file is provided
        $contentUrl = $lesson->content_url;
        if ($request->content_type === 'upload' && $request->hasFile('content_file')) {
            // Delete old file if it exists
            if ($lesson->content_url && Storage::disk('public')->exists($lesson->content_url)) {
                Storage::disk('public')->delete($lesson->content_url);
            }

            $path = $request->file('content_file')->store('lesson_files', 'public');
            $contentUrl = $path;
        } else if ($request->content_type === 'video' || $request->content_type === 'file') {
            $contentUrl = $request->content_url;
        }

        $lesson->update([
            'title' => $request->title,
            'content' => $request->content_type === 'text' ? $request->content : $lesson->content,
            'module_id' => $request->module_id,
            'content_type' => $request->content_type,
            'content_url' => $contentUrl,
            'order' => $request->order ?? $lesson->order,
        ]);

        return redirect()->route('teacher.modules.edit', $module)
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        // Check if the teacher owns this lesson
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this lesson.');
        }

        $moduleId = $lesson->module_id;

        // Delete associated file if it exists
        if ($lesson->content_type === 'upload' && $lesson->content_url && Storage::disk('public')->exists($lesson->content_url)) {
            Storage::disk('public')->delete($lesson->content_url);
        }

        $lesson->delete();

        return redirect()->route('teacher.modules.edit', $moduleId)
            ->with('success', 'Lesson deleted successfully.');
    }
}
