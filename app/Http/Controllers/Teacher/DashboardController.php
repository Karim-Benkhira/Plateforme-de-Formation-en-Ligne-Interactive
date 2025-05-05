<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    /**
     * Show the teacher dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $courses = $user->teacherCourses;
        $totalCourses = $courses->count();
        $totalStudents = Enrollment::whereIn('course_id', $courses->pluck('id'))->count();

        return view('teacher.dashboard', compact('courses', 'totalCourses', 'totalStudents'));
    }

    /**
     * Show the students enrolled in the teacher's courses.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function students()
    {
        $user = auth()->user();
        $courseIds = $user->teacherCourses->pluck('id');

        $enrollments = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->paginate(10);

        return view('teacher.students.index', compact('enrollments'));
    }

    /**
     * Show details for a specific student.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showStudent(User $user)
    {
        $teacher = auth()->user();
        $teacherCourseIds = $teacher->teacherCourses->pluck('id');

        $enrollments = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->whereIn('course_id', $teacherCourseIds)
            ->get();

        if ($enrollments->isEmpty()) {
            abort(404, 'Student not found in your courses');
        }

        $quizResults = $user->quizResults()
            ->with(['quiz.lesson.module.course'])
            ->whereHas('quiz.lesson.module.course', function ($query) use ($teacherCourseIds) {
                $query->whereIn('courses.id', $teacherCourseIds);
            })
            ->get();

        return view('teacher.students.show', compact('user', 'enrollments', 'quizResults'));
    }
}
