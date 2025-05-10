@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Analytics Dashboard</h1>
        <div class="flex space-x-3">
            <a href="{{ route('teacher.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <i class="fas fa-book text-blue-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Courses</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ count($courses) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                    <i class="fas fa-users text-green-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Active Students</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $studentProgress['total_students'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                    <i class="fas fa-clipboard-check text-purple-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Quiz Completions</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $studentProgress['total_completions'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mr-4">
                    <i class="fas fa-chart-line text-yellow-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Avg. Score</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $studentProgress['average_score'] ?? 0 }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Analytics Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Course Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i> Course Performance
                    </h2>
                </div>
                <div class="p-6">
                    @if(count($courses) > 0)
                        <div class="mb-6">
                            <canvas id="coursePerformanceChart" height="300"></canvas>
                        </div>
                        <div class="space-y-4">
                            @foreach($courses as $course)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        @if($course->image)
                                            <img class="h-10 w-10 rounded-full object-cover mr-4" src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-4">
                                                <i class="fas fa-book text-gray-400 dark:text-gray-300"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-medium text-gray-800 dark:text-white">{{ $course->title }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['student_count'] : 0 }} students
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-bold text-gray-800 dark:text-white">
                                            {{ isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['average_score'] : 0 }}%
                                        </div>
                                        <a href="{{ route('teacher.course-analytics', $course->id) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                                <i class="fas fa-chart-bar text-blue-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No course data available yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Create courses and assign quizzes to see performance data.</p>
                            <a href="{{ route('teacher.courses.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                <i class="fas fa-plus mr-2"></i> Create Course
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student Progress -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user-graduate mr-2"></i> Student Progress
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($studentProgress['students']) && count($studentProgress['students']) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Student</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Courses</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quizzes Completed</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg. Score</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($studentProgress['students'] as $student)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                        <span class="text-gray-700 dark:text-gray-300 font-bold">{{ substr($student['name'], 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $student['name'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">{{ $student['courses_count'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">{{ $student['quizzes_completed'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $student['average_score'] >= 70 ? 'bg-green-100 text-green-800' : ($student['average_score'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $student['average_score'] }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900 mb-4">
                                <i class="fas fa-user-graduate text-green-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No student progress data available yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Data will appear once students start taking your quizzes.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Quiz Completion Rates -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i> Quiz Completion Rates
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($coursePerformance) && count($coursePerformance) > 0)
                        <div class="mb-6">
                            <canvas id="quizCompletionChart" height="250"></canvas>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900 mb-4">
                                <i class="fas fa-clipboard-list text-purple-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No quiz completion data available yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Create quizzes and assign them to students to see completion rates.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Performance by Category -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-tags mr-2"></i> Performance by Category
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($coursePerformance) && count($coursePerformance) > 0)
                        <div class="mb-6">
                            <canvas id="categoryPerformanceChart" height="250"></canvas>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900 mb-4">
                                <i class="fas fa-tags text-yellow-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No category performance data available yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Categorize your courses to see performance by category.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sample data for charts - replace with actual data from backend
        const courseLabels = @json(array_map(function($course) { return $course->title; }, $courses->toArray()));
        const courseScores = @json(array_map(function($course) use ($coursePerformance) { 
            return isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['average_score'] : 0; 
        }, $courses->toArray()));
        
        // Course Performance Chart
        if (document.getElementById('coursePerformanceChart')) {
            const ctx = document.getElementById('coursePerformanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: courseLabels,
                    datasets: [{
                        label: 'Average Score (%)',
                        data: courseScores,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }
        
        // Quiz Completion Chart
        if (document.getElementById('quizCompletionChart')) {
            const ctx = document.getElementById('quizCompletionChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'In Progress', 'Not Started'],
                    datasets: [{
                        data: [65, 20, 15],
                        backgroundColor: [
                            'rgba(72, 187, 120, 0.7)',
                            'rgba(237, 137, 54, 0.7)',
                            'rgba(229, 62, 62, 0.7)'
                        ],
                        borderColor: [
                            'rgb(72, 187, 120)',
                            'rgb(237, 137, 54)',
                            'rgb(229, 62, 62)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        // Category Performance Chart
        if (document.getElementById('categoryPerformanceChart')) {
            const ctx = document.getElementById('categoryPerformanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: ['Programming', 'Design', 'Business', 'Marketing'],
                    datasets: [{
                        data: [85, 72, 65, 78],
                        backgroundColor: [
                            'rgba(72, 187, 120, 0.5)',
                            'rgba(66, 153, 225, 0.5)',
                            'rgba(237, 137, 54, 0.5)',
                            'rgba(159, 122, 234, 0.5)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
