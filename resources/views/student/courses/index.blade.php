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
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ __('My Enrolled Courses') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($enrollments as $enrollment)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    @if($enrollment->course->image)
                                        <img src="{{ asset('storage/' . $enrollment->course->image) }}" class="card-img-top" alt="{{ $enrollment->course->title }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="https://source.unsplash.com/random/300x200/?course" class="card-img-top" alt="{{ $enrollment->course->title }}" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $enrollment->course->title }}</h5>
                                        <p class="card-text text-muted">
                                            <small>
                                                <i class="fas fa-user me-1"></i> {{ $enrollment->course->teacher->name }}
                                            </small>
                                        </p>
                                        <div class="mb-2">
                                            <span class="badge bg-{{ $enrollment->status == 'active' ? 'success' : ($enrollment->status == 'completed' ? 'primary' : 'secondary') }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                            <span class="badge bg-{{ $enrollment->course->status == 'active' ? 'success' : ($enrollment->course->status == 'upcoming' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($enrollment->course->status) }}
                                            </span>
                                        </div>
                                        <p class="card-text">{{ Str::limit($enrollment->course->description, 100) }}</p>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <a href="{{ route('student.courses.show', $enrollment->course) }}" class="btn btn-primary">
                                            <i class="fas fa-book-open me-1"></i> {{ __('Continue Learning') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    {{ __('You are not enrolled in any courses yet.') }}
                                    <a href="{{ route('courses.index') }}" class="alert-link">{{ __('Browse available courses') }}</a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $enrollments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
