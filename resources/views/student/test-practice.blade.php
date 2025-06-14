@extends('layouts.student')

@section('title', 'Test AI Practice Questions')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Test AI Practice Questions</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Test the AI practice questions system</p>
    </div>

    <!-- Test Buttons -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- AI Quiz Course 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">AI Quiz - Course 1</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Take an AI-generated quiz for course 1</p>
            <a href="{{ route('student.ai.quiz', 1) }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-brain mr-2"></i> AI Quiz Course 1
            </a>
        </div>

        <!-- AI Quiz Course 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">AI Quiz - Course 2</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Take an AI-generated quiz for course 2</p>
            <a href="{{ route('student.ai.quiz', 2) }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-brain mr-2"></i> AI Quiz Course 2
            </a>
        </div>

        <!-- AI Quiz Course 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">AI Quiz - Course 3</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Take an AI-generated quiz for course 3</p>
            <a href="{{ route('student.ai.quiz', 3) }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-brain mr-2"></i> AI Quiz Course 3
            </a>
        </div>

        <!-- Practice Questions (Old System) -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Practice Questions</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Access the practice questions system</p>
            <a href="{{ route('student.practice.dashboard', 1) }}"
               class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Practice Questions
            </a>
        </div>
    </div>

    <!-- Current User Info -->
    <div class="mt-8 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Current User Info:</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            User: {{ Auth::user()->username }} (ID: {{ Auth::user()->id }})
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Role: {{ Auth::user()->role }}
        </p>
    </div>

    <!-- Available Courses -->
    <div class="mt-8 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Available Courses:</h4>
        @php
            $courses = \App\Models\Course::take(5)->get();
        @endphp
        @foreach($courses as $course)
            <div class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-600 last:border-b-0">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $course->title }} (ID: {{ $course->id }})
                </span>
                <a href="{{ route('student.practice.dashboard', $course->id) }}" 
                   class="text-purple-600 hover:text-purple-700 text-sm">
                    Test Practice
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
