<?php $__env->startSection('title', 'Analytics Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center relative z-10">
        <div>
            <h1 class="text-4xl font-bold mb-2 text-white text-shadow">📊 Analytics Dashboard</h1>
            <p class="text-pink-100 text-lg">Track student performance and course effectiveness</p>
        </div>
        <div class="mt-6 md:mt-0">
            <a href="<?php echo e(route('teacher.dashboard')); ?>"
               class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl transition-all flex items-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-arrow-left mr-3 text-lg"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl gradient-pink-blue mr-4">
                <i class="fas fa-book text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Courses</p>
                <p class="text-2xl font-bold text-white"><?php echo e(count($courses)); ?></p>
            </div>
        </div>
    </div>

    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 mr-4">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Active Students</p>
                <p class="text-2xl font-bold text-white"><?php echo e($studentProgress['total_students'] ?? 0); ?></p>
            </div>
        </div>
    </div>

    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 mr-4">
                <i class="fas fa-clipboard-check text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Quiz Completions</p>
                <p class="text-2xl font-bold text-white"><?php echo e($studentProgress['total_completions'] ?? 0); ?></p>
            </div>
        </div>
    </div>

    <div class="stats-card card-hover">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-600 mr-4">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Avg. Score</p>
                <p class="text-2xl font-bold text-white"><?php echo e($studentProgress['average_score'] ?? 0); ?>%</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Analytics Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Course Performance -->
        <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl border border-pink-500/20 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-pink-400"></i> Course Performance
                </h2>
            </div>

            <?php if(count($courses) > 0): ?>
                <div class="mb-6">
                    <canvas id="coursePerformanceChart" height="300"></canvas>
                </div>
                <div class="space-y-4">
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl hover:bg-gray-700/50 transition-all card-hover border border-gray-700/50">
                            <div class="flex items-center">
                                <?php if($course->image): ?>
                                    <img class="h-12 w-12 rounded-full object-cover mr-4" src="<?php echo e(asset('storage/' . $course->image)); ?>" alt="<?php echo e($course->title); ?>">
                                <?php else: ?>
                                    <div class="h-12 w-12 rounded-full gradient-pink-blue flex items-center justify-center mr-4">
                                        <i class="fas fa-book text-white"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h3 class="font-semibold text-white"><?php echo e($course->title); ?></h3>
                                    <p class="text-sm text-gray-400">
                                        <?php echo e(isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['student_count'] : 0); ?> students enrolled
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-white mb-1">
                                    <?php echo e(isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['average_score'] : 0); ?>%
                                </div>
                                <a href="<?php echo e(route('teacher.course-analytics', $course->id)); ?>"
                                   class="text-sm text-pink-400 hover:text-pink-300 flex items-center justify-end transition-colors">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-20 h-20 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No Course Data Available</h3>
                    <p class="text-gray-400 mb-6">Create courses and assign quizzes to see performance data.</p>
                    <a href="<?php echo e(route('teacher.courses.create')); ?>"
                       class="gradient-pink-blue hover:opacity-90 text-white px-6 py-3 rounded-xl transition-all inline-flex items-center font-medium shadow-lg">
                        <i class="fas fa-plus mr-2"></i> Create Course
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Student Progress -->
        <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl border border-pink-500/20 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-user-graduate mr-3 text-pink-400"></i> Student Progress
                </h2>
            </div>

            <?php if(isset($studentProgress['students']) && count($studentProgress['students']) > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $studentProgress['students']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700/50 hover:border-pink-400/50 transition-all card-hover">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full gradient-pink-blue flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-lg"><?php echo e(substr($student['name'], 0, 1)); ?></span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white"><?php echo e($student['name']); ?></h3>
                                        <p class="text-sm text-gray-400"><?php echo e($student['courses_count']); ?> courses • <?php echo e($student['quizzes_completed']); ?> quizzes</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-white"><?php echo e($student['average_score']); ?>%</div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        <?php echo e($student['average_score'] >= 70 ? 'bg-emerald-500/20 text-emerald-300' : ($student['average_score'] >= 50 ? 'bg-yellow-500/20 text-yellow-300' : 'bg-red-500/20 text-red-300')); ?>">
                                        <?php echo e($student['average_score'] >= 70 ? 'Excellent' : ($student['average_score'] >= 50 ? 'Good' : 'Needs Improvement')); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-20 h-20 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No Student Data Available</h3>
                    <p class="text-gray-400">Data will appear once students start taking your quizzes.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Quiz Completion Rates -->
        <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl border border-pink-500/20 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-clipboard-list mr-3 text-pink-400"></i> Quiz Completion Rates
                </h2>
            </div>

            <?php if(isset($coursePerformance) && count($coursePerformance) > 0): ?>
                <div class="mb-6">
                    <canvas id="quizCompletionChart" height="250"></canvas>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No Quiz Data</h3>
                    <p class="text-gray-400 text-sm">Create quizzes and assign them to students to see completion rates.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Performance by Category -->
        <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl border border-pink-500/20 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-tags mr-3 text-pink-400"></i> Performance by Category
                </h2>
            </div>

            <?php if(isset($coursePerformance) && count($coursePerformance) > 0): ?>
                <div class="mb-6">
                    <canvas id="categoryPerformanceChart" height="250"></canvas>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-tags text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">No Category Data</h3>
                    <p class="text-gray-400 text-sm">Categorize your courses to see performance by category.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set global Chart.js options for dark theme
        Chart.defaults.color = '#94a3b8'; // text color
        Chart.defaults.borderColor = '#334155'; // border color

        // Sample data for charts - replace with actual data from backend
        const courseLabels = <?php echo json_encode($courses->pluck('title')->toArray(), 15, 512) ?>;
        const courseScores = <?php echo json_encode($courses->map(function($course) use ($coursePerformance) {
            return isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['average_score'] : 0;
        })->toArray(), 15, 512) ?>;

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
                        backgroundColor: 'rgba(236, 72, 153, 0.6)', // pink gradient
                        borderColor: 'rgb(236, 72, 153)', // pink
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#e2e8f0'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: '#374151'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        },
                        x: {
                            grid: {
                                color: '#374151'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
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
                            'rgba(236, 72, 153, 0.8)', // pink
                            'rgba(139, 92, 246, 0.8)', // purple
                            'rgba(107, 114, 128, 0.8)' // gray
                        ],
                        borderColor: [
                            'rgb(236, 72, 153)', // pink
                            'rgb(139, 92, 246)', // purple
                            'rgb(107, 114, 128)' // gray
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e2e8f0',
                                padding: 20,
                                font: {
                                    size: 12
                                }
                            }
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
                            'rgba(236, 72, 153, 0.7)', // pink
                            'rgba(139, 92, 246, 0.7)', // purple
                            'rgba(59, 130, 246, 0.7)', // blue
                            'rgba(16, 185, 129, 0.7)' // emerald
                        ],
                        borderColor: [
                            'rgb(236, 72, 153)', // pink
                            'rgb(139, 92, 246)', // purple
                            'rgb(59, 130, 246)', // blue
                            'rgb(16, 185, 129)' // emerald
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e2e8f0',
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/analytics.blade.php ENDPATH**/ ?>