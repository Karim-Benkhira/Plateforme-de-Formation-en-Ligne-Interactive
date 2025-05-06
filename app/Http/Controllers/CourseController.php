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
        $this->middleware(\App\Http\Middleware\CheckRole::class.':teacher')->except(['index', 'show', 'enroll']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::with('teacher');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to showing active courses
            $query->where('status', 'active');
        }

        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate(9)->withQueryString();

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
        $modules = $course->modules()->with('lessons')->orderBy('order')->get();

        // Check if the user is enrolled in this course
        $enrollment = null;

        if (auth()->check()) {
            $user = auth()->user();
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
        }

        return view('courses.show', compact('course', 'modules', 'enrollment'));
    }

    /**
     * Enroll a student in a course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enroll(Course $course)
    {
        $user = auth()->user();

        // Check if the user is already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('student.courses.show', $course)
                ->with('info', 'You are already enrolled in this course.');
        }

        // Create new enrollment
        $enrollment = new Enrollment([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => 0,
            'enrolled_at' => now()
        ]);

        $enrollment->save();

        return redirect()->route('student.courses.show', $course)
            ->with('success', 'You have successfully enrolled in this course!');
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
