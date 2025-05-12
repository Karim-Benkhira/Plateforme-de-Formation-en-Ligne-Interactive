@extends('layouts.app')

@section('title', 'Course Analytics - ' . $course->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.analytics') }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Analytics: {{ $course->title }}</h1>
    </div>

    <!-- Course Overview -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-book-open mr-2"></i> Course Overview
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-blue-600 dark:text-blue-400">Students</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $course->students_count ?? 0 }}</p>
                </div>
                <div class="bg-green-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-green-600 dark:text-green-400">Quizzes</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quizzes->count() }}</p>
                </div>
                <div class="bg-purple-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-purple-600 dark:text-purple-400">Avg. Completion</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ isset($quizPerformance['average_completion']) ? $quizPerformance['average_completion'] . '%' : 'N/A' }}</p>
                </div>
                <div class="bg-yellow-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-yellow-600 dark:text-yellow-400">Avg. Score</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ isset($quizPerformance['average_score']) ? $quizPerformance['average_score'] . '%' : 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <canvas id="courseOverviewChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Quiz Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-check mr-2"></i> Quiz Performance
                    </h2>
                </div>
                <div class="p-6">
                    @if($quizzes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quiz Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Attempts</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg. Score</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pass Rate</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($quizzes as $quiz)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $quiz->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $quiz->questions->count() }} questions</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ isset($quizPerformance[$quiz->id]) ? $quizPerformance[$quiz->id]['attempt_count'] : 0 }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ isset($quizPerformance[$quiz->id]) ? $quizPerformance[$quiz->id]['average_score'] . '%' : 'N/A' }}
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1">
                                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ isset($quizPerformance[$quiz->id]) ? $quizPerformance[$quiz->id]['average_score'] : 0 }}%"></div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ isset($quizPerformance[$quiz->id]) && $quizPerformance[$quiz->id]['pass_rate'] >= 70 ? 'bg-green-100 text-green-800' : (isset($quizPerformance[$quiz->id]) && $quizPerformance[$quiz->id]['pass_rate'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ isset($quizPerformance[$quiz->id]) ? $quizPerformance[$quiz->id]['pass_rate'] . '%' : 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('teacher.quizQuestions', $quiz->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900 mb-4">
                                <i class="fas fa-clipboard-check text-green-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No quizzes available for this course yet.</p>
                            <div class="mt-4 flex justify-center space-x-3">
                                <a href="{{ route('teacher.quizzes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                    <i class="fas fa-plus mr-2"></i> Create Quiz
                                </a>
                                <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 disabled:opacity-25 transition">
                                    <i class="fas fa-magic mr-2"></i> AI Generate
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Question Analysis -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-question-circle mr-2"></i> Question Analysis
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($quizPerformance['questions']) && count($quizPerformance['questions']) > 0)
                        <div class="space-y-6">
                            @foreach($quizPerformance['questions'] as $question)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-medium text-gray-800 dark:text-white">{{ $question['text'] }}</h3>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $question['correct_rate'] >= 70 ? 'bg-green-100 text-green-800' : ($question['correct_rate'] >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $question['correct_rate'] }}% correct
                                        </span>
                                    </div>
                                    <div class="mt-4">
                                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Answer Distribution</div>
                                        <div class="space-y-2">
                                            @foreach($question['answers'] as $answer)
                                                <div>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span class="{{ $answer['is_correct'] ? 'text-green-600 font-medium' : 'text-gray-600 dark:text-gray-400' }}">
                                                            {{ $answer['text'] }} {{ $answer['is_correct'] ? '(Correct)' : '' }}
                                                        </span>
                                                        <span>{{ $answer['percentage'] }}%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                        <div class="{{ $answer['is_correct'] ? 'bg-green-500' : 'bg-blue-500' }} h-2 rounded-full" style="width: {{ $answer['percentage'] }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900 mb-4">
                                <i class="fas fa-question-circle text-purple-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No question analysis data available yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Data will appear once students start taking your quizzes.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Student Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user-graduate mr-2"></i> Student Performance
                    </h2>
                </div>
                <div class="p-6">
                    @if(isset($quizPerformance['students']) && count($quizPerformance['students']) > 0)
                        <div class="space-y-4">
                            @foreach($quizPerformance['students'] as $student)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-gray-700 dark:text-gray-300 font-bold">{{ substr($student['name'], 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $student['name'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $student['quizzes_taken'] }} quizzes taken</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $student['average_score'] }}%</div>
                                        <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ $student['average_score'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900 mb-4">
                                <i class="fas fa-user-graduate text-yellow-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No student performance data available yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Data will appear once students start taking your quizzes.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Improvement Suggestions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-400 to-blue-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i> Improvement Suggestions
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-question-circle text-blue-500"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">Consider adding more questions to quizzes with fewer than 10 questions for better assessment.</p>
                            </div>
                        </div>
                        <div class="flex p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-chart-line text-blue-500"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">Review questions with less than 50% correct answers to identify potential areas of confusion.</p>
                            </div>
                        </div>
                        <div class="flex p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-magic text-blue-500"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">Try using AI-generated quizzes to create a variety of question types and difficulty levels.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Course Overview Chart
        if (document.getElementById('courseOverviewChart')) {
            const ctx = document.getElementById('courseOverviewChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
                    datasets: [{
                        label: 'Average Score',
                        data: [65, 68, 72, 70, 75, 78],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true
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
    });
</script>
@endpush
@endsection
