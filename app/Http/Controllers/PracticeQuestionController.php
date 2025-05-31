<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\PracticeQuestion;
use App\Services\StudentPracticeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PracticeQuestionController extends Controller
{
    protected $practiceService;

    public function __construct(StudentPracticeService $practiceService)
    {
        $this->practiceService = $practiceService;
    }

    /**
     * Show practice questions dashboard for a course
     */
    public function dashboard($courseId)
    {
        $course = Course::findOrFail($courseId);
        $student = Auth::user();

        // Check eligibility
        $eligibility = $this->practiceService->canGeneratePracticeQuestions($student, $course);
        
        // Get existing questions and statistics
        $practiceData = $this->practiceService->getPracticeQuestions($student, $course);
        
        // Get recommendations
        $recommendations = $this->practiceService->getRecommendations($student, $course);

        return view('student.practice.dashboard', compact(
            'course',
            'eligibility',
            'practiceData',
            'recommendations'
        ));
    }

    /**
     * Show the form to generate new practice questions
     */
    public function showGenerateForm($courseId)
    {
        $course = Course::findOrFail($courseId);
        $student = Auth::user();

        // Check eligibility
        $eligibility = $this->practiceService->canGeneratePracticeQuestions($student, $course);
        
        if (!$eligibility['can_generate']) {
            return redirect()->route('student.showCourse', $courseId)
                ->with('error', $eligibility['message']);
        }

        return view('student.practice.generate', compact('course'));
    }

    /**
     * Generate new practice questions
     */
    public function generateQuestions(Request $request, $courseId)
    {
        $request->validate([
            'num_questions' => 'required|integer|min:5|max:20',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer,mixed',
            'language' => 'required|in:ar,en,fr'
        ]);

        $course = Course::findOrFail($courseId);
        $student = Auth::user();

        $options = [
            'num_questions' => $request->num_questions,
            'difficulty' => $request->difficulty,
            'question_type' => $request->question_type,
            'language' => $request->language
        ];

        $result = $this->practiceService->generatePracticeQuestions($student, $course, $options);

        if ($result['success']) {
            return redirect()->route('student.practice.dashboard', $courseId)
                ->with('success', $result['message'] . " تم توليد {$result['questions_count']} سؤال.");
        } else {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }
    }

    /**
     * Show practice session
     */
    public function practiceSession($courseId, Request $request)
    {
        $course = Course::findOrFail($courseId);
        $student = Auth::user();

        $filters = [];
        
        // Apply filters from request
        if ($request->has('type')) {
            $filters['type'] = $request->type;
        }
        
        if ($request->has('difficulty')) {
            $filters['difficulty'] = $request->difficulty;
        }
        
        if ($request->has('answered')) {
            $filters['answered'] = $request->answered === 'true';
        }

        $practiceData = $this->practiceService->getPracticeQuestions($student, $course, $filters);

        if (empty($practiceData['questions']) || $practiceData['questions']->isEmpty()) {
            return redirect()->route('student.practice.dashboard', $courseId)
                ->with('info', 'لا توجد أسئلة متاحة للتدريب. قم بتوليد أسئلة جديدة أولاً.');
        }

        return view('student.practice.session', compact('course', 'practiceData'));
    }

    /**
     * Show a single question for answering
     */
    public function showQuestion($courseId, $questionId)
    {
        $course = Course::findOrFail($courseId);
        $question = PracticeQuestion::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->findOrFail($questionId);

        return view('student.practice.question', compact('course', 'question'));
    }

    /**
     * Submit answer for a practice question
     */
    public function submitAnswer(Request $request, $courseId, $questionId)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $question = PracticeQuestion::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->findOrFail($questionId);

        $result = $this->practiceService->answerQuestion($question, $request->answer);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'is_correct' => $result['is_correct'],
                'correct_answer' => $result['correct_answer'],
                'explanation' => $result['explanation'],
                'message' => $result['message']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }

    /**
     * Show practice results and statistics
     */
    public function showResults($courseId)
    {
        $course = Course::findOrFail($courseId);
        $student = Auth::user();

        $practiceData = $this->practiceService->getPracticeQuestions($student, $course);
        $statistics = $practiceData['statistics'];

        // Get detailed results
        $answeredQuestions = PracticeQuestion::forUserAndCourse($student->id, $courseId)
            ->answered()
            ->orderBy('answered_at', 'desc')
            ->get();

        return view('student.practice.results', compact(
            'course',
            'statistics',
            'answeredQuestions'
        ));
    }

    /**
     * Delete all practice questions for a course (reset)
     */
    public function resetQuestions($courseId)
    {
        $student = Auth::user();
        
        PracticeQuestion::forUserAndCourse($student->id, $courseId)->delete();

        return redirect()->route('student.practice.dashboard', $courseId)
            ->with('success', 'تم حذف جميع الأسئلة التدريبية. يمكنك توليد أسئلة جديدة الآن.');
    }

    /**
     * Get practice questions via AJAX
     */
    public function getQuestions($courseId, Request $request)
    {
        $course = Course::findOrFail($courseId);
        $student = Auth::user();

        $filters = [];
        
        if ($request->has('type')) {
            $filters['type'] = $request->type;
        }
        
        if ($request->has('difficulty')) {
            $filters['difficulty'] = $request->difficulty;
        }
        
        if ($request->has('answered')) {
            $filters['answered'] = $request->answered === 'true';
        }

        $practiceData = $this->practiceService->getPracticeQuestions($student, $course, $filters);

        return response()->json([
            'success' => true,
            'questions' => $practiceData['questions'],
            'statistics' => $practiceData['statistics']
        ]);
    }

    /**
     * Get next unanswered question
     */
    public function getNextQuestion($courseId)
    {
        $student = Auth::user();
        
        $nextQuestion = PracticeQuestion::forUserAndCourse($student->id, $courseId)
            ->unanswered()
            ->first();

        if (!$nextQuestion) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد أسئلة متاحة للإجابة'
            ]);
        }

        return response()->json([
            'success' => true,
            'question' => $nextQuestion
        ]);
    }
}
