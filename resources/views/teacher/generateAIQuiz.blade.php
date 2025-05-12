@extends('layouts.app')

@section('title', 'Generate AI Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <a href="{{ route('teacher.courses.show', $course->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Back to Course</span>
            </a>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Generate AI Quiz</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">For course: <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $course->title }}</span></p>
        </div>
        <div class="hidden md:block">
            <img src="{{ asset('images/ai-quiz.svg') }}" alt="AI Quiz" class="h-24 w-auto" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2021/2021396.png'; this.onerror=null;">
        </div>
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

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->has('ai_error'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-bold">AI Service Notice</p>
                            <p>{{ $errors->first('ai_error') }}</p>
                            <p class="mt-2 text-sm">Don't worry! The system will use a local fallback method to generate questions.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('teacher.generate-quiz.store', $course->id) }}" method="POST" class="space-y-6" id="quizForm">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quiz Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-file-alt text-gray-400"></i>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name', $course->title . ' Quiz') }}" class="pl-10 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Give your quiz a descriptive name</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <label for="num_questions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Number of Questions</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-list-ol text-gray-400"></i>
                            </div>
                            <select name="num_questions" id="num_questions" class="pl-10 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                @for ($i = 5; $i <= 20; $i += 5)
                                    <option value="{{ $i }}" {{ old('num_questions', 5) == $i ? 'selected' : '' }}>{{ $i }} questions</option>
                                @endfor
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">More questions = more comprehensive assessment</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty Level</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-signal text-gray-400"></i>
                            </div>
                            <select name="difficulty" id="difficulty" class="pl-10 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                <option value="easy" {{ old('difficulty', 'easy') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('difficulty', 'easy') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('difficulty', 'easy') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Adjust based on student knowledge level</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <label for="question_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-question-circle text-gray-400"></i>
                            </div>
                            <select name="question_type" id="question_type" class="pl-10 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                <option value="multiple_choice" {{ old('question_type', 'multiple_choice') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="true_false" {{ old('question_type', 'multiple_choice') == 'true_false' ? 'selected' : '' }}>True/False</option>
                                <option value="short_answer" {{ old('question_type', 'multiple_choice') == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Different types test different skills</p>
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.location.href='{{ route('teacher.courses.show', $course->id) }}'" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit" id="generateBtn" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                            <i class="fas fa-magic mr-2"></i> Generate Quiz
                        </button>
                    </div>
                </div>
            </form>

            <script>
                document.getElementById('quizForm').addEventListener('submit', function(e) {
                    // Show loading state
                    const generateBtn = document.getElementById('generateBtn');
                    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating...';
                    generateBtn.disabled = true;

                    // Add a hidden div that shows the loading state
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-center';
                    loadingDiv.innerHTML = `
                        <div class="animate-pulse flex flex-col items-center">
                            <i class="fas fa-robot text-4xl text-blue-500 mb-3"></i>
                            <p class="text-blue-600 dark:text-blue-400 font-medium">Generating your quiz questions...</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">This may take a few moments. Please don't close this page.</p>
                        </div>
                    `;

                    // Insert after the form
                    this.parentNode.insertBefore(loadingDiv, this.nextSibling);
                });
            </script>
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
                <p class="text-lg">Our AI Quiz Generator analyzes your course content and creates relevant questions based on the key concepts and learning objectives.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full mb-4 mx-auto">
                            <span class="text-blue-600 dark:text-blue-300 text-xl font-bold">1</span>
                        </div>
                        <h3 class="font-bold text-lg mb-3 text-blue-700 dark:text-blue-300 text-center">Configure</h3>
                        <p class="text-center">Choose the number of questions, difficulty level, and question type that best suits your assessment needs.</p>
                        <div class="mt-4 flex justify-center">
                            <i class="fas fa-sliders-h text-blue-400 text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full mb-4 mx-auto">
                            <span class="text-blue-600 dark:text-blue-300 text-xl font-bold">2</span>
                        </div>
                        <h3 class="font-bold text-lg mb-3 text-blue-700 dark:text-blue-300 text-center">Generate</h3>
                        <p class="text-center">Our AI analyzes your course content and creates relevant questions based on the key concepts.</p>
                        <div class="mt-4 flex justify-center">
                            <i class="fas fa-robot text-blue-400 text-2xl"></i>
                        </div>
                    </div>

                    <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full mb-4 mx-auto">
                            <span class="text-blue-600 dark:text-blue-300 text-xl font-bold">3</span>
                        </div>
                        <h3 class="font-bold text-lg mb-3 text-blue-700 dark:text-blue-300 text-center">Review & Edit</h3>
                        <p class="text-center">Review the generated questions, make any necessary edits, and publish the quiz for your students.</p>
                        <div class="mt-4 flex justify-center">
                            <i class="fas fa-check-circle text-blue-400 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-800 p-6 rounded-lg border-l-4 border-yellow-400 shadow-sm">
                    <h3 class="font-bold text-lg mb-3 text-yellow-700 dark:text-yellow-300 flex items-center">
                        <i class="fas fa-star mr-2"></i> Tips for Best Results
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <p class="ml-2 text-gray-700 dark:text-gray-300">Ensure your course content is comprehensive and well-structured</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <p class="ml-2 text-gray-700 dark:text-gray-300">Start with a smaller number of questions to test the quality</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <p class="ml-2 text-gray-700 dark:text-gray-300">Review all generated questions before publishing to students</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <p class="ml-2 text-gray-700 dark:text-gray-300">Mix different difficulty levels for a balanced assessment</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-center">
                    <p class="text-blue-600 dark:text-blue-400 font-medium">Ready to create your first AI-generated quiz?</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Fill out the form above and click "Generate Quiz" to get started!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center text-gray-500 dark:text-gray-400 text-sm">
        <p>© 2025 BrightPath Learning Platform. All rights reserved.</p>
    </div>
</div>
@endsection
