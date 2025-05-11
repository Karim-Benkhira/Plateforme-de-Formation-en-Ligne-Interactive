@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Welcome, {{ Auth::user()->username }}!</h1>
            <p class="text-blue-100">Manage your platform, monitor user activity, and keep everything running smoothly.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.createCourse') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Course
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="stats-label">Total Users</p>
            <p class="stats-value">{{ $totalUsers }}</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon success">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="stats-label">Active Courses</p>
            <p class="stats-value">{{ $activeCourses }}</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon warning">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <p class="stats-label">Quizzes Taken</p>
            <p class="stats-value">{{ $quizzesTaken }}</p>
        </div>
    </div>
</div>

<!-- Leaderboard -->
<div class="data-card mb-8">
    <h2 class="section-title flex items-center">
        <i class="fas fa-trophy text-yellow-500 mr-2"></i>
        Top 10 Users Leaderboard
    </h2>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-16">#</th>
                    <th>Username</th>
                    <th>Total Score</th>
                    <th>Quizzes Taken</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaders as $index => $user)
                <tr>
                    <td>
                        @if($index === 0)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-500 text-white font-bold">1</span>
                        @elseif($index === 1)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-400 text-white font-bold">2</span>
                        @elseif($index === 2)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-700 text-white font-bold">3</span>
                        @else
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-700 text-white font-bold">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td class="font-medium">{{ $user->username }}</td>
                    <td>
                        <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full font-medium text-sm">{{ $user->total_score }} pts</span>
                    </td>
                    <td>{{ $user->quizzes_count }}</td>
                </tr>
                @endforeach

                @if($leaders->isEmpty())
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No leaderboard data available yet.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="data-card">
        <h2 class="section-title flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i>
            Quick Actions
        </h2>

        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.users') }}" class="bg-gray-700 hover:bg-gray-600 p-4 rounded-lg flex flex-col items-center justify-center transition-colors">
                <i class="fas fa-users text-blue-400 text-2xl mb-2"></i>
                <span class="text-sm font-medium">Manage Users</span>
            </a>

            <a href="{{ route('admin.courses') }}" class="bg-gray-700 hover:bg-gray-600 p-4 rounded-lg flex flex-col items-center justify-center transition-colors">
                <i class="fas fa-book text-green-400 text-2xl mb-2"></i>
                <span class="text-sm font-medium">Manage Courses</span>
            </a>

            <a href="{{ route('admin.quizzes') }}" class="bg-gray-700 hover:bg-gray-600 p-4 rounded-lg flex flex-col items-center justify-center transition-colors">
                <i class="fas fa-question-circle text-purple-400 text-2xl mb-2"></i>
                <span class="text-sm font-medium">Manage Quizzes</span>
            </a>

            <a href="{{ route('admin.reclamations') }}" class="bg-gray-700 hover:bg-gray-600 p-4 rounded-lg flex flex-col items-center justify-center transition-colors">
                <i class="fas fa-flag text-red-400 text-2xl mb-2"></i>
                <span class="text-sm font-medium">View Reports</span>
            </a>
        </div>
    </div>

    <div class="data-card">
        <h2 class="section-title flex items-center">
            <i class="fas fa-chart-line text-green-500 mr-2"></i>
            Platform Overview
        </h2>

        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-blue-400 mr-3"></i>
                    <span>Students</span>
                </div>
                <span class="font-semibold">{{ App\Models\User::where('role', 'user')->count() }}</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-chalkboard-teacher text-purple-400 mr-3"></i>
                    <span>Teachers</span>
                </div>
                <span class="font-semibold">{{ App\Models\User::where('role', 'teacher')->count() }}</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-tags text-yellow-400 mr-3"></i>
                    <span>Categories</span>
                </div>
                <span class="font-semibold">{{ App\Models\Category::count() }}</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-question text-green-400 mr-3"></i>
                    <span>Quiz Questions</span>
                </div>
                <span class="font-semibold">{{ App\Models\Question::count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection