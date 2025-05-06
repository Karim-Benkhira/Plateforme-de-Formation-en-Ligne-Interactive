<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
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
        // Not needed as quizzes are accessed through lessons
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessonId = request('lesson_id');

        if (!$lessonId) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'Lesson ID is required to create a quiz.');
        }

        $lesson = Lesson::findOrFail($lessonId);

        // Check if the teacher owns this lesson
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add quizzes to this lesson.');
        }

        return view('teacher.quizzes.create', compact('lesson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'required|exists:lessons,id',
            'duration' => 'required|integer|min:1',
            'type' => 'required|in:practice,exam',
            'status' => 'required|in:open,closed',
            'requires_face_recognition' => 'nullable|boolean',
        ]);

        // Check if the teacher owns this lesson
        $lesson = Lesson::findOrFail($request->lesson_id);
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to add quizzes to this lesson.');
        }

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
            'duration' => $request->duration,
            'type' => $request->type,
            'status' => $request->status,
            'requires_face_recognition' => $request->has('requires_face_recognition'),
        ]);

        return redirect()->route('teacher.quizzes.edit', $quiz)
            ->with('success', 'Quiz created successfully. Now add some questions to it.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        // Check if the teacher owns this quiz
        if ($quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to view this quiz.');
        }

        return view('teacher.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        // Check if the teacher owns this quiz
        if ($quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to edit this quiz.');
        }

        // Get all lessons from courses owned by the teacher
        $lessons = Lesson::whereHas('module.course', function ($query) {
            $query->where('teacher_id', auth()->id());
        })->get();

        return view('teacher.quizzes.edit', compact('quiz', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Check if the teacher owns this quiz
        if ($quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to update this quiz.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'required|exists:lessons,id',
            'duration' => 'required|integer|min:1',
            'type' => 'required|in:practice,exam',
            'status' => 'required|in:open,closed',
            'requires_face_recognition' => 'nullable|boolean',
        ]);

        // Check if the teacher owns the target lesson
        $lesson = Lesson::findOrFail($request->lesson_id);
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to move this quiz to the selected lesson.');
        }

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
            'duration' => $request->duration,
            'type' => $request->type,
            'status' => $request->status,
            'requires_face_recognition' => $request->has('requires_face_recognition'),
        ]);

        return redirect()->route('teacher.quizzes.edit', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        // Check if the teacher owns this quiz
        if ($quiz->lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this quiz.');
        }

        $lessonId = $quiz->lesson_id;
        $quiz->delete();

        return redirect()->route('teacher.lessons.edit', $lessonId)
            ->with('success', 'Quiz deleted successfully.');
    }
}
