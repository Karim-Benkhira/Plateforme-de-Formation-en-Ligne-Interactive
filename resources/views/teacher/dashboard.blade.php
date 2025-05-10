@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Teacher Dashboard</h1>
        <div>
            <a href="{{ route('teacher.courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Create New Course
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <i class="fas fa-book text-blue-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Courses</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $coursesCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                    <i class="fas fa-question-circle text-green-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Quizzes</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quizzesCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                    <i class="fas fa-users text-purple-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Students</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $studentCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('teacher.courses') }}" class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <i class="fas fa-book text-blue-500 text-2xl mb-2"></i>
                <span class="text-gray-800 dark:text-white">Manage Courses</span>
            </a>
            <a href="{{ route('teacher.quizzes') }}" class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <i class="fas fa-question-circle text-green-500 text-2xl mb-2"></i>
                <span class="text-gray-800 dark:text-white">Manage Quizzes</span>
            </a>
            <a href="{{ route('teacher.quizzes.create') }}" class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <i class="fas fa-plus-circle text-yellow-500 text-2xl mb-2"></i>
                <span class="text-gray-800 dark:text-white">Create Quiz</span>
            </a>
            <a href="{{ route('teacher.analytics') }}" class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <i class="fas fa-chart-line text-purple-500 text-2xl mb-2"></i>
                <span class="text-gray-800 dark:text-white">View Analytics</span>
            </a>
        </div>
    </div>

    <!-- Recent Quiz Results -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Recent Quiz Results</h2>
        
        @if(count($recentQuizResults) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quiz</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentQuizResults as $result)
                            <tr>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">{{ $result->student_name }}</td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">{{ $result->quiz_name }}</td>
                                <td class="py-4 px-4 text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $result->score >= 70 ? 'bg-green-100 text-green-800' : ($result->score >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $result->score }}%
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">{{ $result->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No recent quiz results available.</p>
        @endif
    </div>
</div>
@endsection
