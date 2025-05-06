<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\CheckRole::class.':teacher');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizId = request('quiz_id');

        if (!$quizId) {
            return redirect()->back()->with('error', 'Quiz ID is required.');
        }

        $quiz = Quiz::findOrFail($quizId);

        // Check if the teacher owns this quiz
        if ($quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add questions to this quiz.');
        }

        return view('teacher.questions.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|numeric|min:0.1',
            'feedback' => 'nullable|string',
        ]);

        $quiz = Quiz::findOrFail($request->quiz_id);

        // Check if the teacher owns this quiz
        if ($quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add questions to this quiz.');
        }

        DB::beginTransaction();

        try {
            // Create the question
            $question = Question::create([
                'quiz_id' => $request->quiz_id,
                'question_text' => $request->question_text,
                'type' => $request->type,
                'points' => $request->points,
                'feedback' => $request->feedback,
            ]);

            // Process options based on question type
            if ($request->type === 'multiple_choice') {
                $this->processMultipleChoiceOptions($request, $question);
            } elseif ($request->type === 'true_false') {
                $this->processTrueFalseOptions($request, $question);
            } elseif ($request->type === 'short_answer') {
                $this->processShortAnswerOptions($request, $question);
            }

            DB::commit();

            return redirect()->route('teacher.quizzes.edit', $quiz)
                ->with('success', 'Question created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to create question: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Process multiple choice options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return void
     */
    private function processMultipleChoiceOptions(Request $request, Question $question)
    {
        $options = $request->input('options', []);
        $correctOption = $request->input('correct_option');

        if (empty($options) || !$correctOption) {
            throw new \Exception('Options and correct option are required for multiple choice questions.');
        }

        foreach ($options as $key => $option) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $option['text'],
                'is_correct' => $key == $correctOption,
            ]);
        }
    }

    /**
     * Process true/false options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return void
     */
    private function processTrueFalseOptions(Request $request, Question $question)
    {
        $isTrue = $request->input('true_false_answer') === 'true';

        // Create True option
        Option::create([
            'question_id' => $question->id,
            'option_text' => 'True',
            'is_correct' => $isTrue,
        ]);

        // Create False option
        Option::create([
            'question_id' => $question->id,
            'option_text' => 'False',
            'is_correct' => !$isTrue,
        ]);
    }

    /**
     * Process short answer options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return void
     */
    private function processShortAnswerOptions(Request $request, Question $question)
    {
        $answer = $request->input('short_answer');

        if (empty($answer)) {
            throw new \Exception('Answer is required for short answer questions.');
        }

        Option::create([
            'question_id' => $question->id,
            'option_text' => $answer,
            'is_correct' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        // Check if the teacher owns this question
        if ($question->quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this question.');
        }

        return view('teacher.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|numeric|min:0.1',
            'feedback' => 'nullable|string',
        ]);

        // Check if the teacher owns this question
        if ($question->quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this question.');
        }

        DB::beginTransaction();

        try {
            // Update the question
            $question->update([
                'question_text' => $request->question_text,
                'type' => $request->type,
                'points' => $request->points,
                'feedback' => $request->feedback,
            ]);

            // Delete existing options
            $question->options()->delete();

            // Process options based on question type
            if ($request->type === 'multiple_choice') {
                $this->processMultipleChoiceOptions($request, $question);
            } elseif ($request->type === 'true_false') {
                $this->processTrueFalseOptions($request, $question);
            } elseif ($request->type === 'short_answer') {
                $this->processShortAnswerOptions($request, $question);
            }

            DB::commit();

            return redirect()->route('teacher.quizzes.edit', $question->quiz)
                ->with('success', 'Question updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Failed to update question: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // Check if the teacher owns this question
        if ($question->quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this question.');
        }

        $quizId = $question->quiz_id;

        // Delete the question (options will be deleted via cascade)
        $question->delete();

        return redirect()->route('teacher.quizzes.edit', $quizId)
            ->with('success', 'Question deleted successfully.');
    }
}
