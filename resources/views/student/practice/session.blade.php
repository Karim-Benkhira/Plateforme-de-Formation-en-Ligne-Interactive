@extends('layouts.student')

@section('title', 'Practice Session - ' . $course->title)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Practice Session</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $course->title }}</p>
            </div>
            <a href="{{ route('student.practice.dashboard', $course->id) }}" 
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
    </div>

    <!-- Statistics Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $practiceData['statistics']['total'] }}</div>
                <div class="text-sm text-gray-500">Total Questions</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $practiceData['statistics']['answered'] }}</div>
                <div class="text-sm text-gray-500">Answered</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $practiceData['statistics']['unanswered'] }}</div>
                <div class="text-sm text-gray-500">Unanswered</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $practiceData['statistics']['correct'] }}</div>
                <div class="text-sm text-gray-500">Correct</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $practiceData['statistics']['accuracy'] }}%</div>
                <div class="text-sm text-gray-500">Accuracy</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
            <i class="fas fa-filter text-gray-500 mr-2"></i>
            Filter Questions
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Type</label>
                <select id="typeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Types</option>
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                    <option value="short_answer">Short Answer</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Difficulty Level</label>
                <select id="difficultyFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Levels</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Answer Status</label>
                <select id="answeredFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">All Questions</option>
                    <option value="false">Unanswered</option>
                    <option value="true">Answered</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button onclick="applyFilters()" class="btn-primary w-full">
                    <i class="fas fa-search mr-2"></i>
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Questions List -->
    <div id="questionsList">
        @if($practiceData['questions']->isNotEmpty())
            <div class="space-y-6">
                @foreach($practiceData['questions'] as $question)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Question Header -->
                                    <div class="flex items-center mb-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                            {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>
                                        @if($question->isAnswered())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $question->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                <i class="fas {{ $question->is_correct ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                                {{ $question->is_correct ? 'Correct' : 'Incorrect' }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Unanswered
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Question Text -->
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                        {{ $question->question }}
                                    </h3>

                                    <!-- Question Options (for multiple choice) -->
                                    @if($question->type === 'multiple_choice' && $question->options)
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                                            @foreach($question->options as $index => $option)
                                                <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-lg {{ $question->isAnswered() && $option === $question->correct_answer ? 'bg-green-50 border-green-200' : '' }}">
                                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ chr(65 + $index) }}.</span>
                                                    <span class="text-gray-900 dark:text-white ml-2">{{ $option }}</span>
                                                    @if($question->isAnswered() && $option === $question->correct_answer)
                                                        <i class="fas fa-check text-green-500 float-right"></i>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- User Answer (if answered) -->
                                    @if($question->isAnswered())
                                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <i class="fas {{ $question->is_correct ? 'fa-check-circle text-green-500' : 'fa-times-circle text-red-500' }}"></i>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                        Your answer: {{ $question->user_answer }}
                                                    </p>
                                                    @if(!$question->is_correct)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                            Correct answer: {{ $question->correct_answer }}
                                                        </p>
                                                    @endif
                                                    @if($question->explanation)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                                            <strong>Explanation:</strong> {{ $question->explanation }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Timestamps -->
                                    <div class="mt-4 text-xs text-gray-500">
                                        <span>Created: {{ $question->created_at->diffForHumans() }}</span>
                                        @if($question->answered_at)
                                            <span class="ml-4">Answered: {{ $question->answered_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="ml-6 flex-shrink-0">
                                    @if(!$question->isAnswered())
                                        <a href="{{ route('student.practice.question', [$course->id, $question->id]) }}" 
                                           class="btn-primary">
                                            <i class="fas fa-arrow-right mr-2"></i>
                                            Answer Question
                                        </a>
                                    @else
                                        <a href="{{ route('student.practice.question', [$course->id, $question->id]) }}" 
                                           class="btn-secondary">
                                            <i class="fas fa-eye mr-2"></i>
                                            View Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    @if($practiceData['statistics']['unanswered'] > 0)
                        <button onclick="startQuickPractice()" class="btn-primary">
                            <i class="fas fa-play mr-2"></i>
                            Start Quick Practice ({{ $practiceData['statistics']['unanswered'] }} questions)
                        </button>
                    @endif
                    
                    <a href="{{ route('student.practice.results', $course->id) }}" class="btn-secondary">
                        <i class="fas fa-chart-bar mr-2"></i>
                        View Detailed Results
                    </a>
                    
                    <a href="{{ route('student.practice.generate.form', $course->id) }}" class="btn-outline">
                        <i class="fas fa-plus mr-2"></i>
                        Generate More Questions
                    </a>
                </div>
            </div>
        @else
            <!-- No Questions -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 text-gray-400">
                    <i class="fas fa-question-circle text-6xl"></i>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No Questions Found</h3>
                <p class="mt-2 text-gray-500">No practice questions found. Generate new questions or adjust your filters.</p>
                <div class="mt-6">
                    <a href="{{ route('student.practice.generate.form', $course->id) }}" class="btn-primary">
                        <i class="fas fa-magic mr-2"></i>
                        Generate New Questions
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function applyFilters() {
    const type = document.getElementById('typeFilter').value;
    const difficulty = document.getElementById('difficultyFilter').value;
    const answered = document.getElementById('answeredFilter').value;
    
    const params = new URLSearchParams();
    if (type) params.append('type', type);
    if (difficulty) params.append('difficulty', difficulty);
    if (answered) params.append('answered', answered);
    
    const url = new URL(window.location);
    url.search = params.toString();
    window.location.href = url.toString();
}

function startQuickPractice() {
    // Find first unanswered question and redirect to it
    const unansweredLinks = document.querySelectorAll('a[href*="/question/"]');
    for (let link of unansweredLinks) {
        if (link.textContent.includes('Answer Question')) {
            window.location.href = link.href;
            break;
        }
    }
}

// Set filter values from URL parameters
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('type')) {
        document.getElementById('typeFilter').value = urlParams.get('type');
    }
    if (urlParams.has('difficulty')) {
        document.getElementById('difficultyFilter').value = urlParams.get('difficulty');
    }
    if (urlParams.has('answered')) {
        document.getElementById('answeredFilter').value = urlParams.get('answered');
    }
});
</script>
@endsection
