<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;
use App\Services\AIQuizService;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function createQuiz() {
        $courses = Course::all();

        // Determine the view based on user role
        if (auth()->user()->role === 'admin') {
            return view('admin.createQuiz-new', compact('courses'));
        } else {
            return view('teacher.createQuiz', compact('courses'));
        }
    }

    public function storeQuiz(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1|max:180',
            'passing_score' => 'required|integer|min:1|max:100',
            'attempts_allowed' => 'required|integer|min:1|max:10',
            'is_published' => 'nullable|boolean',
            'requires_face_verification' => 'nullable|boolean',
        ]);

        $quiz = new Quiz();
        $quiz->name = $request->name;
        $quiz->course_id = $request->course_id;
        $quiz->description = $request->description;
        $quiz->duration = $request->duration;
        $quiz->passing_score = $request->passing_score;
        $quiz->attempts_allowed = $request->attempts_allowed;
        $quiz->is_published = $request->boolean('is_published');
        $quiz->requires_face_verification = $request->boolean('requires_face_verification');
        $quiz->creator_id = auth()->id();
        $quiz->save();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizzes' : 'teacher.quizzes';

        return redirect()->route($redirectRoute)->with('success', 'Quiz created successfully. Now add questions to your quiz.');
    }

    public function editQuiz($id) {
        $quiz = Quiz::findOrFail($id);
        $courses = Course::all();

        // Determine the view based on user role
        $view = auth()->user()->role === 'admin' ? 'admin.editQuiz' : 'teacher.editQuiz';

        return view($view, compact('quiz', 'courses'));
    }

    public function updateQuiz(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1|max:180',
            'passing_score' => 'required|integer|min:1|max:100',
            'attempts_allowed' => 'required|integer|min:1|max:10',
            'is_published' => 'nullable|boolean',
            'requires_face_verification' => 'nullable|boolean',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->name = $request->name;
        $quiz->course_id = $request->course_id;
        $quiz->description = $request->description;
        $quiz->duration = $request->duration;
        $quiz->passing_score = $request->passing_score;
        $quiz->attempts_allowed = $request->attempts_allowed;
        $quiz->is_published = $request->boolean('is_published');
        $quiz->requires_face_verification = $request->boolean('requires_face_verification');
        $quiz->save();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizzes' : 'teacher.quizzes';

        return redirect()->route($redirectRoute)->with('success', 'Quiz updated successfully.');
    }

    public function deleteQuiz($id) {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizzes' : 'teacher.quizzes';

        return redirect()->route($redirectRoute)->with('success', 'Quiz deleted successfully.');
    }

    public function showQuizQuestions($quizId) {
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        // Determine the view based on user role
        $view = auth()->user()->role === 'admin' ? 'admin.quizQuestions' : 'teacher.quizQuestions';

        return view($view, compact('quiz'));
    }

    public function createQuestion($quizId) {
        $quiz = Quiz::findOrFail($quizId);

        // Determine the view based on user role
        $view = auth()->user()->role === 'admin' ? 'admin.createQuestion' : 'teacher.createQuestion';

        return view($view, compact('quizId', 'quiz'));
    }

    public function storeQuestion(Request $request, $quizId) {
        $request->validate([
            'question' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
        ]);

        $quiz = Quiz::findOrFail($quizId);
        $question = new Question();
        $question->quiz_id = $quizId;
        $question->question = $request->question;
        $question->type = $request->question_type;

        if ($request->question_type === 'multiple_choice') {
            // Process multiple choice options
            $options = explode("\n", trim($request->options));
            $correctIndex = null;
            $cleanOptions = [];

            foreach ($options as $index => $option) {
                $option = trim($option);
                if (empty($option)) continue;

                if (strpos($option, '*') === 0) {
                    $correctIndex = count($cleanOptions);
                    $cleanOptions[] = substr($option, 1);
                } else {
                    $cleanOptions[] = $option;
                }
            }

            if (count($cleanOptions) < 2) {
                return redirect()->back()->withErrors(['options' => 'You must provide at least 2 options.'])->withInput();
            }

            if ($correctIndex === null) {
                return redirect()->back()->withErrors(['options' => 'You must mark one option as correct with an asterisk (*).'])->withInput();
            }

            $question->answers = implode(',', $cleanOptions);
            $question->correct = $correctIndex;

        } elseif ($request->question_type === 'true_false') {
            // Process true/false
            if (!$request->has('correct_tf')) {
                return redirect()->back()->withErrors(['correct_tf' => 'You must select the correct answer.'])->withInput();
            }

            $question->answers = 'True,False';
            $question->correct = $request->correct_tf === 'true' ? 0 : 1;

        } elseif ($request->question_type === 'short_answer') {
            // Process short answer
            if (empty($request->correct_answer)) {
                return redirect()->back()->withErrors(['correct_answer' => 'You must provide the correct answer.'])->withInput();
            }

            $question->answers = $request->correct_answer;
            $question->correct = 0; // Not used for short answer
        }

        $question->save();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizQuestions' : 'teacher.quizQuestions';

        return redirect()->route($redirectRoute, $quizId)->with('success', 'Question added successfully.');
    }

    public function editQuestion($id) {
        $question = Question::findOrFail($id);

        // Determine the view based on user role
        $view = auth()->user()->role === 'admin' ? 'admin.editQuestion' : 'teacher.editQuestion';

        return view($view, compact('question'));
    }

    public function updateQuestion(Request $request, $id) {
        $request->validate([
            'question' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
        ]);

        $question = Question::findOrFail($id);
        $question->question = $request->question;
        $question->type = $request->question_type;

        if ($request->question_type === 'multiple_choice') {
            // Process multiple choice options
            $options = explode("\n", trim($request->options));
            $correctIndex = null;
            $cleanOptions = [];

            foreach ($options as $index => $option) {
                $option = trim($option);
                if (empty($option)) continue;

                if (strpos($option, '*') === 0) {
                    $correctIndex = count($cleanOptions);
                    $cleanOptions[] = substr($option, 1);
                } else {
                    $cleanOptions[] = $option;
                }
            }

            if (count($cleanOptions) < 2) {
                return redirect()->back()->withErrors(['options' => 'You must provide at least 2 options.'])->withInput();
            }

            if ($correctIndex === null) {
                return redirect()->back()->withErrors(['options' => 'You must mark one option as correct with an asterisk (*).'])->withInput();
            }

            $question->answers = implode(',', $cleanOptions);
            $question->correct = $correctIndex;

        } elseif ($request->question_type === 'true_false') {
            // Process true/false
            if (!$request->has('correct_tf')) {
                return redirect()->back()->withErrors(['correct_tf' => 'You must select the correct answer.'])->withInput();
            }

            $question->answers = 'True,False';
            $question->correct = $request->correct_tf === 'true' ? 0 : 1;

        } elseif ($request->question_type === 'short_answer') {
            // Process short answer
            if (empty($request->correct_answer)) {
                return redirect()->back()->withErrors(['correct_answer' => 'You must provide the correct answer.'])->withInput();
            }

            $question->answers = $request->correct_answer;
            $question->correct = 0; // Not used for short answer
        }

        $question->save();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizQuestions' : 'teacher.quizQuestions';

        return redirect()->route($redirectRoute, $question->quiz_id)->with('success', 'Question updated successfully.');
    }

    public function deleteQuestion($id) {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id;
        $question->delete();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizQuestions' : 'teacher.quizQuestions';

        return redirect()->route($redirectRoute, $quizId)->with('success', 'Question deleted successfully.');
    }

    public function takeQuiz($id) {
        $quiz = Quiz::with(['questions', 'course', 'creator'])->findOrFail($id);
        return view('student.quiz-new', compact('quiz'));
    }

    public function submitQuiz(Request $request)
    {
        $request->validate([
            'answers' => 'required|array',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);

        $quiz = Quiz::with('questions', 'course')->findOrFail($request->quiz_id);
        $questions = $quiz->questions;

        $correctAnswersCount = 0;
        $questionDetails = [];

        foreach ($questions as $question) {
            if (isset($request->answers[$question->id])) {
                $userAnswer = $request->answers[$question->id];
                $isCorrect = false;

                // Check if the answer is correct based on question type
                if ($question->type === 'multiple_choice' || $question->type === 'true_false' || !$question->type) {
                    // For multiple choice and true/false, we expect an integer index
                    $isCorrect = (int) $userAnswer === (int) $question->correct;
                } elseif ($question->type === 'short_answer') {
                    // For short answer, we use the isCorrect method in the Question model
                    $isCorrect = $question->isCorrect($userAnswer);
                }

                if ($isCorrect) {
                    $correctAnswersCount++;
                }

                // Store question details for feedback
                $questionDetails[] = [
                    'question' => $question->question,
                    'type' => $question->type ?? 'multiple_choice',
                    'user_answer' => $userAnswer,
                    'correct_answer' => $question->type === 'short_answer' ?
                        $question->answers :
                        $question->getFormattedAnswers()[$question->correct] ?? '',
                    'is_correct' => $isCorrect
                ];
            }
        }

        $score = $quiz->course->score;
        $totalScore = $correctAnswersCount * $score / count($questions);

        $result = new QuizResult();
        $result->user_id = auth()->id();
        $result->quiz_id = $request->quiz_id;
        $result->correct_answers = $correctAnswersCount;
        $result->answers_count = count($questions);
        $result->score = $totalScore;
        $result->details = json_encode($questionDetails); // Store detailed results
        $result->save();

        return view('student.QuizResults-new', [
            'quizName' => $quiz->name,
            'score' => $totalScore,
            'correctAnswers' => $correctAnswersCount,
            'totalQuestions' => count($questions),
            'questionDetails' => $questionDetails
        ]);
    }

    /**
     * Show the form for generating AI quiz
     *
     * @param int $courseId
     * @return \Illuminate\View\View
     */
    public function showGenerateAIQuiz($courseId)
    {
        $course = Course::findOrFail($courseId);

        // Determine the view based on user role
        if (auth()->user()->role === 'admin') {
            return view('admin.generateAIQuiz-new', compact('course'));
        } else {
            return view('teacher.generateAIQuiz', compact('course'));
        }
    }

    /**
     * Generate quiz using AI
     *
     * @param Request $request
     * @param int $courseId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateAIQuiz(Request $request, $courseId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'num_questions' => 'required|integer|min:1|max:20',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
        ]);

        try {
            $course = Course::findOrFail($courseId);

            // Create the quiz
            $quiz = new Quiz();
            $quiz->name = $request->name;
            $quiz->course_id = $courseId;
            $quiz->is_ai_generated = true;
            $quiz->save();

            // Generate questions using AI
            $aiQuizService = new AIQuizService();
            $result = $aiQuizService->generateQuiz(
                $course,
                $request->num_questions,
                $request->difficulty,
                $request->question_type
            );

            if (!$result['success']) {
                return redirect()->back()->withErrors(['ai_error' => $result['message']])->withInput();
            }

            // Save the generated questions
            $success = $aiQuizService->saveQuizQuestions($quiz, $result['data'], $request->question_type);

            if (!$success) {
                return redirect()->back()->withErrors(['db_error' => 'Failed to save generated questions.'])->withInput();
            }

            // Determine the redirect route based on user role
            $redirectRoute = auth()->user()->role === 'admin' ? 'admin.quizQuestions' : 'teacher.quizQuestions';

            return redirect()->route($redirectRoute, $quiz->id)
                ->with('success', 'Quiz generated successfully with AI. Review the questions below.');

        } catch (\Exception $e) {
            Log::error('Error generating AI quiz: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while generating the quiz: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Preview AI generated questions before saving
     *
     * @param Request $request
     * @param int $courseId
     * @return \Illuminate\View\View
     */
    public function previewAIQuiz(Request $request, $courseId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'num_questions' => 'required|integer|min:1|max:20',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
        ]);

        try {
            $course = Course::findOrFail($courseId);

            // Generate questions using AI
            $aiQuizService = new AIQuizService();
            $result = $aiQuizService->generateQuiz(
                $course,
                $request->num_questions,
                $request->difficulty,
                $request->question_type
            );

            if (!$result['success']) {
                return redirect()->back()->withErrors(['ai_error' => $result['message']])->withInput();
            }

            // Determine the view based on user role
            if (auth()->user()->role === 'admin') {
                return view('admin.previewAIQuiz-new', [
                    'course' => $course,
                    'quizName' => $request->name,
                    'questions' => $result['data'],
                    'numQuestions' => $request->num_questions,
                    'difficulty' => $request->difficulty,
                    'questionType' => $request->question_type
                ]);
            } else {
                return view('teacher.previewAIQuiz', [
                    'course' => $course,
                    'quizName' => $request->name,
                    'questions' => $result['data'],
                    'numQuestions' => $request->num_questions,
                    'difficulty' => $request->difficulty,
                    'questionType' => $request->question_type
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error previewing AI quiz: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while previewing the quiz: ' . $e->getMessage()])->withInput();
        }
    }
}