<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display pending enrollment requests for teacher's courses.
     */
    public function index()
    {
        $teacher = auth()->user();
        
        // Get all courses created by this teacher
        $courses = Course::where('creator_id', $teacher->id)
            ->with(['pendingEnrollments' => function($query) {
                $query->orderBy('course_user.created_at', 'desc');
            }])
            ->get();

        // Get all pending enrollments for teacher's courses
        $pendingEnrollments = collect();
        foreach ($courses as $course) {
            foreach ($course->pendingEnrollments as $student) {
                $pendingEnrollments->push([
                    'course' => $course,
                    'student' => $student,
                    'requested_at' => $student->pivot->created_at,
                    'enrollment_id' => $student->pivot->id
                ]);
            }
        }

        // Sort by request date (newest first)
        $pendingEnrollments = $pendingEnrollments->sortByDesc('requested_at');

        return view('teacher.enrollments.index', compact('pendingEnrollments', 'courses'));
    }

    /**
     * Approve an enrollment request.
     */
    public function approve(Request $request, $courseId, $studentId)
    {
        $teacher = auth()->user();
        $course = Course::where('id', $courseId)
            ->where('creator_id', $teacher->id)
            ->firstOrFail();

        $student = User::findOrFail($studentId);

        // Update enrollment status to approved
        $course->users()->updateExistingPivot($studentId, [
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $teacher->id
        ]);

        // Log activity if the model exists
        if (class_exists('App\\Models\\ActivityLog')) {
            \App\Models\ActivityLog::create([
                'user_id' => $teacher->id,
                'action' => 'course.enrollment.approve',
                'description' => "Approved enrollment for {$student->username} in course: {$course->title}",
            ]);

            \App\Models\ActivityLog::create([
                'user_id' => $student->id,
                'action' => 'course.enrollment.approved',
                'description' => "Enrollment approved for course: {$course->title}",
            ]);
        }

        return redirect()->back()->with('success', "Enrollment approved for {$student->username}!");
    }

    /**
     * Reject an enrollment request.
     */
    public function reject(Request $request, $courseId, $studentId)
    {
        $teacher = auth()->user();
        $course = Course::where('id', $courseId)
            ->where('creator_id', $teacher->id)
            ->firstOrFail();

        $student = User::findOrFail($studentId);

        // Update enrollment status to rejected
        $course->users()->updateExistingPivot($studentId, [
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => $teacher->id
        ]);

        // Log activity if the model exists
        if (class_exists('App\\Models\\ActivityLog')) {
            \App\Models\ActivityLog::create([
                'user_id' => $teacher->id,
                'action' => 'course.enrollment.reject',
                'description' => "Rejected enrollment for {$student->username} in course: {$course->title}",
            ]);

            \App\Models\ActivityLog::create([
                'user_id' => $student->id,
                'action' => 'course.enrollment.rejected',
                'description' => "Enrollment rejected for course: {$course->title}",
            ]);
        }

        return redirect()->back()->with('success', "Enrollment rejected for {$student->username}.");
    }

    /**
     * Get pending enrollments count for teacher's courses.
     */
    public function getPendingCount()
    {
        $teacher = auth()->user();
        
        $count = Course::where('creator_id', $teacher->id)
            ->withCount(['pendingEnrollments'])
            ->get()
            ->sum('pending_enrollments_count');

        return response()->json(['count' => $count]);
    }

    /**
     * Show enrolled students for a specific course.
     */
    public function showCourseStudents($courseId)
    {
        $teacher = auth()->user();
        $course = Course::where('id', $courseId)
            ->where('creator_id', $teacher->id)
            ->with(['approvedEnrollments' => function($query) {
                $query->orderBy('course_user.approved_at', 'desc');
            }])
            ->firstOrFail();

        return view('teacher.enrollments.course-students', compact('course'));
    }
}
