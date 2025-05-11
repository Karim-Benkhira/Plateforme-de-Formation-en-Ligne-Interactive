@extends('layouts.app')

@section('title', 'Quiz Questions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <a href="{{ route('teacher.quizzes') }}" class="mr-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 p-2 rounded-full transition duration-300">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                <span class="bg-primary-100 dark:bg-primary-900 p-2 rounded-full mr-3">
                    <i class="fas fa-question-circle text-primary-600 dark:text-primary-400"></i>
                </span>
                Questions for: {{ $quiz->name }}
            </h1>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('teacher.createQuestion', $quiz->id) }}" class="bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-300 shadow-sm">
                <i class="fas fa-plus mr-2"></i> Add Question
            </a>
            <a href="{{ route('teacher.generate-quiz', $quiz->course->id) }}" class="bg-gradient-to-r from-secondary-600 to-primary-600 hover:from-secondary-700 hover:to-primary-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-300 shadow-sm">
                <i class="fas fa-magic mr-2"></i> AI Generate
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-info-circle text-primary-600 dark:text-primary-400 mr-2"></i>
                    Quiz Information
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    <span class="font-medium">Course:</span> {{ $quiz->course->title }}
                </p>
            </div>
            <div class="flex items-center space-x-3 mt-4 md:mt-0">
                <span class="px-3 py-1 inline-flex items-center text-sm leading-5 font-semibold rounded-full {{ $quiz->is_published ? 'bg-primary-100 text-primary-800 dark:bg-primary-800 dark:text-primary-100' : 'bg-secondary-100 text-secondary-800 dark:bg-secondary-800 dark:text-secondary-100' }}">
                    <i class="fas {{ $quiz->is_published ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                    {{ $quiz->is_published ? 'Published' : 'Draft' }}
                </span>
                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 flex items-center">
                    <i class="fas fa-edit mr-1"></i> Edit Quiz
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800 flex items-center">
                <div class="bg-primary-100 dark:bg-primary-800 p-2 rounded-full mr-3">
                    <i class="fas fa-question text-primary-600 dark:text-primary-400"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Questions</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->questions->count() }}</p>
                </div>
            </div>

            <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800 flex items-center">
                <div class="bg-primary-100 dark:bg-primary-800 p-2 rounded-full mr-3">
                    <i class="fas fa-clock text-primary-600 dark:text-primary-400"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->duration ?? 'N/A' }} min</p>
                </div>
            </div>

            <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800 flex items-center">
                <div class="bg-primary-100 dark:bg-primary-800 p-2 rounded-full mr-3">
                    <i class="fas fa-percentage text-primary-600 dark:text-primary-400"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Passing Score</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quiz->passing_score ?? 'N/A' }}%</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-primary-100 border-l-4 border-primary-500 text-primary-700 p-4 mb-6 rounded-r-md shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-primary-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($quiz->questions->count() > 0)
        <div class="space-y-6">
            @foreach($quiz->questions as $index => $question)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300">
                    <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-question-circle mr-2"></i> Question {{ $index + 1 }}
                        </h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('teacher.editQuestion', $question->id) }}" class="text-white hover:text-gray-100 flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('teacher.deleteQuestion', $question->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white hover:text-gray-100 flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-800 dark:text-white font-medium mb-6 text-lg">{{ $question->question }}</p>

                        @if($question->type === 'short_answer' || !$question->type)
                            <div class="ml-4 mt-4">
                                <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800">
                                    <p class="text-sm font-medium text-primary-800 dark:text-primary-300 flex items-center">
                                        <i class="fas fa-check-circle text-primary-600 mr-2"></i>
                                        <span class="font-bold">Correct Answer:</span> {{ $question->answers }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="ml-4 space-y-3">
                                @php
                                    $answers = explode(',', $question->answers);
                                @endphp

                                @foreach($answers as $answerIndex => $answer)
                                    <div class="flex items-center p-3 rounded-lg {{ $answerIndex == $question->correct ? 'bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-800' : 'hover:bg-gray-50 dark:hover:bg-gray-750' }}">
                                        <div class="flex items-center h-5">
                                            <input type="radio" disabled {{ $answerIndex == $question->correct ? 'checked' : '' }} class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label class="font-medium text-gray-700 dark:text-gray-300 {{ $answerIndex == $question->correct ? 'text-primary-600 dark:text-primary-400 font-bold' : '' }}">
                                                {{ $answer }}
                                                @if($answerIndex == $question->correct)
                                                    <span class="ml-2 text-primary-600 dark:text-primary-400 inline-flex items-center">
                                                        <i class="fas fa-check-circle mr-1"></i> Correct
                                                    </span>
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

        <div class="mt-8 flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="bg-primary-100 dark:bg-primary-900/30 p-2 rounded-full mr-3">
                    <i class="fas fa-clipboard-list text-primary-600 dark:text-primary-400"></i>
                </div>
                <p class="text-gray-700 dark:text-gray-300 font-medium">Total: <span class="text-primary-600 dark:text-primary-400 font-bold">{{ $quiz->questions->count() }}</span> questions</p>
            </div>

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

                    <button type="submit" class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                        <i class="fas fa-check-circle mr-2"></i> Publish Quiz
                    </button>
                </form>
            @endif
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="bg-primary-100 dark:bg-primary-900/30 inline-block p-6 rounded-full mb-6">
                <i class="fas fa-question-circle text-6xl text-primary-600 dark:text-primary-400"></i>
            </div>
            <h3 class="text-2xl font-medium text-gray-700 dark:text-gray-300 mb-3">No Questions Yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">This quiz doesn't have any questions yet. Add some questions to get started and create an effective assessment.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('teacher.createQuestion', $quiz->id) }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                    <i class="fas fa-plus mr-2"></i> Add Question Manually
                </a>
                <a href="{{ route('teacher.generate-quiz', $quiz->course->id) }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-secondary-600 to-primary-600 hover:from-secondary-700 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 transition duration-300">
                    <i class="fas fa-magic mr-2"></i> Generate with AI
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
