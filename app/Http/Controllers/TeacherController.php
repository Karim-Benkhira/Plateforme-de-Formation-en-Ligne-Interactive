<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\User;
use App\Models\QuizResult;
use App\Services\AIService;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    protected $aiService;
    protected $analyticsService;

    public function __construct()
    {
        try {
            $this->aiService = app(\App\Services\AIService::class);
            $this->analyticsService = app(\App\Services\AnalyticsService::class);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error initializing services: ' . $e->getMessage());
            // Create empty service instances to prevent errors
            $this->aiService = new \stdClass();
            $this->analyticsService = new \stdClass();
        }
    }

    /**
     * Show the teacher dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $coursesCount = Course::where('creator_id', $user->id)->count();
        $quizzesCount = Quiz::whereIn('course_id', function($query) use ($user) {
            $query->select('id')->from('courses')->where('creator_id', $user->id);
        })->count();

        $studentCount = DB::table('quiz_results')
            ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->where('courses.creator_id', $user->id)
            ->distinct('quiz_results.user_id')
            ->count('quiz_results.user_id');

        $recentQuizResults = QuizResult::join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->join('users', 'quiz_results.user_id', '=', 'users.id')
            ->where('courses.creator_id', $user->id)
            ->select('quiz_results.*', 'quizzes.name as quiz_name', 'users.username as student_name')
            ->orderBy('quiz_results.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('teacher.dashboard', [
            'coursesCount' => $coursesCount,
            'quizzesCount' => $quizzesCount,
            'studentCount' => $studentCount,
            'recentQuizResults' => $recentQuizResults
        ]);
    }

    /**
     * Show the courses created by the teacher.
     */
    public function showCourses()
    {
        $courses = Course::where('creator_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('teacher.courses', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form to create a new course.
     */
    public function createCourse()
    {
        $categories = Category::all();
        return view('teacher.createCourse', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the details of a specific course.
     */
    public function showCourse($id)
    {
        $course = Course::where('id', $id)
            ->where('creator_id', Auth::id())
            ->with('category')
            ->firstOrFail();

        $quizzes = Quiz::where('course_id', $id)->get();

        return view('teacher.courseDetails', [
            'course' => $course,
            'quizzes' => $quizzes
        ]);
    }

    /**
     * Show the quizzes created by the teacher.
     */
    public function showQuizzes()
    {
        $quizzes = Quiz::whereIn('course_id', function($query) {
            $query->select('id')->from('courses')->where('creator_id', Auth::id());
        })
        ->with('course')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('teacher.quizzes', [
            'quizzes' => $quizzes
        ]);
    }

    /**
     * Show the form to create a new quiz.
     */
    public function createQuiz()
    {
        $courses = Course::where('creator_id', Auth::id())->get();
        return view('teacher.createQuiz', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form to generate an AI quiz.
     */
    public function showGenerateAIQuiz($courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        return view('teacher.generateAIQuiz', [
            'course' => $course
        ]);
    }

    /**
     * Show analytics for the teacher.
     */
    public function showAnalytics()
    {
        $user = Auth::user();
        $courses = Course::where('creator_id', $user->id)->get();

        try {
            if (method_exists($this->analyticsService, 'getCoursePerformanceData')) {
                $coursePerformance = $this->analyticsService->getCoursePerformanceData($courses->pluck('id')->toArray());
            } else {
                $coursePerformance = [];
            }

            if (method_exists($this->analyticsService, 'getStudentProgressData')) {
                $studentProgress = $this->analyticsService->getStudentProgressData($courses->pluck('id')->toArray());
            } else {
                $studentProgress = [];
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in analytics: ' . $e->getMessage());
            $coursePerformance = [];
            $studentProgress = [];
        }

        return view('teacher.analytics', [
            'courses' => $courses,
            'coursePerformance' => $coursePerformance,
            'studentProgress' => $studentProgress
        ]);
    }

    /**
     * Show analytics for a specific course.
     */
    public function showCourseAnalytics($courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $quizzes = Quiz::where('course_id', $courseId)->get();

        try {
            if (method_exists($this->analyticsService, 'getQuizPerformanceData')) {
                $quizPerformance = $this->analyticsService->getQuizPerformanceData($quizzes->pluck('id')->toArray());
            } else {
                $quizPerformance = [];
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in quiz analytics: ' . $e->getMessage());
            $quizPerformance = [];
        }

        return view('teacher.courseAnalytics', [
            'course' => $course,
            'quizzes' => $quizzes,
            'quizPerformance' => $quizPerformance
        ]);
    }
}
