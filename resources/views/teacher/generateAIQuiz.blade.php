@extends('layouts.app')

@section('title', 'Generate AI Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Generate AI Quiz for {{ $course->title }}</h1>
        <a href="{{ route('teacher.courses.show', $course->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Course
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-robot mr-2"></i> AI Quiz Generator
            </h2>
        </div>
        <div class="p-6">
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Error</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teacher.generate-quiz.store', $course->id) }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quiz Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="num_questions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Number of Questions</label>
                        <select name="num_questions" id="num_questions" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            @for ($i = 5; $i <= 20; $i += 5)
                                <option value="{{ $i }}" {{ old('num_questions') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty Level</label>
                        <select name="difficulty" id="difficulty" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="question_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type</label>
                        <select name="question_type" id="question_type" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                            <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                            <option value="short_answer" {{ old('question_type') == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                        </select>
                    </div>
                </div>
                
                <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.location.href='{{ route('teacher.courses.show', $course->id) }}'" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <i class="fas fa-magic mr-2"></i> Generate Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-lightbulb mr-2"></i> How It Works
            </h2>
        </div>
        <div class="p-6">
            <div class="space-y-4 text-gray-700 dark:text-gray-300">
                <p>Our AI Quiz Generator analyzes your course content and creates relevant questions based on the key concepts and learning objectives.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-bold text-lg mb-2 text-blue-700 dark:text-blue-300 flex items-center">
                            <span class="bg-blue-200 dark:bg-blue-800 w-8 h-8 rounded-full flex items-center justify-center mr-2 text-blue-800 dark:text-blue-200">1</span>
                            Configure
                        </h3>
                        <p>Choose the number of questions, difficulty level, and question type that best suits your assessment needs.</p>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-bold text-lg mb-2 text-blue-700 dark:text-blue-300 flex items-center">
                            <span class="bg-blue-200 dark:bg-blue-800 w-8 h-8 rounded-full flex items-center justify-center mr-2 text-blue-800 dark:text-blue-200">2</span>
                            Generate
                        </h3>
                        <p>Our AI analyzes your course content and creates relevant questions based on the key concepts.</p>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="font-bold text-lg mb-2 text-blue-700 dark:text-blue-300 flex items-center">
                            <span class="bg-blue-200 dark:bg-blue-800 w-8 h-8 rounded-full flex items-center justify-center mr-2 text-blue-800 dark:text-blue-200">3</span>
                            Review & Edit
                        </h3>
                        <p>Review the generated questions, make any necessary edits, and publish the quiz for your students.</p>
                    </div>
                </div>
                
                <div class="mt-6 bg-yellow-50 dark:bg-gray-700 p-4 rounded-lg border-l-4 border-yellow-400">
                    <h3 class="font-bold text-lg mb-2 text-yellow-700 dark:text-yellow-300">Tips for Best Results</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Ensure your course content is comprehensive and well-structured</li>
                        <li>Start with a smaller number of questions to test the quality</li>
                        <li>Review all generated questions before publishing to students</li>
                        <li>Mix different difficulty levels for a balanced assessment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
