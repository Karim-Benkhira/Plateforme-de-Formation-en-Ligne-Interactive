@extends('layouts.student')

@section('title', 'Practice Results - ' . $course->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Practice Results</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $course->title }}</p>
            </div>
            <a href="{{ route('student.practice.dashboard', $course->id) }}" 
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Questions</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Correct Answers</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['correct'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Incorrect Answers</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['incorrect'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-percentage text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Accuracy Rate</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['accuracy'] }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Analysis -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                Performance Analysis
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Accuracy by Type -->
                <div class="text-center">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Accuracy by Question Type</h4>
                    <div class="space-y-3">
                        @php
                            $typeStats = $answeredQuestions->groupBy('type')->map(function($questions) {
                                $total = $questions->count();
                                $correct = $questions->where('is_correct', true)->count();
                                return [
                                    'total' => $total,
                                    'correct' => $correct,
                                    'accuracy' => $total > 0 ? round(($correct / $total) * 100, 1) : 0
                                ];
                            });
                        @endphp
                        
                        @foreach($typeStats as $type => $stats)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                </span>
                                <span class="text-sm font-medium {{ $stats['accuracy'] >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $stats['accuracy'] }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Accuracy by Difficulty -->
                <div class="text-center">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Accuracy by Difficulty Level</h4>
                    <div class="space-y-3">
                        @php
                            $difficultyStats = $answeredQuestions->groupBy('difficulty')->map(function($questions) {
                                $total = $questions->count();
                                $correct = $questions->where('is_correct', true)->count();
                                return [
                                    'total' => $total,
                                    'correct' => $correct,
                                    'accuracy' => $total > 0 ? round(($correct / $total) * 100, 1) : 0
                                ];
                            });
                        @endphp
                        
                        @foreach($difficultyStats as $difficulty => $stats)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ ucfirst($difficulty) }}
                                </span>
                                <span class="text-sm font-medium {{ $stats['accuracy'] >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $stats['accuracy'] }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Progress Over Time -->
                <div class="text-center">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Progress Over Time</h4>
                    <div class="text-2xl font-bold text-blue-600 mb-2">
                        {{ $statistics['answered'] }}/{{ $statistics['total'] }}
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $statistics['total'] > 0 ? ($statistics['answered'] / $statistics['total']) * 100 : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Completed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Answers -->
    @if($answeredQuestions->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    <i class="fas fa-history text-gray-500 mr-2"></i>
                    Recent Answers
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($answeredQuestions->take(10) as $question)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $question->is_correct ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $question->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <i class="fas {{ $question->is_correct ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                            {{ $question->is_correct ? 'Correct' : 'Incorrect' }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ml-2">
                                            {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>
                                    </div>
                                    
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">
                                        {{ Str::limit($question->question, 100) }}
                                    </h4>
                                    
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <p><strong>Your answer:</strong> {{ $question->user_answer }}</p>
                                        @if(!$question->is_correct)
                                            <p><strong>Correct answer:</strong> {{ $question->correct_answer }}</p>
                                        @endif
                                        @if($question->explanation)
                                            <p class="mt-1"><strong>Explanation:</strong> {{ Str::limit($question->explanation, 150) }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="ml-4 text-right">
                                    <p class="text-xs text-gray-500">{{ $question->answered_at->diffForHumans() }}</p>
                                    <a href="{{ route('student.practice.question', [$course->id, $question->id]) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($answeredQuestions->count() > 10)
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            Showing 10 of {{ $answeredQuestions->count() }} answers
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- No Results -->
        <div class="text-center py-12">
            <div class="mx-auto h-24 w-24 text-gray-400">
                <i class="fas fa-chart-bar text-6xl"></i>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No Results Yet</h3>
            <p class="mt-2 text-gray-500">You haven't answered any practice questions yet. Start practicing to see your results.</p>
            <div class="mt-6">
                <a href="{{ route('student.practice.session', $course->id) }}" class="btn-primary">
                    <i class="fas fa-play mr-2"></i>
                    Start Practice
                </a>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    @if($statistics['answered'] > 0)
        <div class="mt-8 flex flex-wrap gap-4 justify-center">
            @if($statistics['unanswered'] > 0)
                <a href="{{ route('student.practice.session', $course->id) }}" class="btn-primary">
                    <i class="fas fa-play mr-2"></i>
                    Continue Practice ({{ $statistics['unanswered'] }} questions remaining)
                </a>
            @endif
            
            <a href="{{ route('student.practice.generate.form', $course->id) }}" class="btn-secondary">
                <i class="fas fa-plus mr-2"></i>
                Generate More Questions
            </a>
            
            @if($statistics['accuracy'] < 70)
                <a href="{{ route('student.practice.session', $course->id) }}?answered=false" class="btn-outline">
                    <i class="fas fa-redo mr-2"></i>
                    Review Incorrect Questions
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
