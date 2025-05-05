@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Edit Question') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.questions.update', $question) }}" method="POST" id="questionForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="question_text" class="form-label">{{ __('Question Text') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('question_text') is-invalid @enderror" id="question_text" name="question_text" rows="3" required>{{ old('question_text', $question->question_text) }}</textarea>
                            @error('question_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Question Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>{{ __('Multiple Choice') }}</option>
                                <option value="true_false" {{ old('type', $question->type) == 'true_false' ? 'selected' : '' }}>{{ __('True/False') }}</option>
                                <option value="short_answer" {{ old('type', $question->type) == 'short_answer' ? 'selected' : '' }}>{{ __('Short Answer') }}</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="points" class="form-label">{{ __('Points') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" name="points" value="{{ old('points', $question->points) }}" min="0.1" step="0.1" required>
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="feedback" class="form-label">{{ __('Feedback') }}</label>
                            <textarea class="form-control @error('feedback') is-invalid @enderror" id="feedback" name="feedback" rows="2">{{ old('feedback', $question->feedback) }}</textarea>
                            <div class="form-text">{{ __('Optional feedback to show students after answering this question.') }}</div>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Multiple Choice Options -->
                        <div id="multipleChoiceOptions" style="{{ $question->type == 'multiple_choice' ? 'display:block' : 'display:none' }}">
                            <h4 class="mt-4 mb-3">{{ __('Answer Options') }}</h4>
                            
                            <div id="optionsContainer">
                                @if($question->type == 'multiple_choice')
                                    @foreach($question->options as $index => $option)
                                        <div class="card mb-3 option-card">
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="correct_option" id="correct_option_{{ $index + 1 }}" value="{{ $index + 1 }}" {{ $option->is_correct ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="correct_option_{{ $index + 1 }}">
                                                            {{ __('Correct Answer') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-0">
                                                    <textarea class="form-control" name="options[{{ $index + 1 }}][text]" rows="2" placeholder="{{ __('Option text') }}" required>{{ $option->option_text }}</textarea>
                                                    <input type="hidden" name="options[{{ $index + 1 }}][id]" value="{{ $option->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Default options if changing to multiple choice -->
                                    <div class="card mb-3 option-card">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="correct_option" id="correct_option_1" value="1" checked>
                                                    <label class="form-check-label" for="correct_option_1">
                                                        {{ __('Correct Answer') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <textarea class="form-control" name="options[1][text]" rows="2" placeholder="{{ __('Option text') }}" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card mb-3 option-card">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="correct_option" id="correct_option_2" value="2">
                                                    <label class="form-check-label" for="correct_option_2">
                                                        {{ __('Correct Answer') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <textarea class="form-control" name="options[2][text]" rows="2" placeholder="{{ __('Option text') }}" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <button type="button" id="addOptionBtn" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle me-2"></i>{{ __('Add Option') }}
                                </button>
                                <button type="button" id="removeOptionBtn" class="btn btn-outline-danger ms-2" {{ $question->options->count() <= 2 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus-circle me-2"></i>{{ __('Remove Option') }}
                                </button>
                            </div>
                        </div>
                        
                        <!-- True/False Options -->
                        <div id="trueFalseOptions" style="{{ $question->type == 'true_false' ? 'display:block' : 'display:none' }}">
                            <h4 class="mt-4 mb-3">{{ __('Answer') }}</h4>
                            
                            <div class="mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="true_false_answer" id="true_answer" value="true" 
                                        {{ $question->type == 'true_false' && $question->options->where('option_text', 'True')->first()->is_correct ? 'checked' : '' }}>
                                    <label class="form-check-label" for="true_answer">{{ __('True') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="true_false_answer" id="false_answer" value="false"
                                        {{ $question->type == 'true_false' && $question->options->where('option_text', 'False')->first()->is_correct ? 'checked' : '' }}>
                                    <label class="form-check-label" for="false_answer">{{ __('False') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Short Answer Options -->
                        <div id="shortAnswerOptions" style="{{ $question->type == 'short_answer' ? 'display:block' : 'display:none' }}">
                            <h4 class="mt-4 mb-3">{{ __('Correct Answer') }}</h4>
                            
                            <div class="mb-3">
                                <textarea class="form-control" name="short_answer" rows="2" placeholder="{{ __('Enter the correct answer') }}">{{ $question->type == 'short_answer' ? $question->options->where('is_correct', true)->first()->option_text : '' }}</textarea>
                                <div class="form-text">{{ __('Student answers will be matched against this text (case insensitive).') }}</div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.quizzes.edit', $question->quiz_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Quiz') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Update Question') }}
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
        const typeSelect = document.getElementById('type');
        const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
        const trueFalseOptions = document.getElementById('trueFalseOptions');
        const shortAnswerOptions = document.getElementById('shortAnswerOptions');
        const optionsContainer = document.getElementById('optionsContainer');
        const addOptionBtn = document.getElementById('addOptionBtn');
        const removeOptionBtn = document.getElementById('removeOptionBtn');
        const questionForm = document.getElementById('questionForm');
        
        let optionCount = {{ $question->type == 'multiple_choice' ? $question->options->count() : 2 }};
        
        // Show/hide options based on question type
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            
            multipleChoiceOptions.style.display = selectedType === 'multiple_choice' ? 'block' : 'none';
            trueFalseOptions.style.display = selectedType === 'true_false' ? 'block' : 'none';
            shortAnswerOptions.style.display = selectedType === 'short_answer' ? 'block' : 'none';
        });
        
        // Add option button
        addOptionBtn.addEventListener('click', function() {
            optionCount++;
            
            const optionCard = document.createElement('div');
            optionCard.className = 'card mb-3 option-card';
            optionCard.innerHTML = `
                <div class="card-body">
                    <div class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="correct_option" id="correct_option_${optionCount}" value="${optionCount}">
                            <label class="form-check-label" for="correct_option_${optionCount}">
                                {{ __('Correct Answer') }}
                            </label>
                        </div>
                    </div>
                    <div class="mb-0">
                        <textarea class="form-control" name="options[${optionCount}][text]" rows="2" placeholder="{{ __('Option text') }}" required></textarea>
                    </div>
                </div>
            `;
            
            optionsContainer.appendChild(optionCard);
            
            // Enable remove button if we have more than 2 options
            if (optionCount > 2) {
                removeOptionBtn.disabled = false;
            }
        });
        
        // Remove option button
        removeOptionBtn.addEventListener('click', function() {
            if (optionCount > 2) {
                const lastOption = optionsContainer.lastElementChild;
                optionsContainer.removeChild(lastOption);
                optionCount--;
                
                // Disable remove button if we have only 2 options
                if (optionCount <= 2) {
                    removeOptionBtn.disabled = true;
                }
            }
        });
        
        // Form submission
        questionForm.addEventListener('submit', function(e) {
            const selectedType = typeSelect.value;
            
            if (selectedType === 'true_false') {
                // Create hidden true/false options
                const trueOption = document.createElement('input');
                trueOption.type = 'hidden';
                trueOption.name = 'options[1][text]';
                trueOption.value = 'True';
                
                const falseOption = document.createElement('input');
                falseOption.type = 'hidden';
                falseOption.name = 'options[2][text]';
                falseOption.value = 'False';
                
                const correctOption = document.createElement('input');
                correctOption.type = 'hidden';
                correctOption.name = 'correct_option';
                correctOption.value = document.getElementById('true_answer').checked ? '1' : '2';
                
                this.appendChild(trueOption);
                this.appendChild(falseOption);
                this.appendChild(correctOption);
            } else if (selectedType === 'short_answer') {
                // Create hidden short answer option
                const shortAnswerText = document.querySelector('textarea[name="short_answer"]').value;
                
                const shortAnswerOption = document.createElement('input');
                shortAnswerOption.type = 'hidden';
                shortAnswerOption.name = 'options[1][text]';
                shortAnswerOption.value = shortAnswerText;
                
                const correctOption = document.createElement('input');
                correctOption.type = 'hidden';
                correctOption.name = 'correct_option';
                correctOption.value = '1';
                
                this.appendChild(shortAnswerOption);
                this.appendChild(correctOption);
            }
        });
    });
</script>
@endpush
