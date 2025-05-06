<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
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
        // Not needed as modules are accessed through courses
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('teacher_id', auth()->id())->get();

        if ($courses->isEmpty()) {
            return redirect()->route('teacher.courses.create')
                ->with('error', 'You need to create a course first before adding modules.');
        }

        return view('teacher.modules.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'order' => 'nullable|integer|min:0',
        ]);

        // Check if the teacher owns this course
        $course = Course::findOrFail($request->course_id);
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add modules to this course.');
        }

        // If order is not provided, set it to the last position
        if (!$request->filled('order')) {
            $lastModule = Module::where('course_id', $request->course_id)
                ->orderBy('order', 'desc')
                ->first();
            $order = $lastModule ? $lastModule->order + 1 : 0;
        } else {
            $order = $request->order;
        }

        $module = Module::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'order' => $order,
        ]);

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        // Check if the teacher owns this module
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to view this module.');
        }

        return view('teacher.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        // Check if the teacher owns this module
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this module.');
        }

        $courses = Course::where('teacher_id', auth()->id())->get();

        return view('teacher.modules.edit', compact('module', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        // Check if the teacher owns this module
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this module.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'order' => 'nullable|integer|min:0',
        ]);

        // Check if the teacher owns the target course
        $course = Course::findOrFail($request->course_id);
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to move this module to the selected course.');
        }

        $module->update([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'order' => $request->order ?? $module->order,
        ]);

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        // Check if the teacher owns this module
        if ($module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this module.');
        }

        $courseId = $module->course_id;
        $module->delete();

        return redirect()->route('teacher.courses.edit', $courseId)
            ->with('success', 'Module deleted successfully.');
    }
}
