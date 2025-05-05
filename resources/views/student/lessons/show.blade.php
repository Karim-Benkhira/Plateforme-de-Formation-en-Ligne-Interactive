@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Course Navigation') }}
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('student.courses.show', $lesson->module->course) }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Course') }}
                        </a>
                    </div>
                    
                    <div class="p-3">
                        <h5>{{ $lesson->module->title }}</h5>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        @foreach($lesson->module->lessons as $moduleLesson)
                            <a href="{{ route('student.lessons.show', $moduleLesson) }}" 
                               class="list-group-item list-group-item-action {{ $lesson->id == $moduleLesson->id ? 'active' : '' }}">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-{{ $moduleLesson->content_type == 'text' ? 'file-alt' : ($moduleLesson->content_type == 'video' ? 'video' : 'file') }} me-2"></i>
                                        {{ $moduleLesson->title }}
                                    </div>
                                    @if(in_array($moduleLesson->id, $completedLessonIds))
                                        <span class="badge bg-success"><i class="fas fa-check"></i></span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            @if($lesson->quizzes->count() > 0)
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        {{ __('Quizzes & Assessments') }}
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($lesson->quizzes as $quiz)
                                <a href="{{ route('student.quizzes.show', $quiz) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-question-circle me-2"></i>
                                            {{ $quiz->title }}
                                        </div>
                                        <span class="badge bg-{{ $quiz->status == 'open' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($quiz->status) }}
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ $quiz->type == 'practice' ? __('Practice Quiz') : __('Exam') }} • 
                                        {{ $quiz->duration }} {{ __('minutes') }} • 
                                        {{ $quiz->questions->count() }} {{ __('questions') }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    {{ __('Lesson Navigation') }}
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @if($previousLesson)
                            <a href="{{ route('student.lessons.show', $previousLesson) }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Previous') }}
                            </a>
                        @else
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Previous') }}
                            </button>
                        @endif
                        
                        @if($nextLesson)
                            <a href="{{ route('student.lessons.show', $nextLesson) }}" class="btn btn-outline-primary">
                                {{ __('Next') }}<i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <button class="btn btn-outline-secondary" disabled>
                                {{ __('Next') }}<i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ $lesson->title }}</h2>
                </div>
                <div class="card-body">
                    @if($lesson->content_type == 'text')
                        <div class="lesson-content">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    @elseif($lesson->content_type == 'video')
                        <div class="ratio ratio-16x9 mb-4">
                            @if(Str::contains($lesson->content_url, ['youtube.com', 'youtu.be']))
                                @php
                                    $videoId = null;
                                    if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $lesson->content_url, $matches)) {
                                        $videoId = $matches[1];
                                    } elseif (preg_match('/youtu\.be\/([^?]+)/', $lesson->content_url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="{{ $lesson->title }}" allowfullscreen></iframe>
                                @else
                                    <div class="alert alert-danger">{{ __('Invalid YouTube URL') }}</div>
                                @endif
                            @elseif(Str::contains($lesson->content_url, 'vimeo.com'))
                                @php
                                    $videoId = null;
                                    if (preg_match('/vimeo\.com\/([0-9]+)/', $lesson->content_url, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                @endphp
                                @if($videoId)
                                    <iframe src="https://player.vimeo.com/video/{{ $videoId }}" title="{{ $lesson->title }}" allowfullscreen></iframe>
                                @else
                                    <div class="alert alert-danger">{{ __('Invalid Vimeo URL') }}</div>
                                @endif
                            @else
                                <video controls>
                                    <source src="{{ asset('storage/' . $lesson->content_url) }}" type="video/mp4">
                                    {{ __('Your browser does not support the video tag.') }}
                                </video>
                            @endif
                        </div>
                        
                        @if($lesson->content)
                            <div class="lesson-content mt-4">
                                <h4>{{ __('Video Description') }}</h4>
                                {!! nl2br(e($lesson->content)) !!}
                            </div>
                        @endif
                    @elseif($lesson->content_type == 'file')
                        <div class="text-center mb-4">
                            <a href="{{ asset('storage/' . $lesson->content_url) }}" class="btn btn-lg btn-primary" target="_blank">
                                <i class="fas fa-download me-2"></i>{{ __('Download File') }}
                            </a>
                        </div>
                        
                        @if($lesson->content)
                            <div class="lesson-content mt-4">
                                <h4>{{ __('File Description') }}</h4>
                                {!! nl2br(e($lesson->content)) !!}
                            </div>
                        @endif
                    @endif
                    
                    <div class="mt-4 text-center">
                        <form action="{{ route('student.lessons.complete', $lesson) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg {{ in_array($lesson->id, $completedLessonIds) ? 'disabled' : '' }}">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ in_array($lesson->id, $completedLessonIds) ? __('Lesson Completed') : __('Mark as Completed') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            @if($lesson->quizzes->where('status', 'open')->count() > 0)
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">{{ __('Available Quizzes') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($lesson->quizzes->where('status', 'open') as $quiz)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $quiz->title }}</h5>
                                            <p class="card-text">{{ Str::limit($quiz->description, 100) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $quiz->type == 'practice' ? 'info' : 'warning' }}">
                                                    {{ $quiz->type == 'practice' ? __('Practice Quiz') : __('Exam') }}
                                                </span>
                                                <span class="text-muted">
                                                    <i class="fas fa-clock me-1"></i> {{ $quiz->duration }} {{ __('min') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <a href="{{ route('student.quizzes.show', $quiz) }}" class="btn btn-primary">
                                                <i class="fas fa-pen me-1"></i> {{ __('Take Quiz') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .lesson-content {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    
    .lesson-content h1, .lesson-content h2, .lesson-content h3, .lesson-content h4 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .lesson-content p {
        margin-bottom: 1rem;
    }
    
    .lesson-content ul, .lesson-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .lesson-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    
    .lesson-content pre {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
        overflow-x: auto;
    }
    
    .lesson-content code {
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
    }
</style>
@endpush
