@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('sidebar-menu')
    <li class="sidebar-menu-item">
        <a href="{{ route('student.dashboard') }}" class="sidebar-menu-link active">
            <span class="sidebar-menu-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="sidebar-menu-text">Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('student.courses') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-book"></i></span>
            <span class="sidebar-menu-text">My Courses</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('student.results') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-chart-line"></i></span>
            <span class="sidebar-menu-text">My Results</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('courses.index') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-search"></i></span>
            <span class="sidebar-menu-text">Browse Courses</span>
        </a>
    </li>
    
    <div class="sidebar-divider"></div>
    
    <li class="sidebar-menu-item">
        <a href="{{ route('profile.edit') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-user"></i></span>
            <span class="sidebar-menu-text">My Profile</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="{{ route('courses.index') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Enroll in New Course
            </a>
        </div>
        
        <!-- Continue Learning Section -->
        @if($continueLearning)
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Continue Learning</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5>{{ $continueLearning->course->title }}</h5>
                            <p class="text-muted mb-2">
                                <small>
                                    <i class="fas fa-user me-1"></i> {{ $continueLearning->course->teacher->name }}
                                    @if($continueLearning->lastAccessedLesson)
                                    <span class="ms-3">
                                        <i class="fas fa-book me-1"></i> Last Lesson: {{ $continueLearning->lastAccessedLesson->title }}
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
                                <small>{{ $continueLearning->progress }}% completed
                                ({{ $continueLearning->completed_lessons_count }}/{{ $continueLearning->total_lessons_count }} lessons)</small>
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            @if($continueLearning->lastAccessedLesson)
                                <a href="{{ route('student.lessons.show', $continueLearning->lastAccessedLesson) }}" class="btn btn-primary">
                                    <i class="fas fa-play-circle me-1"></i> Resume Learning
                                </a>
                            @else
                                <a href="{{ route('student.courses.show', $continueLearning->course) }}" class="btn btn-primary">
                                    <i class="fas fa-book-open me-1"></i> Go to Course
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-primary-subtle text-primary">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalCourses }}</h3>
                        <p>Enrolled Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-success-subtle text-success">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $completedCourses }}</h3>
                        <p>Completed Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-info-subtle text-info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $stats['completedLessons'] }}</h3>
                        <p>Completed Lessons</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-warning-subtle text-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ number_format($stats['averageScore'], 1) }}%</h3>
                        <p>Average Score</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- My Courses Section -->
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Courses</h5>
                <a href="{{ route('student.courses') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($enrollments as $enrollment)
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $enrollment->course->title }}</h5>
                                    <p class="card-text text-muted">
                                        <small>
                                            <i class="fas fa-user me-1"></i> {{ $enrollment->course->teacher->name }}
                                        </small>
                                    </p>
                                    <p class="card-text">{{ Str::limit($enrollment->course->description, 80) }}</p>
                                    
                                    <!-- Progress Bar -->
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Progress</small>
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
                                <div class="card-footer bg-white border-0">
                                    <a href="{{ route('student.courses.show', $enrollment->course) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-book-open me-1"></i> Continue Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                You are not enrolled in any courses yet.
                                <a href="{{ route('courses.index') }}" class="alert-link">Browse available courses</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Recent Quiz Results -->
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Quiz Results</h5>
                <a href="{{ route('student.results') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Quiz</th>
                                <th>Score</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentQuizResults as $result)
                                <tr>
                                    <td>{{ $result->quiz->title }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px; width: 100px;">
                                            <div class="progress-bar bg-{{ $result->percentage >= 60 ? 'success' : 'danger' }}"
                                                 role="progressbar"
                                                 style="width: {{ $result->percentage }}%;"
                                                 aria-valuenow="{{ $result->percentage }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small>{{ $result->percentage }}%</small>
                                    </td>
                                    <td>{{ $result->completed_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('student.results.show', $result) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No quiz results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recommended Courses -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recommended Courses</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(isset($recommendedCourses) && count($recommendedCourses) > 0)
                        @foreach($recommendedCourses as $course)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 140px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                            <i class="fas fa-book fa-3x text-muted"></i>
                                        </div>
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
                                    <div class="card-footer bg-white border-0">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-info-circle me-1"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                No recommended courses available at the moment.
                                <a href="{{ route('courses.index') }}" class="alert-link">Browse all courses</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
