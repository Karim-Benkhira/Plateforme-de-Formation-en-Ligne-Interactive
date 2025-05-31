@extends('layouts.student')

@section('title', 'Practice Question - ' . $course->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Practice Question</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $course->title }}</p>
            </div>
            <a href="{{ route('student.practice.session', $course->id) }}" 
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Session
            </a>
        </div>
    </div>

    <!-- Question Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <!-- Question Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        {{ ucfirst($question->difficulty) }}
                    </span>
                    @if($question->isAnswered())
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $question->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas {{ $question->is_correct ? 'fa-check' : 'fa-times' }} mr-1"></i>
                            {{ $question->is_correct ? 'Correct Answer' : 'Incorrect Answer' }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>
                            Unanswered
                        </span>
                    @endif
                </div>
                
                @if($question->is_ai_generated)
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-robot mr-1"></i>
                        AI Generated
                    </div>
                @endif
            </div>
        </div>

        <!-- Question Content -->
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                {{ $question->question }}
            </h2>

            @if(!$question->isAnswered())
                <!-- Answer Form -->
                <form id="answerForm" class="space-y-6">
                    @csrf
                    
                    @if($question->type === 'multiple_choice')
                        <!-- Multiple Choice Options -->
                        <div class="space-y-3">
                            @foreach($question->options as $index => $option)
                                <label class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                    <input type="radio" name="answer" value="{{ $option }}" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-900 dark:text-white">
                                        <span class="font-medium">{{ chr(65 + $index) }}.</span>
                                        {{ $option }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    
                    @elseif($question->type === 'true_false')
                        <!-- True/False Options -->
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                <input type="radio" name="answer" value="true" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-900 dark:text-white font-medium">True</span>
                            </label>
                            <label class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                <input type="radio" name="answer" value="false" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-900 dark:text-white font-medium">False</span>
                            </label>
                        </div>
                    
                    @elseif($question->type === 'short_answer')
                        <!-- Short Answer Input -->
                        <div>
                            <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Write your answer (2-3 sentences):
                            </label>
                            <textarea name="answer" id="answer" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                      placeholder="Write your answer here..."></textarea>
                            @if($question->key_points)
                                <p class="mt-2 text-sm text-gray-500">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    Make sure to include key points in your answer
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6">
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="fas fa-check mr-2"></i>
                            <span id="submitText">Submit Answer</span>
                            <div id="submitSpinner" class="hidden ml-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                        </button>
                        
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Cannot change answer after submission
                        </div>
                    </div>
                </form>
            @else
                <!-- Show Previous Answer -->
                <div class="space-y-6">
                    @if($question->type === 'multiple_choice')
                        <!-- Show options with correct answer highlighted -->
                        <div class="space-y-3">
                            @foreach($question->options as $index => $option)
                                <div class="flex items-center p-4 border rounded-lg 
                                    {{ $option === $question->correct_answer ? 'border-green-500 bg-green-50' : 'border-gray-200' }}
                                    {{ $option === $question->user_answer && !$question->is_correct ? 'border-red-500 bg-red-50' : '' }}">
                                    <span class="text-gray-900 dark:text-white">
                                        <span class="font-medium">{{ chr(65 + $index) }}.</span>
                                        {{ $option }}
                                    </span>
                                    @if($option === $question->correct_answer)
                                        <i class="fas fa-check text-green-500 ml-auto"></i>
                                    @endif
                                    @if($option === $question->user_answer && !$question->is_correct)
                                        <i class="fas fa-times text-red-500 ml-auto"></i>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Show answer for other types -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
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
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Explanation -->
                    @if($question->explanation)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Explanation
                            </h4>
                            <p class="text-sm text-blue-800 dark:text-blue-200">{{ $question->explanation }}</p>
                        </div>
                    @endif

                    <!-- Sample Answer for Short Answer Questions -->
                    @if($question->type === 'short_answer' && $question->sample_answer)
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-green-900 dark:text-green-100 mb-2">
                                <i class="fas fa-star mr-1"></i>
                                Sample Answer
                            </h4>
                            <p class="text-sm text-green-800 dark:text-green-200">{{ $question->sample_answer }}</p>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="flex items-center justify-between pt-6">
                        <button onclick="getNextQuestion()" class="btn-primary">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Next Question
                        </button>
                        
                        <div class="text-sm text-gray-500">
                            Answered on: {{ $question->answered_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Question Info -->
    <div class="mt-6 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-gray-500">Created:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $question->created_at->diffForHumans() }}</span>
            </div>
            <div>
                <span class="text-gray-500">Source:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $question->ai_service ?? 'Local' }}</span>
            </div>
            <div>
                <span class="text-gray-500">Language:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $question->language === 'ar' ? 'Arabic' : ucfirst($question->language) }}</span>
            </div>
            <div>
                <span class="text-gray-500">Question ID:</span>
                <span class="font-medium text-gray-900 dark:text-white">#{{ $question->id }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div id="resultModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div id="resultIcon" class="mx-auto flex items-center justify-center h-12 w-12 rounded-full">
                <!-- Icon will be set by JavaScript -->
            </div>
            <h3 id="resultTitle" class="text-lg font-medium text-gray-900 mt-2"></h3>
            <div class="mt-2 px-7 py-3">
                <p id="resultMessage" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="continueBtn" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full hover:bg-blue-600">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('answerForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const answer = formData.get('answer');
    
    if (!answer || answer.trim() === '') {
        alert('Please select or write an answer');
        return;
    }
    
    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    submitBtn.disabled = true;
    submitText.textContent = 'Submitting...';
    submitSpinner.classList.remove('hidden');
    
    // Submit answer
    fetch('{{ route("student.practice.answer", [$course->id, $question->id]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ answer: answer })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showResult(data.is_correct, data.message, data.explanation);
        } else {
            alert('Error: ' + data.message);
            // Reset button state
            submitBtn.disabled = false;
            submitText.textContent = 'Submit Answer';
            submitSpinner.classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Connection error occurred');
        // Reset button state
        submitBtn.disabled = false;
        submitText.textContent = 'Submit Answer';
        submitSpinner.classList.add('hidden');
    });
});

function showResult(isCorrect, message, explanation) {
    const modal = document.getElementById('resultModal');
    const icon = document.getElementById('resultIcon');
    const title = document.getElementById('resultTitle');
    const messageEl = document.getElementById('resultMessage');
    
    if (isCorrect) {
        icon.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100';
        icon.innerHTML = '<i class="fas fa-check text-green-600"></i>';
        title.textContent = 'Correct Answer!';
        title.className = 'text-lg font-medium text-green-900 mt-2';
    } else {
        icon.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100';
        icon.innerHTML = '<i class="fas fa-times text-red-600"></i>';
        title.textContent = 'Incorrect Answer';
        title.className = 'text-lg font-medium text-red-900 mt-2';
    }
    
    messageEl.textContent = message + (explanation ? '\n\n' + explanation : '');
    modal.classList.remove('hidden');
}

document.getElementById('continueBtn').onclick = function() {
    window.location.reload();
}

function getNextQuestion() {
    fetch('{{ route("student.practice.next.question", $course->id) }}')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("student.practice.question", [$course->id, ""]) }}' + data.question.id;
        } else {
            alert('No more questions to answer');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Connection error occurred');
    });
}
</script>
@endsection
