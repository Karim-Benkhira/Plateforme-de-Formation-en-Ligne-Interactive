<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseViewController extends Controller
{
    /**
     * Show course content for students.
     */
    public function showCourseContent($courseId)
    {
        $course = Course::with([
            'sections' => function($query) {
                $query->orderBy('order_index');
            },
            'sections.lessons' => function($query) {
                $query->orderBy('order_index');
            },
            'category',
            'creator'
        ])->findOrFail($courseId);

        // Check if user is enrolled
        $userEnrolled = $course->users()->where('user_id', Auth::id())->exists();

        // Get completed lessons count for enrolled users
        $completedLessons = 0;
        if ($userEnrolled) {
            $completedLessons = LessonProgress::whereIn('lesson_id', $course->publishedLessons()->pluck('id'))
                ->where('user_id', Auth::id())
                ->where('is_completed', true)
                ->count();
        }

        return view('student.course-content', compact('course', 'userEnrolled', 'completedLessons'));
    }

    /**
     * Show individual lesson for students.
     */
    public function showLesson($courseId, $lessonId)
    {
        $course = Course::with(['sections.lessons', 'creator'])->findOrFail($courseId);
        $lesson = Lesson::with(['section'])->findOrFail($lessonId);

        // Verify lesson belongs to course
        if ($lesson->section->course_id != $course->id) {
            abort(404);
        }

        // Check access permissions
        $userEnrolled = $course->users()->where('user_id', Auth::id())->exists();
        
        if (!$lesson->is_free && !$userEnrolled) {
            return redirect()->route('student.course.content', $courseId)
                ->with('error', 'You need to enroll in this course to access this lesson.');
        }

        // Get user progress
        $progress = null;
        if ($userEnrolled) {
            $progress = LessonProgress::firstOrCreate([
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
            ]);
        }

        // Get next and previous lessons
        $nextLesson = $this->getNextLesson($lesson, $userEnrolled);
        $previousLesson = $this->getPreviousLesson($lesson, $userEnrolled);

        return view('student.lesson-view', compact(
            'course', 
            'lesson', 
            'progress', 
            'nextLesson', 
            'previousLesson',
            'userEnrolled'
        ));
    }

    /**
     * Mark lesson as completed.
     */
    public function markLessonCompleted(Request $request, $courseId, $lessonId)
    {
        $course = Course::findOrFail($courseId);
        $lesson = Lesson::findOrFail($lessonId);

        // Verify user is enrolled
        $userEnrolled = $course->users()->where('user_id', Auth::id())->exists();
        
        if (!$userEnrolled && !$lesson->is_free) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // Update or create progress
        $progress = LessonProgress::updateOrCreate([
            'user_id' => Auth::id(),
            'lesson_id' => $lesson->id,
        ], [
            'is_completed' => true,
            'completed_at' => now(),
            'watch_time' => $request->input('watch_time', 0),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson marked as completed!',
            'progress' => $progress
        ]);
    }

    /**
     * Get next accessible lesson.
     */
    private function getNextLesson($currentLesson, $userEnrolled)
    {
        $course = $currentLesson->section->course;
        
        // Get all lessons in order
        $allLessons = collect();
        foreach ($course->sections()->orderBy('order_index')->get() as $section) {
            foreach ($section->lessons()->orderBy('order_index')->get() as $lesson) {
                if ($lesson->is_published && ($lesson->is_free || $userEnrolled)) {
                    $allLessons->push($lesson);
                }
            }
        }

        $currentIndex = $allLessons->search(function($lesson) use ($currentLesson) {
            return $lesson->id === $currentLesson->id;
        });

        return $currentIndex !== false && $currentIndex < $allLessons->count() - 1 
            ? $allLessons[$currentIndex + 1] 
            : null;
    }

    /**
     * Get previous accessible lesson.
     */
    private function getPreviousLesson($currentLesson, $userEnrolled)
    {
        $course = $currentLesson->section->course;
        
        // Get all lessons in order
        $allLessons = collect();
        foreach ($course->sections()->orderBy('order_index')->get() as $section) {
            foreach ($section->lessons()->orderBy('order_index')->get() as $lesson) {
                if ($lesson->is_published && ($lesson->is_free || $userEnrolled)) {
                    $allLessons->push($lesson);
                }
            }
        }

        $currentIndex = $allLessons->search(function($lesson) use ($currentLesson) {
            return $lesson->id === $currentLesson->id;
        });

        return $currentIndex !== false && $currentIndex > 0 
            ? $allLessons[$currentIndex - 1] 
            : null;
    }

    /**
     * Get course statistics for student.
     */
    public function getCourseStats($courseId)
    {
        $course = Course::with(['sections.lessons'])->findOrFail($courseId);
        $userEnrolled = $course->users()->where('user_id', Auth::id())->exists();

        if (!$userEnrolled) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        $totalLessons = $course->publishedLessons()->count();
        $completedLessons = LessonProgress::whereIn('lesson_id', $course->publishedLessons()->pluck('id'))
            ->where('user_id', Auth::id())
            ->where('is_completed', true)
            ->count();

        $completionPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        return response()->json([
            'total_lessons' => $totalLessons,
            'completed_lessons' => $completedLessons,
            'completion_percentage' => $completionPercentage,
            'total_duration' => $course->total_duration,
            'sections_count' => $course->sections()->count(),
        ]);
    }
}
