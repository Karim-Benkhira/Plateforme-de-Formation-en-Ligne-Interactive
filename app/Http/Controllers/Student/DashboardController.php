<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\StudentAnswer;
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
        $this->middleware('role:student');
    }

    /**
     * Show the student dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $enrollments = $user->enrolledCourses;
        $totalCourses = $enrollments->count();
        $completedCourses = $enrollments->where('pivot.status', 'completed')->count();
        $recentQuizResults = $user->quizResults()->with('quiz')->latest()->take(5)->get();

        return view('student.dashboard', compact('enrollments', 'totalCourses', 'completedCourses', 'recentQuizResults'));
    }

    /**
     * Show the student's enrolled courses.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courses()
    {
        $user = auth()->user();
        $enrollments = Enrollment::with('course.teacher')
            ->where('user_id', $user->id)
            ->paginate(10);

        return view('student.courses.index', compact('enrollments'));
    }

    /**
     * Show a specific course for the student.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCourse(Course $course)
    {
        $user = auth()->user();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $modules = Module::with('lessons')
            ->where('course_id', $course->id)
            ->orderBy('order')
            ->get();

        return view('student.courses.show', compact('course', 'modules', 'enrollment'));
    }

    /**
     * Show a specific module for the student.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showModule(Module $module)
    {
        $user = auth()->user();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $module->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $lessons = Lesson::where('module_id', $module->id)
            ->orderBy('order')
            ->get();

        return view('student.modules.show', compact('module', 'lessons'));
    }

    /**
     * Show a specific lesson for the student.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showLesson(Lesson $lesson)
    {
        $user = auth()->user();
        $module = $lesson->module;
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $module->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $quizzes = Quiz::where('lesson_id', $lesson->id)->get();

        return view('student.lessons.show', compact('lesson', 'quizzes'));
    }

    /**
     * Show a specific quiz for the student.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showQuiz(Quiz $quiz)
    {
        $user = auth()->user();
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $module->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        // Check if the student has already completed this quiz
        $existingResult = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->where('status', 'completed')
            ->first();

        if ($existingResult) {
            return redirect()->route('student.results.show', $existingResult->id)
                ->with('info', 'You have already completed this quiz.');
        }

        // If the quiz requires face recognition, we need to verify the student's identity
        if ($quiz->requires_face_recognition) {
            return view('student.quizzes.verify', compact('quiz'));
        }

        $questions = $quiz->questions()->with('options')->get();

        // Create or get an in-progress quiz result
        $quizResult = QuizResult::firstOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'status' => 'in_progress'
            ],
            [
                'started_at' => now(),
                'max_score' => $quiz->getTotalPointsAttribute()
            ]
        );

        return view('student.quizzes.show', compact('quiz', 'questions', 'quizResult'));
    }

    /**
     * Submit a quiz.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $user = auth()->user();

        // Check if the student is enrolled in the course
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $module->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        // Get or create the quiz result
        $quizResult = QuizResult::firstOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'status' => 'in_progress'
            ],
            [
                'started_at' => now(),
                'max_score' => $quiz->getTotalPointsAttribute()
            ]
        );

        // Process each question
        $score = 0;
        $questions = $quiz->questions;

        foreach ($questions as $question) {
            $answerId = $request->input('question_' . $question->id);
            $textAnswer = $request->input('text_answer_' . $question->id);

            // For multiple choice questions
            if ($question->type != 'short_answer' && $answerId) {
                $option = $question->options()->find($answerId);
                $isCorrect = $option && $option->is_correct;

                StudentAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $question->id
                    ],
                    [
                        'option_id' => $answerId,
                        'is_correct' => $isCorrect
                    ]
                );

                if ($isCorrect) {
                    $score += $question->points;
                }
            }
            // For short answer questions
            elseif ($question->type == 'short_answer' && $textAnswer) {
                // For simplicity, we'll mark it as correct if it contains any of the correct options' text
                $correctOption = $question->options()->where('is_correct', true)->first();
                $isCorrect = false;

                if ($correctOption) {
                    // Simple check - if the answer contains the correct text (case insensitive)
                    $isCorrect = str_contains(strtolower($textAnswer), strtolower($correctOption->option_text));
                }

                StudentAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $question->id
                    ],
                    [
                        'text_answer' => $textAnswer,
                        'is_correct' => $isCorrect
                    ]
                );

                if ($isCorrect) {
                    $score += $question->points;
                }
            }
        }

        // Update the quiz result
        $quizResult->update([
            'score' => $score,
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        return redirect()->route('student.results.show', $quizResult->id)
            ->with('success', 'Quiz completed successfully!');
    }

    /**
     * Show the student's quiz results.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function results()
    {
        $user = auth()->user();
        $quizResults = QuizResult::with(['quiz.lesson.module.course'])
            ->where('user_id', $user->id)
            ->orderBy('completed_at', 'desc')
            ->paginate(10);

        return view('student.results.index', compact('quizResults'));
    }

    /**
     * Show a specific quiz result.
     *
     * @param  \App\Models\QuizResult  $quizResult
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showResult(QuizResult $quizResult)
    {
        $user = auth()->user();

        if ($quizResult->user_id !== $user->id) {
            abort(403, 'You do not have permission to view this result');
        }

        $quiz = $quizResult->quiz;
        $questions = $quiz->questions()->with(['options', 'studentAnswers' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        return view('student.results.show', compact('quizResult', 'quiz', 'questions'));
    }
}
