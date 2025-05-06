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
        $this->middleware(\App\Http\Middleware\CheckRole::class.':student');
    }

    /**
     * Show the student dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // Get statistics
        $stats = [
            'enrolledCourses' => $user->enrollments()->count(),
            'completedLessons' => $user->completedLessons()->count(),
            'passedQuizzes' => $user->quizResults()->where('passed', true)->count(),
            'totalQuizzes' => $user->quizResults()->count(),
            'averageScore' => $user->quizResults()->avg('score') ?? 0,
            'studyTime' => $user->enrollments()->sum('study_time') ?? 0, // Assuming you track study time
            'lastActivity' => $user->enrollments()->max('last_accessed_at'),
        ];

        // Get total courses count
        $totalCourses = $user->enrollments()->count();

        // Get completed courses count
        $completedCourses = $user->enrollments()->where('status', 'completed')->count();

        // Get enrollments for display
        $enrollments = $user->enrollments()
            ->with('course.teacher')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get recent courses
        $recentCourses = $user->enrollments()
            ->with('course.teacher')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Get recent quiz results
        $recentResults = $user->quizResults()
            ->with('quiz.lesson.module.course')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Rename for template compatibility
        $recentQuizResults = $recentResults;

        // Get continue learning data
        $continueLearning = $user->enrollments()
            ->with(['course', 'lastAccessedLesson'])
            ->where('status', 'active')
            ->orderBy('last_accessed_at', 'desc')
            ->first();

        if ($continueLearning) {
            $continueLearning->completed_lessons_count = $user->completedLessons()
                ->whereHas('module', function ($query) use ($continueLearning) {
                    $query->where('course_id', $continueLearning->course_id);
                })
                ->count();

            $continueLearning->total_lessons_count = Lesson::whereHas('module', function ($query) use ($continueLearning) {
                $query->where('course_id', $continueLearning->course_id);
            })->count();

            $continueLearning->progress = $continueLearning->total_lessons_count > 0
                ? round(($continueLearning->completed_lessons_count / $continueLearning->total_lessons_count) * 100)
                : 0;
        }

        // Get recommended courses (courses that the student is not enrolled in)
        $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();
        $recommendedCourses = Course::where('status', 'active')
            ->whereNotIn('id', $enrolledCourseIds)
            ->with('teacher')
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('student.dashboard', compact(
            'stats',
            'recentCourses',
            'recentResults',
            'continueLearning',
            'totalCourses',
            'completedCourses',
            'enrollments',
            'recentQuizResults',
            'recommendedCourses'
        ));
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

        // Get completed lessons
        $completedLessonIds = $user->completedLessons()
            ->whereHas('module', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->pluck('id')
            ->toArray();

        // Calculate progress
        $totalLessons = Lesson::whereHas('module', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->count();

        $completedLessons = count($completedLessonIds);
        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        // Get current module and lesson if any
        $currentLesson = null;
        $currentModule = null;

        if ($enrollment->last_accessed_lesson_id) {
            $currentLesson = Lesson::find($enrollment->last_accessed_lesson_id);
            if ($currentLesson) {
                $currentModule = $currentLesson->module;
            }
        }

        return view('student.courses.show', compact(
            'course',
            'modules',
            'enrollment',
            'completedLessonIds',
            'completedLessons',
            'totalLessons',
            'progress',
            'currentLesson',
            'currentModule'
        ));
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

        // Update last accessed lesson
        $enrollment->update([
            'last_accessed_lesson_id' => $lesson->id,
            'last_accessed_at' => now()
        ]);

        // Get completed lessons
        $completedLessonIds = $user->completedLessons()
            ->whereHas('module', function ($query) use ($module) {
                $query->where('course_id', $module->course_id);
            })
            ->pluck('id')
            ->toArray();

        // Get previous and next lessons for navigation
        $previousLesson = Lesson::where('module_id', $lesson->module_id)
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();

        $nextLesson = Lesson::where('module_id', $lesson->module_id)
            ->where('order', '>', $lesson->order)
            ->orderBy('order', 'asc')
            ->first();

        if (!$nextLesson) {
            // If no next lesson in current module, get first lesson of next module
            $nextModule = Module::where('course_id', $module->course_id)
                ->where('order', '>', $module->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextModule) {
                $nextLesson = Lesson::where('module_id', $nextModule->id)
                    ->orderBy('order', 'asc')
                    ->first();
            }
        }

        if (!$previousLesson) {
            // If no previous lesson in current module, get last lesson of previous module
            $previousModule = Module::where('course_id', $module->course_id)
                ->where('order', '<', $module->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($previousModule) {
                $previousLesson = Lesson::where('module_id', $previousModule->id)
                    ->orderBy('order', 'desc')
                    ->first();
            }
        }

        // Get current module for sidebar
        $currentModule = $lesson->module;

        return view('student.lessons.show', compact(
            'lesson',
            'completedLessonIds',
            'previousLesson',
            'nextLesson',
            'currentModule'
        ));
    }

    /**
     * Mark a lesson as completed.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeLesson(Lesson $lesson)
    {
        $user = auth()->user();
        $module = $lesson->module;
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $module->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        // Add lesson to completed lessons
        $user->completedLessons()->syncWithoutDetaching([$lesson->id => ['completed_at' => now()]]);

        // Check if all lessons in the course are completed
        $totalLessons = Lesson::whereHas('module', function ($query) use ($module) {
            $query->where('course_id', $module->course_id);
        })->count();

        $completedLessons = $user->completedLessons()
            ->whereHas('module', function ($query) use ($module) {
                $query->where('course_id', $module->course_id);
            })
            ->count();

        // Update enrollment progress
        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        $enrollment->update(['progress' => $progress]);

        // If all lessons are completed, mark the enrollment as completed
        if ($progress == 100) {
            $enrollment->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Lesson marked as completed!');
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
    public function results(Request $request)
    {
        $user = auth()->user();

        // Get enrolled courses for filter
        $courses = Course::whereHas('enrollments', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Apply filters
        $resultsQuery = QuizResult::with(['quiz.lesson.module.course'])
            ->where('user_id', $user->id)
            ->where('status', 'completed');

        if ($request->filled('course_id')) {
            $resultsQuery->whereHas('quiz.lesson.module', function ($query) use ($request) {
                $query->where('course_id', $request->course_id);
            });
        }

        if ($request->filled('quiz_type')) {
            $resultsQuery->whereHas('quiz', function ($query) use ($request) {
                $query->where('type', $request->quiz_type);
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'passed') {
                $resultsQuery->where('passed', true);
            } elseif ($request->status === 'failed') {
                $resultsQuery->where('passed', false);
            }
        }

        // Get results
        $results = $resultsQuery->orderBy('created_at', 'desc')->paginate(10);

        // Get statistics
        $stats = [
            'total' => QuizResult::where('user_id', $user->id)->where('status', 'completed')->count(),
            'passed' => QuizResult::where('user_id', $user->id)->where('status', 'completed')->where('passed', true)->count(),
            'failed' => QuizResult::where('user_id', $user->id)->where('status', 'completed')->where('passed', false)->count(),
        ];

        return view('student.results.index', compact('results', 'courses', 'stats'));
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

        // Get the student's answers for this quiz
        $answers = StudentAnswer::with(['question.options', 'option'])
            ->where('user_id', $user->id)
            ->whereHas('question', function ($query) use ($quiz) {
                $query->where('quiz_id', $quiz->id);
            })
            ->get();

        return view('student.results.show', compact('quizResult', 'quiz', 'answers'));
    }

    /**
     * Auto-save quiz progress.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\JsonResponse
     */
    public function autosaveQuiz(Request $request, Quiz $quiz)
    {
        $user = auth()->user();

        // Check if the student is enrolled in the course
        $lesson = $quiz->lesson;
        $module = $lesson->module;
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $module->course_id)
            ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'You are not enrolled in this course'], 403);
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

        // Process each question's answer
        $questions = $request->input('questions', []);

        foreach ($questions as $questionId => $data) {
            if (isset($data['answer'])) {
                // For multiple choice and true/false questions
                StudentAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $questionId
                    ],
                    [
                        'option_id' => $data['answer'],
                        'is_correct' => null // Will be evaluated on final submission
                    ]
                );
            } elseif (isset($data['answer_text'])) {
                // For short answer questions
                StudentAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $questionId
                    ],
                    [
                        'text_answer' => $data['answer_text'],
                        'is_correct' => null // Will be evaluated on final submission
                    ]
                );
            }
        }

        // Update the time spent
        if ($request->has('time_spent')) {
            $quizResult->update([
                'time_spent' => $request->time_spent
            ]);
        }

        return response()->json(['success' => true]);
    }
}
