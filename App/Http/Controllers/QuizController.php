<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;

class QuizController extends Controller
{
    public function createQuiz() {
        $courses = Course::all();
        return view('admin.createQuiz', compact('courses'));
    }

    public function storeQuiz(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
        ]);

        Quiz::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz created successfully.');
    }

    public function editQuiz($id) {
        $quiz = Quiz::findOrFail($id);
        $courses = Course::all();
        return view('admin.editQuiz', compact('quiz', 'courses'));
    }

    public function updateQuiz(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id', 
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update([
            'name' => $request->name,
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz updated successfully.');
    }

    public function deleteQuiz($id) {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('admin.quizzes')->with('success', 'Quiz deleted successfully.');
    }

    public function createQuestion($quizId) {
        return view('admin.createQuestion', compact('quizId'));
    }

    public function storeQuestion(Request $request, $quizId) {
        $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|string',
            'correct' => 'required|integer|min:0',
        ]);

        $answersArray = explode(',', $request->answers);

        if ($request->correct < 0 || $request->correct >= count($answersArray) + 1) {
            return redirect()->back()->withErrors(['correct' => 'The correct answer index is out of bounds.'])->withInput();
        }

        $question = new Question();
        $question->quiz_id = $quizId;
        $question->question = $request->question;
        $question->answers = $request->answers;
        $question->correct = $request->correct - 1;
        $question->save();

        return redirect()->route('admin.quizQuestions', $quizId)->with('success', 'Question added successfully.');
    }

    public function editQuestion($id) {
        $question = Question::findOrFail($id);
        return view('admin.editQuestion', compact('question'));
    }

    public function updateQuestion(Request $request, $id) {
        $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|string',
            'correct' => 'required|integer|min:0',
        ]);

        $answersArray = explode(',', $request->answers);

        if ($request->correct < 0 || $request->correct - 1 >= count($answersArray)) {
            return redirect()->back()->withErrors(['correct' => 'The correct answer index is out of bounds.'])->withInput();
        }

        if (count($answersArray) < 2) {
            return redirect()->back()->withErrors(['answers' => 'There must be at least two answers.'])->withInput();
        }

        $question = Question::findOrFail($id);
        $question->question = $request->question;
        $question->answers = $request->answers;
        $question->correct = $request->correct - 1;
        $question->save();
        
        return redirect()->route('admin.quizQuestions', $question->quiz_id)->with('success', 'Question updated successfully.');
    }

    public function deleteQuestion($id) {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id;
        $question->delete();

        return redirect()->route('admin.quizQuestions', $quizId)->with('success', 'Question deleted successfully.');
    }

    public function takeQuiz($id) {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('student.quiz', compact('quiz'));
    }

    public function submitQuiz(Request $request)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'integer',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);
    
        $quiz = Quiz::with('questions', 'course')->findOrFail($request->quiz_id);
        $questions = $quiz->questions;
    
        $correctAnswersCount = 0;
    
        foreach ($questions as $question) {
            if (isset($request->answers[$question->id])) {
                $selectedAnswerIndex = $request->answers[$question->id];
    
                if ($selectedAnswerIndex == $question->correct) {
                    $correctAnswersCount++;
                }
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
        $result->save();

        return view('student.QuizResults', [
            'quizName' => $quiz->name,
            'score' => $totalScore,
            'correctAnswers' => $correctAnswersCount,
            'totalQuestions' => count($questions)
        ]);
    }
}