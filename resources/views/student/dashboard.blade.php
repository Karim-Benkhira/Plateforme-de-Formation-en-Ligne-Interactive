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
                        <li class="list-group-item">
                            <a href="{{ route('student.courses') }}" class="d-block">
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
                <div class="card-header bg-primary text-white">
                    {{ __('Student Dashboard') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4">{{ $totalCourses }}</h1>
                                    <p class="lead">{{ __('Enrolled Courses') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white mb-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4">{{ $completedCourses }}</h1>
                                    <p class="lead">{{ __('Completed Courses') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>{{ __('My Courses') }}</h4>
                        <div class="row">
                            @forelse($enrollments as $enrollment)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $enrollment->course->title }}</h5>
                                            <p class="card-text text-muted">
                                                <small>
                                                    <i class="fas fa-user me-1"></i> {{ $enrollment->course->teacher->name }}
                                                </small>
                                            </p>
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
                    </div>

                    <div class="mt-4">
                        <h4>{{ __('Recent Quiz Results') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Quiz') }}</th>
                                        <th>{{ __('Score') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentQuizResults as $result)
                                        <tr>
                                            <td>{{ $result->quiz->title }}</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-{{ $result->percentage >= 60 ? 'success' : 'danger' }}"
                                                         role="progressbar"
                                                         style="width: {{ $result->percentage }}%;"
                                                         aria-valuenow="{{ $result->percentage }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">
                                                        {{ $result->percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $result->completed_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('student.results.show', $result) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye me-1"></i> {{ __('View') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('No quiz results found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
