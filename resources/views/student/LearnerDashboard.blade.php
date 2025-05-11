@extends('layouts.student')

@section('title', 'Student Dashboard')

@php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
@endphp

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Welcome, {{ Auth::user()->username }}!</h1>
            <p class="text-blue-100">Your learning journey starts here. Explore courses and track your progress.</p>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="stats-label">Enrolled Courses</div>
            <div class="stats-value">
                @if(method_exists(Auth::user(), 'enrolledCourses'))
                    {{ Auth::user()->enrolledCourses()->count() }}
                @else
                    0
                @endif
            </div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="stats-label">Completed Courses</div>
            <div class="stats-value">
                @if(method_exists(Auth::user(), 'completedCourses'))
                    {{ Auth::user()->completedCourses()->count() }}
                @else
                    0
                @endif
            </div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon warning">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <div class="stats-label">Quizzes Taken</div>
            <div class="stats-value">
                @if(method_exists(Auth::user(), 'quizResults'))
                    {{ Auth::user()->quizResults()->count() }}
                @else
                    0
                @endif
            </div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon danger">
            <i class="fas fa-trophy"></i>
        </div>
        <div>
            <div class="stats-label">Achievements</div>
            <div class="stats-value">
                @if(method_exists(Auth::user(), 'achievements'))
                    {{ Auth::user()->achievements()->count() }}
                @else
                    0
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="data-card p-6 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-blue-900 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-graduation-cap text-blue-400 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">My Courses</h3>
        <p class="text-gray-400 mb-6">View courses you've enrolled in and track your progress.</p>
        <a href="{{ route('student.myCourses') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
            <i class="fas fa-arrow-right mr-2"></i> Go to My Courses
        </a>
    </div>

    <div class="data-card p-6 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-purple-900 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-book-open text-purple-400 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Explore Courses</h3>
        <p class="text-gray-400 mb-6">Discover new courses and expand your knowledge.</p>
        <a href="{{ route('student.courses') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
            <i class="fas fa-search mr-2"></i> Browse Courses
        </a>
    </div>

    <div class="data-card p-6 flex flex-col items-center text-center">
        <div class="w-16 h-16 bg-green-900 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-chart-line text-green-400 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">My Progress</h3>
        <p class="text-gray-400 mb-6">Track your learning journey and achievements.</p>
        <a href="{{ route('student.progress') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
            <i class="fas fa-chart-bar mr-2"></i> View Progress
        </a>
    </div>
</div>

<!-- Recent Activity & Leaderboard -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="data-card">
            <h2 class="section-title flex items-center">
                <i class="fas fa-history text-blue-500 mr-2"></i>
                Recent Activity
            </h2>

            <div class="space-y-4">
                @if(method_exists(Auth::user(), 'recentActivities'))
                    @forelse(Auth::user()->recentActivities()->take(5)->get() as $activity)
                        <div class="flex items-start p-3 bg-gray-800 rounded-lg">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-900 flex items-center justify-center mr-3">
                                <i class="fas fa-{{ isset($activity->type) && $activity->type == 'quiz' ? 'question-circle' : (isset($activity->type) && $activity->type == 'course' ? 'book' : 'trophy') }} text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-white">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-gray-800 rounded-lg text-center">
                            <p class="text-gray-400">No recent activity found. Start learning to see your activity here!</p>
                        </div>
                    @endforelse

                    <div class="mt-4 text-center">
                        @if(Route::has('student.analytics'))
                            <a href="{{ route('student.analytics') }}" class="text-blue-400 hover:text-blue-300 inline-flex items-center">
                                View Analytics <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @endif
                    </div>
                @else
                    <div class="p-4 bg-gray-800 rounded-lg text-center">
                        <p class="text-gray-400">Activity tracking will be available soon!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="data-card">
            <h2 class="section-title flex items-center">
                <i class="fas fa-medal text-yellow-500 mr-2"></i>
                Leaderboard
            </h2>

            <div class="space-y-3">
                @php
                    $students = \App\Models\User::where('role', 'student');
                    if (Schema::hasColumn('users', 'points')) {
                        $students = $students->orderByDesc('points');
                    }
                    $students = $students->take(5)->get();
                @endphp

                @forelse($students as $index => $user)
                    <div class="flex items-center p-3 {{ $user->id == Auth::id() ? 'bg-blue-900' : 'bg-gray-800' }} rounded-lg">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $index < 3 ? 'bg-yellow-900' : 'bg-gray-700' }} flex items-center justify-center mr-3">
                            <span class="{{ $index < 3 ? 'text-yellow-400' : 'text-gray-400' }} font-bold">{{ $index + 1 }}</span>
                        </div>
                        <div class="flex-1 flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center mr-2">
                                <span class="text-white font-bold">{{ substr($user->username, 0, 1) }}</span>
                            </div>
                            <span class="text-white {{ $user->id == Auth::id() ? 'font-bold' : '' }}">{{ $user->username }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-yellow-400 font-bold">{{ $user->points ?? 0 }}</span>
                            <span class="text-gray-400 text-xs">pts</span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 bg-gray-800 rounded-lg text-center">
                        <p class="text-gray-400">No students found in the leaderboard yet.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 text-center">
                @if(Route::has('student.leaderboard'))
                    <a href="{{ route('student.leaderboard') }}" class="text-blue-400 hover:text-blue-300 inline-flex items-center">
                        View Full Leaderboard <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
