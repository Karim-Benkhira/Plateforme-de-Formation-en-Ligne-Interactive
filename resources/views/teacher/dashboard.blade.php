@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">Welcome, teacher!</h1>
            <p class="text-blue-100">Manage your courses, create interactive quizzes, and track student progress.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('teacher.courses.create') }}" class="btn-white">
                <i class="fas fa-plus"></i> Create Course
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="stats-label">Total Courses</p>
            <p class="stats-value">{{ $coursesCount ?? 0 }}</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <p class="stats-label">Total Quizzes</p>
            <p class="stats-value">{{ $quizzesCount ?? 0 }}</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon secondary">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="stats-label">Total Students</p>
            <p class="stats-value">{{ $studentCount ?? 0 }}</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon secondary">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <p class="stats-label">Avg. Score</p>
            <p class="stats-value">{{ count($recentQuizResults ?? []) > 0 ? round($recentQuizResults->avg('score')) : 0 }}%</p>
        </div>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Course Management -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-book-open mr-2"></i> Course Management
            </div>
            <div class="section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('teacher.courses') }}" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Manage Courses</h3>
                            <p class="action-description">View and edit your courses</p>
                        </div>
                    </a>
                    <a href="{{ route('teacher.courses.create') }}" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Create New Course</h3>
                            <p class="action-description">Add a new course to your catalog</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quiz & Assessment -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-question-circle mr-2"></i> Quiz & Assessment
            </div>
            <div class="section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('teacher.quizzes') }}" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Manage Quizzes</h3>
                            <p class="action-description">View and edit your quizzes</p>
                        </div>
                    </a>
                    <a href="{{ route('teacher.quizzes.create') }}" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Create Manual Quiz</h3>
                            <p class="action-description">Create a quiz manually</p>
                        </div>
                    </a>
                    <a href="{{ route('teacher.courses') }}" class="action-card">
                        <div class="action-icon secondary">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div>
                            <h3 class="action-title">AI-Generated Quiz</h3>
                            <p class="action-description">Create quiz using AI</p>
                        </div>
                    </a>
                    <a href="{{ route('face.exam.monitoring') }}" class="action-card">
                        <div class="action-icon secondary">
                            <i class="fas fa-video"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Secure Exam Monitoring</h3>
                            <p class="action-description">Monitor exams with face recognition</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Analytics & Reporting -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-chart-line mr-2"></i> Analytics & Reporting
            </div>
            <div class="section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('teacher.analytics') }}" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Performance Dashboard</h3>
                            <p class="action-description">View overall analytics</p>
                        </div>
                    </a>
                    <a href="{{ route('teacher.analytics') }}" class="action-card">
                        <div class="action-icon secondary">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Student Progress</h3>
                            <p class="action-description">Track individual student performance</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Recent Quiz Results -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-clipboard-list mr-2"></i> Recent Quiz Results
            </div>
            <div class="section-content">
                @if(isset($recentQuizResults) && count($recentQuizResults) > 0)
                    <div class="space-y-4">
                        @foreach($recentQuizResults as $result)
                            <div class="flex items-center p-3 bg-gray-800 rounded-lg">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center">
                                        <span class="text-primary-300 font-bold">{{ substr($result->student_name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center">
                                        <h3 class="font-medium text-white">{{ $result->student_name }}</h3>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $result->score >= 70 ? 'bg-primary-900 text-primary-300' : ($result->score >= 50 ? 'bg-secondary-900 text-secondary-300' : 'bg-red-900 text-red-300') }}">
                                            {{ $result->score }}%
                                        </span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <p class="text-gray-400">{{ $result->quiz_name }}</p>
                                        <p class="text-gray-500">{{ $result->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-clipboard text-primary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No recent quiz results</p>
                        <p class="text-sm text-gray-500 mt-2">Results will appear here once students complete quizzes</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Teaching Tips -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-lightbulb mr-2"></i> Teaching Tips
            </div>
            <div class="section-content">
                <div class="space-y-4">
                    <div class="tip-card">
                        <div class="tip-icon bg-primary-900">
                            <i class="fas fa-robot text-primary-400"></i>
                        </div>
                        <p class="tip-text">Use AI to generate quizzes from your course content to save time.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon bg-primary-900">
                            <i class="fas fa-chart-pie text-primary-400"></i>
                        </div>
                        <p class="tip-text">Check analytics regularly to identify struggling students early.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon bg-secondary-900">
                            <i class="fas fa-video text-secondary-400"></i>
                        </div>
                        <p class="tip-text">Use secure exams with face recognition for high-stakes assessments.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any dashboard-specific JavaScript here
</script>
@endpush
