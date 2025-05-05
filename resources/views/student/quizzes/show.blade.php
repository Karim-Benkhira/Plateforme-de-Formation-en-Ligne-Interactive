@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ $quiz->title }}</h2>
                    <div id="quizTimer" class="bg-light text-dark p-2 rounded">
                        <i class="fas fa-clock me-2"></i><span id="timer">{{ $quiz->duration }}:00</span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('You have') }} <strong>{{ $quiz->duration }} {{ __('minutes') }}</strong> {{ __('to complete this quiz. Please answer all questions before submitting.') }}
                    </div>
                    
                    <form id="quizForm" action="{{ route('student.quizzes.submit', $quiz) }}" method="POST">
                        @csrf
                        
                        @foreach($questions as $index => $question)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ __('Question') }} {{ $index + 1 }}: {{ $question->question_text }}</h5>
                                    <small class="text-muted">{{ $question->points }} {{ __('points') }}</small>
                                </div>
                                <div class="card-body">
                                    @if($question->type == 'multiple_choice')
                                        @foreach($question->options as $option)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_{{ $option->id }}" value="{{ $option->id }}" required>
                                                <label class="form-check-label" for="option_{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @elseif($question->type == 'true_false')
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_true_{{ $question->id }}" value="{{ $question->options->where('option_text', 'True')->first()->id }}" required>
                                            <label class="form-check-label" for="option_true_{{ $question->id }}">
                                                {{ __('True') }}
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="question_{{ $question->id }}" id="option_false_{{ $question->id }}" value="{{ $question->options->where('option_text', 'False')->first()->id }}" required>
                                            <label class="form-check-label" for="option_false_{{ $question->id }}">
                                                {{ __('False') }}
                                            </label>
                                        </div>
                                    @elseif($question->type == 'short_answer')
                                        <div class="form-group">
                                            <textarea class="form-control" name="text_answer_{{ $question->id }}" rows="3" placeholder="{{ __('Enter your answer here...') }}" required></textarea>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('Submit Quiz') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quiz timer
        let duration = {{ $quiz->duration * 60 }}; // Convert minutes to seconds
        const timerElement = document.getElementById('timer');
        const quizForm = document.getElementById('quizForm');
        
        const timer = setInterval(function() {
            duration--;
            
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            
            timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            
            if (duration <= 0) {
                clearInterval(timer);
                alert('{{ __("Time's up! Your quiz will be submitted automatically.") }}');
                quizForm.submit();
            }
        }, 1000);
        
        // Auto-save answers periodically
        const formInputs = quizForm.querySelectorAll('input, textarea');
        
        setInterval(function() {
            const formData = {};
            
            formInputs.forEach(input => {
                if ((input.type === 'radio' && input.checked) || input.type === 'textarea') {
                    formData[input.name] = input.value;
                }
            });
            
            localStorage.setItem('quiz_{{ $quiz->id }}_answers', JSON.stringify(formData));
        }, 10000); // Save every 10 seconds
        
        // Load saved answers if any
        const savedAnswers = localStorage.getItem('quiz_{{ $quiz->id }}_answers');
        
        if (savedAnswers) {
            const answers = JSON.parse(savedAnswers);
            
            Object.keys(answers).forEach(key => {
                const value = answers[key];
                const element = quizForm.querySelector(`[name="${key}"]`);
                
                if (element) {
                    if (element.type === 'radio') {
                        quizForm.querySelector(`[name="${key}"][value="${value}"]`).checked = true;
                    } else if (element.type === 'textarea') {
                        element.value = value;
                    }
                }
            });
        }
        
        // Clear saved answers on form submission
        quizForm.addEventListener('submit', function() {
            localStorage.removeItem('quiz_{{ $quiz->id }}_answers');
        });
    });
</script>
@endpush
