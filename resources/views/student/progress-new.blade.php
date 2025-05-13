@extends('layouts.student')

@section('title', 'My Progress')

@section('content')
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Learning Journey</h1>
            <p class="text-blue-100">Track your achievements and growth across all courses.</p>
        </div>
        <div class="flex items-center space-x-4">
            <select id="timeFilter" class="bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                <option value="all">All Time</option>
                <option value="month">This Month</option>
                <option value="week">This Week</option>
            </select>
        </div>
    </div>
</div>

<!-- Progress Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stats-card bg-gradient-to-br from-primary-900 to-primary-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="stats-label">Enrolled Courses</div>
            <div class="stats-value">{{ $enrolledCount }}</div>
        </div>
    </div>
    
    <div class="stats-card bg-gradient-to-br from-green-900 to-green-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="stats-label">Completed Courses</div>
            <div class="stats-value">{{ $completedCount }}</div>
        </div>
    </div>
    
    <div class="stats-card bg-gradient-to-br from-amber-900 to-amber-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon warning">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <div class="stats-label">Overall Progress</div>
            <div class="stats-value">{{ $overallProgress }}%</div>
            <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $overallProgress }}%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Learning Activity & Quiz Performance -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Activity Chart -->
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-chart-line mr-2"></i> Learning Activity
        </div>
        <div class="section-content">
            <div class="h-80">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quiz Performance -->
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-chart-pie mr-2"></i> Quiz Performance
        </div>
        <div class="section-content">
            <div class="h-80">
                <canvas id="quizChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Course Progress -->
<div class="section-card mb-8">
    <div class="section-header flex justify-between items-center">
        <div>
            <i class="fas fa-tasks mr-2"></i> Course Progress
        </div>
        <div class="flex space-x-2">
            <button id="grid-view" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors active">
                <i class="fas fa-th-large"></i>
            </button>
            <button id="list-view" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    <div class="section-content">
        @if(count($courseProgress) > 0)
            <!-- Grid View (default) -->
            <div id="grid-view-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach($courseProgress as $course)
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <div class="p-4">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-lg bg-primary-900 flex items-center justify-center mr-4">
                                    <i class="fas fa-book text-primary-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white line-clamp-1">{{ $course['title'] }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $course['category'] }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-400 text-sm">Progress</span>
                                    <div class="flex items-center">
                                        <span class="text-lg font-bold 
                                            @if($course['progress'] == 100) text-green-400
                                            @elseif($course['progress'] > 50) text-amber-400
                                            @else text-primary-400 @endif">
                                            {{ $course['progress'] }}%
                                        </span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full 
                                        @if($course['progress'] == 100) bg-green-500
                                        @elseif($course['progress'] > 50) bg-amber-500
                                        @else bg-primary-500 @endif" 
                                        style="width: {{ $course['progress'] }}%">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <div class="flex items-center mr-4">
                                        <i class="fas fa-clock text-gray-500 mr-1"></i>
                                        <span class="text-gray-400 text-sm">{{ $course['time_spent'] }} hrs</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        <span class="text-gray-400 text-sm">{{ $course['score'] }}/100</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        @if($course['progress'] == 100) bg-green-900 text-green-400
                                        @elseif($course['progress'] > 0) bg-amber-900 text-amber-400
                                        @else bg-gray-700 text-gray-400 @endif">
                                        @if($course['progress'] == 100)
                                            Completed
                                        @elseif($course['progress'] > 0)
                                            In Progress
                                        @else
                                            Not Started
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('student.showCourse', $course['id']) }}" 
                                   class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                    <i class="fas fa-arrow-right mr-2"></i> Continue
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- List View (hidden by default) -->
            <div id="list-view-container" class="hidden space-y-4 mt-6">
                @foreach($courseProgress as $course)
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="p-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg bg-primary-900 flex items-center justify-center mr-4">
                                        <i class="fas fa-book text-primary-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-white">{{ $course['title'] }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $course['category'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold 
                                        @if($course['progress'] == 100) text-green-400
                                        @elseif($course['progress'] > 50) text-amber-400
                                        @else text-primary-400 @endif">
                                        {{ $course['progress'] }}%
                                    </div>
                                    <div class="text-sm">
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            @if($course['progress'] == 100) bg-green-900 text-green-400
                                            @elseif($course['progress'] > 0) bg-amber-900 text-amber-400
                                            @else bg-gray-700 text-gray-400 @endif">
                                            @if($course['progress'] == 100)
                                                Completed
                                            @elseif($course['progress'] > 0)
                                                In Progress
                                            @else
                                                Not Started
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="w-full bg-gray-700 rounded-full h-2.5 my-4">
                                <div class="h-2.5 rounded-full 
                                    @if($course['progress'] == 100) bg-green-500
                                    @elseif($course['progress'] > 50) bg-amber-500
                                    @else bg-primary-500 @endif" 
                                    style="width: {{ $course['progress'] }}%">
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex items-center mr-4">
                                        <i class="fas fa-clock text-gray-500 mr-1"></i>
                                        <span class="text-gray-400 text-sm">{{ $course['time_spent'] }} hrs</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        <span class="text-gray-400 text-sm">{{ $course['score'] }}/100</span>
                                    </div>
                                </div>
                                <a href="{{ route('student.showCourse', $course['id']) }}" 
                                   class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                    <i class="fas fa-arrow-right mr-2"></i> Continue
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book-open text-gray-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No Course Progress Yet</h3>
                <p class="text-gray-400 mb-6">You haven't started any courses yet. Enroll in courses to track your progress.</p>
                <a href="{{ route('student.courses') }}" 
                   class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 inline-flex items-center transform hover:scale-105">
                    <i class="fas fa-search mr-2"></i> Explore Courses
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Skills Acquired -->
<div class="section-card mb-8">
    <div class="section-header">
        <i class="fas fa-brain mr-2"></i> Skills Acquired
    </div>
    <div class="section-content">
        @if(count($skills) > 0)
            <div class="flex flex-wrap gap-3">
                @foreach($skills as $skill)
                    <div class="bg-gray-800 rounded-full px-4 py-2 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="w-8 h-8 rounded-full bg-{{ $skill['color'] }}-900 flex items-center justify-center mr-2">
                            <i class="fas fa-{{ $skill['icon'] }} text-{{ $skill['color'] }}-400 text-sm"></i>
                        </div>
                        <span class="text-white">{{ $skill['name'] }}</span>
                        <span class="ml-2 bg-{{ $skill['color'] }}-900 text-{{ $skill['color'] }}-400 text-xs font-bold px-2 py-0.5 rounded-full">{{ $skill['level'] }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-gray-400">Complete courses to acquire skills.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set chart defaults for dark theme
        Chart.defaults.color = 'rgba(255, 255, 255, 0.7)';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
        
        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($activityData['labels']) !!},
                datasets: [{
                    label: 'Hours Spent',
                    data: {!! json_encode($activityData['values']) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
        
        // Quiz Performance Chart
        const quizCtx = document.getElementById('quizChart').getContext('2d');
        const quizChart = new Chart(quizCtx, {
            type: 'doughnut',
            data: {
                labels: ['Excellent', 'Good', 'Average', 'Needs Improvement'],
                datasets: [{
                    data: {!! json_encode($quizData) !!},
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green
                        'rgba(79, 70, 229, 0.8)',   // Indigo
                        'rgba(245, 158, 11, 0.8)',  // Amber
                        'rgba(239, 68, 68, 0.8)'    // Red
                    ],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            padding: 20,
                            font: {
                                size: 12
                            },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function(label, i) {
                                        const meta = chart.getDatasetMeta(0);
                                        const style = meta.controller.getStyle(i);
                                        
                                        return {
                                            text: `${label}: ${data.datasets[0].data[i]}`,
                                            fillStyle: style.backgroundColor,
                                            strokeStyle: style.borderColor,
                                            lineWidth: style.borderWidth,
                                            hidden: isNaN(data.datasets[0].data[i]) || meta.data[i].hidden,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1000,
                    easing: 'easeOutCirc'
                }
            }
        });
        
        // View toggle functionality
        const gridViewBtn = document.getElementById('grid-view');
        const listViewBtn = document.getElementById('list-view');
        const gridViewContainer = document.getElementById('grid-view-container');
        const listViewContainer = document.getElementById('list-view-container');
        
        gridViewBtn.addEventListener('click', function() {
            gridViewContainer.classList.remove('hidden');
            listViewContainer.classList.add('hidden');
            gridViewBtn.classList.add('active', 'bg-primary-600');
            gridViewBtn.classList.remove('bg-gray-700');
            listViewBtn.classList.remove('active', 'bg-primary-600');
            listViewBtn.classList.add('bg-gray-700');
        });
        
        listViewBtn.addEventListener('click', function() {
            gridViewContainer.classList.add('hidden');
            listViewContainer.classList.remove('hidden');
            listViewBtn.classList.add('active', 'bg-primary-600');
            listViewBtn.classList.remove('bg-gray-700');
            gridViewBtn.classList.remove('active', 'bg-primary-600');
            gridViewBtn.classList.add('bg-gray-700');
        });
        
        // Time filter functionality
        document.getElementById('timeFilter').addEventListener('change', function() {
            // In a real application, this would trigger an AJAX request to update the data
            // For now, we'll just show a notification
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-primary-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in-up';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Time filter changed to: ${this.value}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('animate-fade-out');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 3000);
        });
    });
</script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
    
    .animate-fade-out {
        animation: fadeOut 0.5s ease-out forwards;
    }
</style>
@endpush
@endsection
