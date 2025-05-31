@extends('layouts.student')

@section('title', 'AI Practice Questions - ' . $course->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">AI Practice Questions</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $course->title }}</p>
            </div>
            <a href="{{ route('student.showCourse', $course->id) }}" 
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Course
            </a>
        </div>
    </div>

    @if(!$eligibility['can_generate'])
        <!-- Eligibility Warning -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Not Eligible for Question Generation
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>You need to be enrolled in this course and complete at least one quiz to generate practice questions.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    @if($practiceData['statistics']['total'] > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-question-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Questions</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $practiceData['statistics']['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Answered</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $practiceData['statistics']['answered'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-star text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Correct Answers</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $practiceData['statistics']['correct'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-percentage text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Accuracy Rate</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $practiceData['statistics']['accuracy'] }}%</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Recommendations -->
    @if(!empty($recommendations))
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                    Practice Recommendations
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recommendations as $recommendation)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $recommendation['title'] }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $recommendation['description'] }}</p>
                            
                            @if($recommendation['action'] === 'generate_questions')
                                <a href="{{ route('student.practice.generate.form', $course->id) }}" 
                                   class="btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i>
                                    Generate Questions
                                </a>
                            @elseif($recommendation['action'] === 'continue_practice')
                                <a href="{{ route('student.practice.session', $course->id) }}" 
                                   class="btn-primary btn-sm">
                                    <i class="fas fa-play mr-1"></i>
                                    Continue Practice
                                </a>
                            @elseif($recommendation['action'] === 'review_mistakes')
                                <a href="{{ route('student.practice.results', $course->id) }}" 
                                   class="btn-secondary btn-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    Review Results
                                </a>
                            @elseif($recommendation['action'] === 'generate_harder')
                                <a href="{{ route('student.practice.generate.form', $course->id) }}?difficulty=hard" 
                                   class="btn-primary btn-sm">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    Harder Questions
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @if($eligibility['can_generate'])
            <a href="{{ route('student.practice.generate.form', $course->id) }}" 
               class="action-card bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700">
                <div class="action-icon">
                    <i class="fas fa-magic"></i>
                </div>
                <div>
                    <h3 class="action-title">Generate New Questions</h3>
                    <p class="action-description">Use AI to create practice questions</p>
                </div>
            </a>
        @endif

        @if($practiceData['statistics']['unanswered'] > 0)
            <a href="{{ route('student.practice.session', $course->id) }}" 
               class="action-card bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700">
                <div class="action-icon">
                    <i class="fas fa-play"></i>
                </div>
                <div>
                    <h3 class="action-title">Start Practice</h3>
                    <p class="action-description">{{ $practiceData['statistics']['unanswered'] }} questions waiting</p>
                </div>
            </a>
        @endif

        @if($practiceData['statistics']['answered'] > 0)
            <a href="{{ route('student.practice.results', $course->id) }}" 
               class="action-card bg-gradient-to-r from-purple-500 to-purple-600 text-white hover:from-purple-600 hover:to-purple-700">
                <div class="action-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div>
                    <h3 class="action-title">View Results</h3>
                    <p class="action-description">Review your performance and stats</p>
                </div>
            </a>
        @endif

        @if($practiceData['statistics']['total'] > 0)
            <button onclick="resetQuestions()" 
                    class="action-card bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700">
                <div class="action-icon">
                    <i class="fas fa-redo"></i>
                </div>
                <div>
                    <h3 class="action-title">Reset</h3>
                    <p class="action-description">Delete all questions and start fresh</p>
                </div>
            </button>
        @endif
    </div>

    <!-- Recent Questions -->
    @if($practiceData['questions']->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    <i class="fas fa-history text-gray-500 mr-2"></i>
                    Recent Questions
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($practiceData['questions']->take(5) as $question)
                        <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ Str::limit($question->question, 100) }}
                                </p>
                                <div class="flex items-center mt-2 space-x-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($question->difficulty) }}
                                    </span>
                                    @if($question->isAnswered())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $question->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $question->is_correct ? 'Correct' : 'Incorrect' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Unanswered
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                @if(!$question->isAnswered())
                                    <a href="{{ route('student.practice.question', [$course->id, $question->id]) }}" 
                                       class="btn-primary btn-sm">
                                        <i class="fas fa-arrow-right mr-1"></i>
                                        Answer
                                    </a>
                                @else
                                    <a href="{{ route('student.practice.question', [$course->id, $question->id]) }}" 
                                       class="btn-secondary btn-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($practiceData['questions']->count() > 5)
                    <div class="mt-6 text-center">
                        <a href="{{ route('student.practice.session', $course->id) }}" 
                           class="btn-secondary">
                            View All Questions
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Reset Confirmation Modal -->
<div id="resetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Confirm Reset</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete all practice questions? This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmReset" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600">
                    Delete
                </button>
                <button id="cancelReset" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function resetQuestions() {
    document.getElementById('resetModal').classList.remove('hidden');
}

document.getElementById('cancelReset').onclick = function() {
    document.getElementById('resetModal').classList.add('hidden');
}

document.getElementById('confirmReset').onclick = function() {
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("student.practice.reset", $course->id) }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
