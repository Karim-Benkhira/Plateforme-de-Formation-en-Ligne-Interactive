@extends('layouts.app')

@section('title', 'Preview AI Generated Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Preview AI Generated Quiz</h1>
        <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Generator
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-robot mr-2"></i> AI Generated Quiz: {{ $quizName }}
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-purple-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h3 class="font-bold text-purple-700 dark:text-purple-300 mb-1">Course</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ $course->title }}</p>
                </div>
                
                <div class="bg-purple-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h3 class="font-bold text-purple-700 dark:text-purple-300 mb-1">Difficulty</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ ucfirst($difficulty) }}</p>
                </div>
                
                <div class="bg-purple-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h3 class="font-bold text-purple-700 dark:text-purple-300 mb-1">Question Type</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $questionType)) }}</p>
                </div>
            </div>
            
            <form action="{{ route('teacher.generate-quiz.store', $course->id) }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="{{ $quizName }}">
                <input type="hidden" name="num_questions" value="{{ $numQuestions }}">
                <input type="hidden" name="difficulty" value="{{ $difficulty }}">
                <input type="hidden" name="question_type" value="{{ $questionType }}">
                
                <div class="space-y-6">
                    @foreach($questions as $index => $question)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-bold text-gray-800 dark:text-white">Question {{ $index + 1 }}</h3>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($questionType) }}</span>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300">{{ $question['question'] }}</p>
                            </div>
                            
                            @if($questionType === 'multiple_choice')
                                <div class="ml-4 space-y-2">
                                    @foreach($question['options'] as $optionIndex => $option)
                                        <div class="flex items-center">
                                            <div class="flex items-center h-5">
                                                <input type="radio" disabled {{ $optionIndex === $question['correct_answer'] ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label class="font-medium text-gray-700 dark:text-gray-300 {{ $optionIndex === $question['correct_answer'] ? 'text-green-600 dark:text-green-400 font-bold' : '' }}">
                                                    {{ $option }}
                                                    @if($optionIndex === $question['correct_answer'])
                                                        <span class="ml-2 text-green-600 dark:text-green-400">(Correct)</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($questionType === 'true_false')
                                <div class="ml-4 space-y-2">
                                    <div class="flex items-center">
                                        <div class="flex items-center h-5">
                                            <input type="radio" disabled {{ $question['correct_answer'] === true ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label class="font-medium text-gray-700 dark:text-gray-300 {{ $question['correct_answer'] === true ? 'text-green-600 dark:text-green-400 font-bold' : '' }}">
                                                True
                                                @if($question['correct_answer'] === true)
                                                    <span class="ml-2 text-green-600 dark:text-green-400">(Correct)</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center h-5">
                                            <input type="radio" disabled {{ $question['correct_answer'] === false ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label class="font-medium text-gray-700 dark:text-gray-300 {{ $question['correct_answer'] === false ? 'text-green-600 dark:text-green-400 font-bold' : '' }}">
                                                False
                                                @if($question['correct_answer'] === false)
                                                    <span class="ml-2 text-green-600 dark:text-green-400">(Correct)</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @elseif($questionType === 'short_answer')
                                <div class="ml-4">
                                    <div class="mb-2">
                                        <input type="text" disabled placeholder="Student answer" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                    <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-md">
                                        <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                            <span class="font-bold">Correct Answer:</span> {{ $question['correct_answer'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-redo mr-2"></i> Generate New Quiz
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <i class="fas fa-save mr-2"></i> Save Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
