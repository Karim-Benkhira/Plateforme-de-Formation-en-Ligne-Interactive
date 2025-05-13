@extends('layouts.student')

@section('title', 'Quiz Results')

@section('content')
<!-- Results Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white">Quiz Results</h1>
            <p class="text-blue-100">{{ $quizName }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="bg-white/20 rounded-lg px-6 py-3 text-white text-center">
                <span class="block text-sm">Your Score</span>
                <span class="font-bold text-2xl">{{ $score }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Results Content -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Left Column - Detailed Results -->
    <div class="lg:col-span-3">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-clipboard-check mr-2"></i> Detailed Results
            </div>
            <div class="section-content">
                @if(isset($questionDetails) && count($questionDetails) > 0)
                    <div class="space-y-6">
                        @foreach($questionDetails as $index => $detail)
                            <div class="bg-gray-800 rounded-lg overflow-hidden">
                                <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                                    <h3 class="text-white font-medium flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                            {{ $detail['is_correct'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }} mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        {{ $detail['question'] }}
                                    </h3>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $detail['is_correct'] ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                        {{ $detail['is_correct'] ? 'Correct' : 'Incorrect' }}
                                    </span>
                                </div>
                                <div class="p-6">
                                    @if($detail['type'] === 'short_answer')
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="text-gray-400 text-sm font-medium mb-2">Your Answer:</h4>
                                                <div class="bg-gray-700 border {{ $detail['is_correct'] ? 'border-green-500' : 'border-red-500' }} rounded-lg p-3 text-white">
                                                    {{ $detail['user_answer'] }}
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="text-gray-400 text-sm font-medium mb-2">Sample Answer:</h4>
                                                <div class="bg-gray-700 border border-green-500 rounded-lg p-3 text-white">
                                                    {{ $detail['correct_answer'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="text-gray-400 text-sm font-medium mb-2">Your Answer:</h4>
                                                <div class="bg-gray-700 border {{ $detail['is_correct'] ? 'border-green-500' : 'border-red-500' }} rounded-lg p-3 text-white">
                                                    {{ $detail['user_answer'] }}
                                                </div>
                                            </div>
                                            @if(!$detail['is_correct'])
                                                <div>
                                                    <h4 class="text-gray-400 text-sm font-medium mb-2">Correct Answer:</h4>
                                                    <div class="bg-gray-700 border border-green-500 rounded-lg p-3 text-white">
                                                        {{ $detail['correct_answer'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-clipboard-list text-primary-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Detailed Results</h3>
                        <p class="text-gray-400">Detailed results are not available for this quiz.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Summary and Actions -->
    <div class="space-y-8">
        <!-- Results Summary -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-chart-pie mr-2"></i> Results Summary
            </div>
            <div class="section-content">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Correct Answers</p>
                            <p class="text-white">{{ $correctAnswers }} / {{ $totalQuestions }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-percentage text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Percentage</p>
                            <p class="text-white">{{ round(($correctAnswers / $totalQuestions) * 100) }}%</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full 
                            {{ $score >= 60 ? 'bg-green-900' : 'bg-red-900' }} 
                            flex items-center justify-center mr-3">
                            <i class="fas fa-trophy {{ $score >= 60 ? 'text-green-400' : 'text-red-400' }}"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Status</p>
                            <p class="text-white">
                                {{ $score >= 60 ? 'Passed' : 'Failed' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-tasks mr-2"></i> Actions
            </div>
            <div class="section-content">
                <div class="space-y-3">
                    <a href="{{ route('student.courses') }}" class="action-button secondary w-full">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Courses
                    </a>
                    
                    <a href="{{ route('student.myCourses') }}" class="action-button primary w-full">
                        <i class="fas fa-book mr-2"></i> My Courses
                    </a>
                    
                    <a href="{{ route('student.progress') }}" class="action-button secondary w-full">
                        <i class="fas fa-chart-line mr-2"></i> View Progress
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
