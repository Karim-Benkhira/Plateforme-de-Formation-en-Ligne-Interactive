@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Student Menu') }}
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('student.dashboard') }}" class="d-block">
                                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="list-group-item active bg-primary">
                            <a href="{{ route('student.courses') }}" class="d-block text-white">
                                <i class="fas fa-book me-2"></i>{{ __('My Courses') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('student.results') }}" class="d-block">
                                <i class="fas fa-chart-line me-2"></i>{{ __('My Results') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('courses.index') }}" class="d-block">
                                <i class="fas fa-search me-2"></i>{{ __('Browse Courses') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    {{ __('Course Progress') }}
                </div>
                <div class="card-body">
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
                    </div>
                    <div class="text-center">
                        <small class="text-muted">{{ __('Completed') }}: {{ $completedLessons }} / {{ $totalLessons }} {{ __('lessons') }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
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
                            
                            <div class="alert alert-{{ $enrollment->status == 'active' ? 'success' : ($enrollment->status == 'completed' ? 'info' : 'secondary') }} mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('Enrollment Status') }}: <strong>{{ ucfirst($enrollment->status) }}</strong>
                                @if($enrollment->completed_at)
                                    <br>{{ __('Completed on') }}: {{ $enrollment->completed_at->format('M d, Y') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <h3><i class="fas fa-list me-2"></i>{{ __('Course Content') }}</h3>
                        <div class="accordion" id="courseModules">
                            @forelse($modules as $module)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $module->id }}">
                                        <button class="accordion-button {{ $currentModule && $currentModule->id == $module->id ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}" aria-expanded="{{ $currentModule && $currentModule->id == $module->id ? 'true' : 'false' }}" aria-controls="collapse{{ $module->id }}">
                                            <div class="d-flex justify-content-between w-100 me-3">
                                                <strong>{{ $module->title }}</strong>
                                                <span class="badge bg-primary rounded-pill">{{ $module->lessons->count() }} {{ __('lessons') }}</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $module->id }}" class="accordion-collapse collapse {{ $currentModule && $currentModule->id == $module->id ? 'show' : '' }}" aria-labelledby="heading{{ $module->id }}" data-bs-parent="#courseModules">
                                        <div class="accordion-body">
                                            <p>{{ $module->description }}</p>
                                            <ul class="list-group">
                                                @foreach($module->lessons as $lesson)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="fas fa-{{ $lesson->content_type == 'text' ? 'file-alt' : ($lesson->content_type == 'video' ? 'video' : 'file') }} me-2"></i>
                                                            {{ $lesson->title }}
                                                            @if(in_array($lesson->id, $completedLessonIds))
                                                                <span class="badge bg-success ms-2"><i class="fas fa-check"></i></span>
                                                            @endif
                                                        </div>
                                                        <a href="{{ route('student.lessons.show', $lesson) }}" class="btn btn-sm btn-{{ $currentLesson && $currentLesson->id == $lesson->id ? 'primary' : 'outline-primary' }}">
                                                            <i class="fas fa-eye me-1"></i>{{ __('View') }}
                                                        </a>
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
