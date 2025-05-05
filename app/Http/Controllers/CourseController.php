<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:teacher')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('teacher')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,upcoming',
            'image' => 'nullable|image|max:2048',
        ]);

        $course = new Course($request->except('image'));
        $course->teacher_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('course_images', 'public');
            $course->image = $path;
        }

        $course->save();

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['teacher', 'modules.lessons']);

        // Check if the user is enrolled in this course
        $isEnrolled = false;
        $enrollment = null;

        if (auth()->check()) {
            $user = auth()->user();
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            $isEnrolled = $enrollment !== null;
        }

        return view('courses.show', compact('course', 'isEnrolled', 'enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // Check if the user is the teacher of this course
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this course');
        }

        return view('teacher.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Check if the user is the teacher of this course
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this course');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,upcoming',
            'image' => 'nullable|image|max:2048',
        ]);

        $course->fill($request->except('image'));

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }

            $path = $request->file('image')->store('course_images', 'public');
            $course->image = $path;
        }

        $course->save();

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Check if the user is the teacher of this course
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this course');
        }

        // Delete course image if it exists
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Course deleted successfully.');
    }
}
