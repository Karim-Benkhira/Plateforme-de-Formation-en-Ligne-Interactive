@extends('layouts.student')

@section('title', 'Exam Access')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ $quiz->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $quiz->description }}
                </p>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <h3 class="font-semibold text-blue-900 dark:text-blue-100">Exam Information</h3>
                        <p class="text-blue-700 dark:text-blue-300 text-sm mt-1">
                            Duration: {{ $quiz->duration }} minutes |
                            Passing Score: {{ $quiz->passing_score }}% |
                            Questions: {{ $quiz->questions->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('student.quiz', ['id' => $quiz->id]) }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-play mr-2"></i>
                    Start Exam
                </a>
            </div>
        </div>
    </div>
</div>
@endsection



