@include('components.header')

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Quiz Analytics: {{ $analytics['quiz']->name }}</h1>
                <p class="text-gray-600">Course: {{ $analytics['quiz']->course->title }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.analytics.course', $analytics['quiz']->course_id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Course
                </a>
            </div>
        </div>

        <!-- Overall Stats -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Students</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $analytics['overall']['unique_students'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Attempts</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $analytics['overall']['total_attempts'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Avg. Score</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $analytics['overall']['average_score'] }}%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Highest</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $analytics['overall']['highest_score'] }}%</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Lowest</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $analytics['overall']['lowest_score'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Performance Distribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Score Distribution</h2>
                <div class="h-64">
                    <canvas id="performanceDistributionChart"></canvas>
                </div>
            </div>

            <!-- Quiz Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quiz Details</h2>
                
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Quiz Type:</span>
                        <span class="font-medium">
                            @if($analytics['quiz']->is_ai_generated)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    AI Generated
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Manual
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Number of Questions:</span>
                        <span class="font-medium">{{ count($analytics['quiz']->questions) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium">{{ $analytics['quiz']->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-medium">{{ $analytics['quiz']->updated_at->format('Y-m-d') }}</span>
                    </div>
                </div>
                
                <h3 class="text-lg font-medium text-gray-700 mb-3">Questions</h3>
                <div class="space-y-4 max-h-64 overflow-y-auto pr-2">
                    @foreach($analytics['quiz']->questions as $index => $question)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p class="font-medium text-gray-800 mb-2">{{ $index + 1 }}. {{ $question->question }}</p>
                            <div class="pl-4 space-y-1">
                                @php
                                    $answers = explode(',', $question->answers);
                                @endphp
                                @foreach($answers as $answerIndex => $answer)
                                    <div class="flex items-center">
                                        <span class="w-5 h-5 flex items-center justify-center rounded-full {{ $answerIndex == $question->correct ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} mr-2 text-xs font-bold">
                                            {{ chr(65 + $answerIndex) }}
                                        </span>
                                        <span class="{{ $answerIndex == $question->correct ? 'text-green-700 font-medium' : 'text-gray-600' }}">
                                            {{ $answer }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Student Performance -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Student Performance</h2>
            
            @if(count($analytics['student_performance']) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Score</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Attempt</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($analytics['student_performance'] as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student['username'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $student['best_score'] }}%"></div>
                                            </div>
                                            <span class="ml-2">{{ $student['best_score'] }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student['attempt_count'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student['last_attempt'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('admin.analytics.student.report', $student['user_id']) }}" class="text-blue-600 hover:text-blue-900">Download Report</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No student data available yet.</p>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Performance Distribution Chart
        const distributionCtx = document.getElementById('performanceDistributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($analytics['performance_distribution']['labels']) !!},
                datasets: [{
                    label: 'Number of Students',
                    data: {!! json_encode($analytics['performance_distribution']['data']) !!},
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(5, 150, 105, 0.7)'
                    ],
                    borderColor: [
                        'rgba(239, 68, 68, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(5, 150, 105, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return 'Score Range: ' + context[0].label + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>

@include('components.footer')
