@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@push('styles')
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
    }
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    .dashboard-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .dashboard-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
        transform: translateY(-2px);
    }
    .stats-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    .stats-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<!-- Welcome Banner -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center relative z-10">
        <div>
            <h1 class="text-4xl font-bold mb-2 text-white text-shadow">🎓 Welcome, Teacher!</h1>
            <p class="text-pink-100 text-lg">Manage your courses, create interactive quizzes, and track student progress.</p>
        </div>
        <div class="mt-6 md:mt-0">
            <a href="{{ route('teacher.courses.create') }}"
               class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl transition-all flex items-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-3 text-lg"></i> Create Course
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl gradient-pink-blue mr-4">
                <i class="fas fa-book text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Courses</p>
                <p class="text-2xl font-bold text-white">{{ $coursesCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-purple-500 to-pink-600 mr-4">
                <i class="fas fa-question-circle text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Quizzes</p>
                <p class="text-2xl font-bold text-white">{{ $quizzesCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 mr-4">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Students</p>
                <p class="text-2xl font-bold text-white">{{ $studentCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-600 mr-4">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Avg. Score</p>
                <p class="text-2xl font-bold text-white">{{ count($recentQuizResults ?? []) > 0 ? round($recentQuizResults->avg('score')) : 0 }}%</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Course Management -->
        <div class="dashboard-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-book-open mr-3 text-pink-400"></i> Course Management
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- New Course Builder -->
                <a href="{{ route('teacher.course-builder.index') }}" class="relative bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl p-6 text-white transition-all card-hover border-2 border-purple-500/50 hover:border-purple-400">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <i class="fas fa-layer-group text-xl"></i>
                        </div>
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-2 py-1 rounded-lg animate-pulse">NEW</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Course Builder</h3>
                    <p class="text-purple-100 text-sm">Create courses like Udemy with sections & lessons</p>
                </a>

                <a href="{{ route('teacher.course-builder.create') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-pink-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 gradient-pink-blue rounded-xl mr-4">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Create New Course</h3>
                    <p class="text-gray-400 text-sm">Start building a professional course</p>
                </a>

                <a href="{{ route('teacher.courses') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-blue-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl mr-4">
                            <i class="fas fa-list text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Manage Courses</h3>
                    <p class="text-gray-400 text-sm">View and edit your existing courses</p>
                </a>

                <a href="{{ route('teacher.courses.create') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-emerald-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl mr-4">
                            <i class="fas fa-file-plus text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Simple Course</h3>
                    <p class="text-gray-400 text-sm">Create basic course (legacy format)</p>
                </a>
            </div>
        </div>

        <!-- Quiz & Assessment -->
        <div class="dashboard-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-question-circle mr-3 text-purple-400"></i> Quiz & Assessment
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('teacher.quizzes') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-purple-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl mr-4">
                            <i class="fas fa-list-alt text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Manage Quizzes</h3>
                    <p class="text-gray-400 text-sm">View and edit your existing quizzes</p>
                </a>

                <a href="{{ route('teacher.quizzes.create') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-pink-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 gradient-pink-blue rounded-xl mr-4">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Create Manual Quiz</h3>
                    <p class="text-gray-400 text-sm">Create a quiz manually with custom questions</p>
                </a>

                <!-- AI Quiz Generation removed - now only available in student practice section -->

                <a href="{{ route('teacher.face-verification') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-red-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl mr-4">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Face Verification Status</h3>
                    <p class="text-gray-400 text-sm">Monitor student verification status</p>
                </a>
            </div>
        </div>

        <!-- Analytics & Reporting -->
        <div class="dashboard-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-chart-line mr-3 text-blue-400"></i> Analytics & Reporting
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('teacher.analytics') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-blue-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl mr-4">
                            <i class="fas fa-chart-bar text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Performance Dashboard</h3>
                    <p class="text-gray-400 text-sm">View comprehensive analytics and insights</p>
                </a>

                <a href="{{ route('teacher.analytics') }}" class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50 hover:border-emerald-400/50 transition-all card-hover">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl mr-4">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Student Progress</h3>
                    <p class="text-gray-400 text-sm">Track individual student performance</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Recent Quiz Results -->
        <div class="dashboard-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-clipboard-list mr-3 text-green-400"></i> Recent Quiz Results
                </h2>
            </div>

            @if(isset($recentQuizResults) && count($recentQuizResults) > 0)
                <div class="space-y-4">
                    @foreach($recentQuizResults as $result)
                        <div class="flex items-center p-4 bg-gray-800/50 rounded-xl border border-gray-700/50 hover:border-pink-400/50 transition-all">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 rounded-full gradient-pink-blue flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr($result->student_name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="font-semibold text-white">{{ $result->student_name }}</h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $result->score >= 70 ? 'bg-emerald-500/20 text-emerald-300' : ($result->score >= 50 ? 'bg-yellow-500/20 text-yellow-300' : 'bg-red-500/20 text-red-300') }}">
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
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No Recent Results</h3>
                    <p class="text-gray-400 text-sm">Results will appear here once students complete quizzes</p>
                </div>
            @endif
        </div>

        <!-- Teaching Tips -->
        <div class="dashboard-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-lightbulb mr-3 text-yellow-400"></i> Teaching Tips
                </h2>
            </div>

            <div class="space-y-4">
                <!-- AI Quiz Generation tip removed - now only available in student practice section -->

                <div class="flex items-start p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                    <div class="p-2 rounded-lg gradient-pink-blue mr-3 flex-shrink-0">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <p class="text-gray-300 text-sm">Check analytics regularly to identify struggling students early and provide targeted support.</p>
                </div>

                <div class="flex items-start p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                    <div class="p-2 rounded-lg bg-gradient-to-r from-red-500 to-pink-600 mr-3 flex-shrink-0">
                        <i class="fas fa-video text-white"></i>
                    </div>
                    <p class="text-gray-300 text-sm">Use secure exams with face recognition for high-stakes assessments to ensure academic integrity.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
