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
                    <!-- Continue Learning Section -->
                    @if($continueLearning)
                    <div class="mb-4">
                        <h4>{{ __('Continue Learning') }}</h4>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>{{ $continueLearning->course->title }}</h5>
                                        <p class="text-muted">
                                            <small>
                                                <i class="fas fa-user me-1"></i> {{ $continueLearning->course->teacher->name }}
                                                @if($continueLearning->lastAccessedLesson)
                                                <span class="ms-3">
                                                    <i class="fas fa-book me-1"></i> {{ __('Last Lesson') }}: {{ $continueLearning->lastAccessedLesson->title }}
                                                </span>
                                                @endif
                                            </small>
                                        </p>
                                        <div class="progress mb-2" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $continueLearning->progress }}%;"
                                                aria-valuenow="{{ $continueLearning->progress }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <p class="mb-0">
                                            <small>{{ $continueLearning->progress }}% {{ __('completed') }}
                                            ({{ $continueLearning->completed_lessons_count }}/{{ $continueLearning->total_lessons_count }} {{ __('lessons') }})</small>
                                        </p>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center justify-content-end">
                                        @if($continueLearning->lastAccessedLesson)
                                            <a href="{{ route('student.lessons.show', $continueLearning->lastAccessedLesson) }}" class="btn btn-primary">
                                                <i class="fas fa-play-circle me-1"></i> {{ __('Resume Learning') }}
                                            </a>
                                        @else
                                            <a href="{{ route('student.courses.show', $continueLearning->course) }}" class="btn btn-primary">
                                                <i class="fas fa-book-open me-1"></i> {{ __('Go to Course') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

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

                                            <!-- Progress Bar -->
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small>{{ __('Progress') }}</small>
                                                    <small>{{ $enrollment->progress }}%</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $enrollment->progress }}%;"
                                                        aria-valuenow="{{ $enrollment->progress }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
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

                        <!-- Advanced Statistics Section -->
                        <div class="mt-4">
                            <h4>{{ __('Your Learning Statistics') }}</h4>
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-graduation-cap fa-2x text-primary mb-2"></i>
                                            <h5>{{ __('Completed Lessons') }}</h5>
                                            <h3>{{ $stats['completedLessons'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                            <h5>{{ __('Passed Quizzes') }}</h5>
                                            <h3>{{ $stats['passedQuizzes'] }}/{{ $stats['totalQuizzes'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                                            <h5>{{ __('Average Score') }}</h5>
                                            <h3>{{ number_format($stats['averageScore'], 1) }}%</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                            <h5>{{ __('Last Activity') }}</h5>
                                            <h3>{{ $stats['lastActivity'] ? $stats['lastActivity']->diffForHumans() : __('N/A') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recommended Courses Section -->
                        <div class="mt-4">
                            <h4>{{ __('Recommended Courses') }}</h4>
                            <div class="row">
                                @if(isset($recommendedCourses) && count($recommendedCourses) > 0)
                                    @foreach($recommendedCourses as $course)
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100">
                                                @if($course->image)
                                                    <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 140px; object-fit: cover;">
                                                @else
                                                    <img src="https://source.unsplash.com/random/300x140/?education" class="card-img-top" alt="{{ $course->title }}" style="height: 140px; object-fit: cover;">
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $course->title }}</h5>
                                                    <p class="card-text text-muted">
                                                        <small>
                                                            <i class="fas fa-user me-1"></i> {{ $course->teacher->name }}
                                                        </small>
                                                    </p>
                                                    <p class="card-text">{{ Str::limit($course->description, 80) }}</p>
                                                </div>
                                                <div class="card-footer bg-white">
                                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-info-circle me-1"></i> {{ __('View Details') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            {{ __('No recommended courses available at the moment.') }}
                                            <a href="{{ route('courses.index') }}" class="alert-link">{{ __('Browse all courses') }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
