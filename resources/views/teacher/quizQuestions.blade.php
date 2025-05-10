@extends('layouts.app')

@section('title', 'Quiz Questions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('teacher.quizzes') }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Questions for: {{ $quiz->name }}</h1>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('teacher.createQuestion', $quiz->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Question
            </a>
            <a href="{{ route('teacher.generate-quiz', $quiz->course->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-magic mr-2"></i> AI Generate
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Quiz Information</h2>
                <p class="text-gray-600 dark:text-gray-400">Course: {{ $quiz->course->title }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $quiz->is_published ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
                    {{ $quiz->is_published ? 'Published' : 'Draft' }}
                </span>
                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    <i class="fas fa-edit"></i> Edit Quiz
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400">Questions</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->questions->count() }}</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->duration ?? 'N/A' }} min</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400">Passing Score</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->passing_score ?? 'N/A' }}%</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if($quiz->questions->count() > 0)
        <div class="space-y-6">
            @foreach($quiz->questions as $index => $question)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Question {{ $index + 1 }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('teacher.editQuestion', $question->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('teacher.deleteQuestion', $question->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-800 dark:text-white font-medium mb-4">{{ $question->question }}</p>
                        
                        @if($question->type === 'short_answer' || !$question->type)
                            <div class="ml-4 mt-2">
                                <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-md">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                        <span class="font-bold">Correct Answer:</span> {{ $question->answers }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="ml-4 space-y-2">
                                @php
                                    $answers = explode(',', $question->answers);
                                @endphp
                                
                                @foreach($answers as $answerIndex => $answer)
                                    <div class="flex items-center">
                                        <div class="flex items-center h-5">
                                            <input type="radio" disabled {{ $answerIndex == $question->correct ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label class="font-medium text-gray-700 dark:text-gray-300 {{ $answerIndex == $question->correct ? 'text-green-600 dark:text-green-400 font-bold' : '' }}">
                                                {{ $answer }}
                                                @if($answerIndex == $question->correct)
                                                    <span class="ml-2 text-green-600 dark:text-green-400">(Correct)</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8 flex justify-between items-center">
            <p class="text-gray-600 dark:text-gray-400">Total: {{ $quiz->questions->count() }} questions</p>
            
            @if(!$quiz->is_published)
                <form action="{{ route('teacher.quizzes.update', $quiz->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ $quiz->name }}">
                    <input type="hidden" name="course_id" value="{{ $quiz->course_id }}">
                    <input type="hidden" name="description" value="{{ $quiz->description }}">
                    <input type="hidden" name="duration" value="{{ $quiz->duration ?? 30 }}">
                    <input type="hidden" name="passing_score" value="{{ $quiz->passing_score ?? 70 }}">
                    <input type="hidden" name="attempts_allowed" value="{{ $quiz->attempts_allowed ?? 1 }}">
                    <input type="hidden" name="is_published" value="1">
                    <input type="hidden" name="requires_face_verification" value="{{ $quiz->requires_face_verification ? '1' : '0' }}">
                    
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-check-circle mr-2"></i> Publish Quiz
                    </button>
                </form>
            @endif
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center">
            <div class="text-gray-400 dark:text-gray-500 mb-4">
                <i class="fas fa-question-circle text-6xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-300 mb-2">No Questions Yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">This quiz doesn't have any questions yet. Add some questions to get started.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('teacher.createQuestion', $quiz->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i> Add Question Manually
                </a>
                <a href="{{ route('teacher.generate-quiz', $quiz->course->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-magic mr-2"></i> Generate with AI
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
