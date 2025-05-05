@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ $course->title }}</h2>
                    <span class="badge bg-light text-dark">{{ ucfirst($course->status) }}</span>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" class="img-fluid rounded" alt="{{ $course->title }}">
                            @else
                                <img src="https://source.unsplash.com/random/400x300/?course" class="img-fluid rounded" alt="{{ $course->title }}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ __('Course Description') }}</h3>
                            <p>{{ $course->description }}</p>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    <h5><i class="fas fa-user me-2"></i>{{ __('Instructor') }}</h5>
                                    <p>{{ $course->teacher->name }}</p>
                                </div>
                                <div>
                                    <h5><i class="fas fa-calendar me-2"></i>{{ __('Duration') }}</h5>
                                    <p>
                                        @if($course->start_date && $course->end_date)
                                            {{ $course->start_date->format('M d, Y') }} - {{ $course->end_date->format('M d, Y') }}
                                        @else
                                            {{ __('Flexible') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @if(!$isEnrolled && auth()->check() && auth()->user()->isStudent())
                                <form action="{{ route('student.courses.enroll', $course) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-user-plus me-2"></i>{{ __('Enroll Now') }}
                                    </button>
                                </form>
                            @elseif($isEnrolled)
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle me-2"></i>{{ __('You are enrolled in this course') }}
                                    <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary ms-3">
                                        <i class="fas fa-book-open me-2"></i>{{ __('Go to Course') }}
                                    </a>
                                </div>
                            @elseif(!auth()->check())
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>{{ __('Please login to enroll in this course') }}
                                    <a href="{{ route('login') }}" class="btn btn-primary ms-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <h3><i class="fas fa-list me-2"></i>{{ __('Course Content') }}</h3>
                        <div class="accordion" id="courseModules">
                            @forelse($course->modules as $module)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $module->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}" aria-expanded="false" aria-controls="collapse{{ $module->id }}">
                                            <strong>{{ $module->title }}</strong>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $module->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $module->id }}" data-bs-parent="#courseModules">
                                        <div class="accordion-body">
                                            <p>{{ $module->description }}</p>
                                            <ul class="list-group">
                                                @foreach($module->lessons as $lesson)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-book me-2"></i>{{ $lesson->title }}
                                                        </div>
                                                        @if($isEnrolled)
                                                            <a href="{{ route('student.lessons.show', $lesson) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye me-1"></i>{{ __('View') }}
                                                            </a>
                                                        @else
                                                            <span class="badge bg-secondary">
                                                                <i class="fas fa-lock me-1"></i>{{ __('Locked') }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    {{ __('No modules available for this course yet.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
