@include('components.header')

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Interactive Practice Session</h1>
                <p class="text-gray-600">{{ $course->title }}</p>
            </div>
            <div>
                <a href="{{ route('student.adaptiveLearning.course', $course->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Learning Path
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Practice Instructions</h2>
                    <p class="text-gray-600">Answer the following questions to test your knowledge. You'll receive immediate feedback after submission.</p>
                </div>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            These questions are tailored to your current skill level and focus on areas where you need improvement. Take your time and think carefully before answering.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form id="practice-form" class="space-y-8">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            @foreach($questions as $index => $question)
                <div class="bg-white rounded-lg shadow-md p-6 question-container" data-question-type="{{ $question->type }}">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Question {{ $index + 1 }}</h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $question->difficulty == 1 ? 'bg-green-100 text-green-800' : ($question->difficulty == 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $question->getDifficultyName() }}
                        </span>
                    </div>
                    
                    <input type="hidden" name="question_ids[]" value="{{ $question->id }}">
                    
                    <div class="mb-4">
                        <p class="text-gray-800 mb-2">{{ $question->question }}</p>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                            {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                        </span>
                    </div>
                    
                    <div class="answer-container">
                        @if($question->type == 'multiple_choice')
                            <div class="space-y-2">
                                @foreach($question->getFormattedAnswers() as $answerIndex => $answer)
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="answers[{{ $index }}]" value="{{ $answerIndex }}" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-3 text-gray-700">{{ $answer }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @elseif($question->type == 'true_false')
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="answers[{{ $index }}]" value="true" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">True</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="answers[{{ $index }}]" value="false" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-3 text-gray-700">False</span>
                                </label>
                            </div>
                        @elseif($question->type == 'matching')
                            <div class="matching-question" data-question-index="{{ $index }}">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="space-y-2">
                                        @foreach($question->options['left_items'] ?? [] as $itemIndex => $item)
                                            <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                                                {{ $item }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="space-y-2">
                                        @foreach($question->options['right_items'] ?? [] as $itemIndex => $item)
                                            <div class="p-3 border border-gray-200 rounded-lg">
                                                <select name="answers[{{ $index }}][{{ $itemIndex }}]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="">-- Select match --</option>
                                                    @foreach(range(0, count($question->options['left_items'] ?? []) - 1) as $optionIndex)
                                                        <option value="{{ $optionIndex }}">{{ $optionIndex + 1 }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="ml-2">{{ $item }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif($question->type == 'fill_blank')
                            <div class="fill-blank-question">
                                <p class="text-gray-700 mb-4">Fill in the blanks:</p>
                                @php
                                    $text = $question->options['text'] ?? 'No text provided';
                                    $blanks = $question->options['blanks'] ?? [];
                                    $parts = explode('___', $text);
                                @endphp
                                
                                <div class="space-y-2">
                                    @foreach($parts as $partIndex => $part)
                                        {{ $part }}
                                        @if($partIndex < count($parts) - 1)
                                            <input type="text" name="answers[{{ $index }}][{{ $partIndex }}]" class="border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none px-1 w-32">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 italic">This question type is not supported in the preview.</p>
                        @endif
                    </div>
                    
                    <div class="feedback-container mt-4 hidden">
                        <div class="correct-feedback bg-green-50 border-l-4 border-green-500 p-4 hidden">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 explanation-text"></p>
                                </div>
                            </div>
                        </div>
                        <div class="incorrect-feedback bg-red-50 border-l-4 border-red-500 p-4 hidden">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700 mb-2">Incorrect. The correct answer is: <span class="correct-answer font-medium"></span></p>
                                    <p class="text-sm text-red-700 explanation-text"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="flex justify-between">
                <button type="button" id="submit-practice" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Submit Answers
                </button>
            </div>
        </form>
        
        <div id="results-container" class="bg-white rounded-lg shadow-md p-6 mt-8 hidden">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Practice Results</h2>
            
            <div class="flex items-center justify-center mb-6">
                <div class="relative w-32 h-32">
                    <svg class="w-32 h-32" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="2"></circle>
                        <circle id="result-circle" cx="18" cy="18" r="16" fill="none" stroke="#3b82f6" stroke-width="2" stroke-dasharray="100 100" stroke-dashoffset="0" transform="rotate(-90 18 18)"></circle>
                        <text id="result-percentage" x="18" y="18" font-size="8" text-anchor="middle" alignment-baseline="middle" font-weight="bold" fill="#1f2937">0%</text>
                    </svg>
                </div>
            </div>
            
            <div class="text-center mb-6">
                <p class="text-gray-600">You got <span id="correct-count" class="font-bold text-blue-600">0</span> out of <span id="total-questions" class="font-bold">0</span> questions correct.</p>
            </div>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('student.adaptiveLearning.practice', $course->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Try Again
                </a>
                <a href="{{ route('student.adaptiveLearning.course', $course->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                    Back to Learning Path
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const practiceForm = document.getElementById('practice-form');
        const submitButton = document.getElementById('submit-practice');
        const resultsContainer = document.getElementById('results-container');
        const resultCircle = document.getElementById('result-circle');
        const resultPercentage = document.getElementById('result-percentage');
        const correctCount = document.getElementById('correct-count');
        const totalQuestions = document.getElementById('total-questions');
        
        submitButton.addEventListener('click', function() {
            // Collect form data
            const formData = new FormData(practiceForm);
            
            // Send AJAX request
            fetch('{{ route("student.adaptiveLearning.practice.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Process feedback for each question
                    data.feedback.forEach((item, index) => {
                        const questionContainer = document.querySelectorAll('.question-container')[index];
                        const feedbackContainer = questionContainer.querySelector('.feedback-container');
                        const correctFeedback = questionContainer.querySelector('.correct-feedback');
                        const incorrectFeedback = questionContainer.querySelector('.incorrect-feedback');
                        const explanationTexts = questionContainer.querySelectorAll('.explanation-text');
                        const correctAnswer = questionContainer.querySelector('.correct-answer');
                        
                        // Show feedback container
                        feedbackContainer.classList.remove('hidden');
                        
                        // Show correct or incorrect feedback
                        if (item.feedback.is_correct) {
                            correctFeedback.classList.remove('hidden');
                            incorrectFeedback.classList.add('hidden');
                        } else {
                            correctFeedback.classList.add('hidden');
                            incorrectFeedback.classList.remove('hidden');
                            
                            // Set correct answer
                            if (correctAnswer) {
                                if (typeof item.feedback.correct_answer === 'object') {
                                    correctAnswer.textContent = JSON.stringify(item.feedback.correct_answer);
                                } else {
                                    correctAnswer.textContent = item.feedback.correct_answer;
                                }
                            }
                        }
                        
                        // Set explanation text
                        explanationTexts.forEach(el => {
                            el.textContent = item.feedback.explanation;
                        });
                    });
                    
                    // Update results
                    const score = data.score;
                    const circumference = 2 * Math.PI * 16;
                    const offset = circumference - (score / 100) * circumference;
                    
                    resultCircle.style.strokeDasharray = `${circumference} ${circumference}`;
                    resultCircle.style.strokeDashoffset = offset;
                    resultPercentage.textContent = `${Math.round(score)}%`;
                    
                    correctCount.textContent = data.correct_count;
                    totalQuestions.textContent = data.total_questions;
                    
                    // Show results container
                    resultsContainer.classList.remove('hidden');
                    
                    // Scroll to results
                    resultsContainer.scrollIntoView({ behavior: 'smooth' });
                } else {
                    console.error('Error submitting practice:', data.errors);
                    alert('There was an error submitting your answers. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error submitting your answers. Please try again.');
            });
        });
    });
</script>

@include('components.footer')
