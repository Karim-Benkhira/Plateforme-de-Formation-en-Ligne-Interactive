@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ __('Quiz Results') }}</h2>
                    <a href="{{ route('student.lessons.show', $quizResult->quiz->lesson) }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Lesson') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h3>{{ $quizResult->quiz->title }}</h3>
                            <p>{{ $quizResult->quiz->description }}</p>
                            
                            <div class="d-flex mt-3">
                                <div class="me-4">
                                    <strong>{{ __('Course') }}:</strong> {{ $quizResult->quiz->lesson->module->course->title }}
                                </div>
                                <div class="me-4">
                                    <strong>{{ __('Module') }}:</strong> {{ $quizResult->quiz->lesson->module->title }}
                                </div>
                                <div>
                                    <strong>{{ __('Lesson') }}:</strong> {{ $quizResult->quiz->lesson->title }}
                                </div>
                            </div>
                            
                            <div class="d-flex mt-2">
                                <div class="me-4">
                                    <strong>{{ __('Date Taken') }}:</strong> {{ $quizResult->created_at->format('M d, Y H:i') }}
                                </div>
                                <div>
                                    <strong>{{ __('Time Spent') }}:</strong> {{ floor($quizResult->time_spent / 60) }}m {{ $quizResult->time_spent % 60 }}s
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <h4 class="mb-3">{{ __('Your Score') }}</h4>
                                    <div class="display-4 mb-2 {{ $quizResult->passed ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($quizResult->score, 1) }}%
                                    </div>
                                    <div class="mb-2">
                                        {{ $quizResult->points_earned }} / {{ $quizResult->points_possible }} {{ __('points') }}
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge bg-{{ $quizResult->passed ? 'success' : 'danger' }} p-2">
                                            {{ $quizResult->passed ? __('PASSED') : __('FAILED') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h4 class="mb-3">{{ __('Question Review') }}</h4>
                    
                    @foreach($quizResult->answers as $index => $answer)
                        <div class="card mb-4">
                            <div class="card-header bg-{{ $answer->is_correct ? 'success' : 'danger' }} text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ __('Question') }} {{ $index + 1 }}</h5>
                                <div>
                                    <span class="badge bg-light text-dark">
                                        {{ $answer->points_earned }} / {{ $answer->question->points }} {{ __('points') }}
                                    </span>
                                    <span class="badge bg-{{ $answer->is_correct ? 'success' : 'danger' }} ms-2">
                                        {{ $answer->is_correct ? __('Correct') : __('Incorrect') }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-4">{{ $answer->question->question_text }}</h5>
                                
                                @if($answer->question->type == 'multiple_choice' || $answer->question->type == 'true_false')
                                    <div class="mb-3">
                                        <h6>{{ __('Options') }}:</h6>
                                        <ul class="list-group">
                                            @foreach($answer->question->options as $option)
                                                <li class="list-group-item 
                                                    {{ $option->is_correct ? 'list-group-item-success' : '' }}
                                                    {{ $answer->option_id == $option->id && !$option->is_correct ? 'list-group-item-danger' : '' }}">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            @if($answer->option_id == $option->id)
                                                                <i class="fas fa-check-circle me-2 {{ $option->is_correct ? 'text-success' : 'text-danger' }}"></i>
                                                            @elseif($option->is_correct)
                                                                <i class="fas fa-check-circle me-2 text-success"></i>
                                                            @else
                                                                <i class="fas fa-circle me-2 text-secondary"></i>
                                                            @endif
                                                            {{ $option->option_text }}
                                                        </div>
                                                        @if($answer->option_id == $option->id)
                                                            <span class="badge bg-primary">{{ __('Your Answer') }}</span>
                                                        @elseif($option->is_correct)
                                                            <span class="badge bg-success">{{ __('Correct Answer') }}</span>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @elseif($answer->question->type == 'short_answer')
                                    <div class="mb-3">
                                        <h6>{{ __('Your Answer') }}:</h6>
                                        <div class="p-3 bg-light rounded">
                                            {{ $answer->answer_text ?: __('No answer provided') }}
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6>{{ __('Correct Answer') }}:</h6>
                                        <div class="p-3 bg-success text-white rounded">
                                            {{ $answer->question->options->where('is_correct', true)->first()->option_text }}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($answer->question->feedback)
                                    <div class="alert alert-info mt-3">
                                        <h6>{{ __('Feedback') }}:</h6>
                                        {{ $answer->question->feedback }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('student.results.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>{{ __('All Results') }}
                        </a>
                        
                        @if($quizResult->quiz->type == 'practice')
                            <a href="{{ route('student.quizzes.show', $quizResult->quiz) }}" class="btn btn-primary">
                                <i class="fas fa-redo me-2"></i>{{ __('Retake Quiz') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
