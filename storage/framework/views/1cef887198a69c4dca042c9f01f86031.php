<?php $__env->startSection('title', 'Analytics Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Platform Analytics</h1>
            <p class="text-blue-100">Comprehensive insights into platform performance and user engagement.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-file-export mr-2"></i> Export All Data
            </a>
        </div>
    </div>
</div>

<!-- Overall Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="data-card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-900 text-blue-300 mr-4">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Students</p>
                <p class="text-2xl font-bold text-white"><?php echo e($analytics['overall']['total_students']); ?></p>
            </div>
        </div>
    </div>

    <div class="data-card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-900 text-green-300 mr-4">
                <i class="fas fa-book text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Courses</p>
                <p class="text-2xl font-bold text-white"><?php echo e($analytics['overall']['total_courses']); ?></p>
            </div>
        </div>
    </div>

    <div class="data-card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-900 text-purple-300 mr-4">
                <i class="fas fa-question-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Quizzes</p>
                <p class="text-2xl font-bold text-white"><?php echo e($analytics['overall']['total_quizzes']); ?></p>
            </div>
        </div>
    </div>

    <div class="data-card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-900 text-yellow-300 mr-4">
                <i class="fas fa-chart-pie text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Average Score</p>
                <p class="text-2xl font-bold text-white"><?php echo e($analytics['overall']['average_score']); ?>%</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Performance Distribution -->
    <div class="data-card p-6">
        <h2 class="section-title flex items-center mb-4">
            <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
            Student Performance Distribution
        </h2>
        <div class="h-64">
            <canvas id="performanceDistributionChart"></canvas>
        </div>
    </div>

    <!-- Quiz Difficulty -->
    <div class="data-card p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="section-title flex items-center">
                <i class="fas fa-tachometer-alt text-purple-500 mr-2"></i>
                Quiz Difficulty Ranking
            </h2>
            <div class="text-sm text-gray-400">
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-1"></span> Hard
                <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mx-1"></span> Medium
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full ml-1"></span> Easy
            </div>
        </div>

        <?php if(count($analytics['quiz_difficulty']) > 0): ?>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Quiz</th>
                            <th>Course</th>
                            <th>Difficulty</th>
                            <th>Avg. Score</th>
                            <th>Attempts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $analytics['quiz_difficulty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('admin.analytics.quiz', $quiz['quiz_id'])); ?>" class="hover:text-blue-400 transition-colors">
                                        <?php echo e($quiz['quiz_name']); ?>

                                    </a>
                                </td>
                                <td><?php echo e($quiz['course_name']); ?></td>
                                <td>
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full <?php echo e($quiz['difficulty_rating'] > 70 ? 'bg-red-500' : ($quiz['difficulty_rating'] > 40 ? 'bg-yellow-500' : 'bg-green-500')); ?>" style="width: <?php echo e($quiz['difficulty_rating']); ?>%"></div>
                                        </div>
                                        <span class="ml-2"><?php echo e($quiz['difficulty_rating']); ?>%</span>
                                    </div>
                                </td>
                                <td><?php echo e($quiz['average_score']); ?>%</td>
                                <td><?php echo e($quiz['attempt_count']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-chart-line text-5xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-300 mb-2">No quiz data available</h3>
                <p class="text-gray-500">Quiz data will appear here once students start taking quizzes</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Course Engagement -->
<div class="data-card p-6 mb-6">
    <h2 class="section-title flex items-center mb-4">
        <i class="fas fa-graduation-cap text-green-500 mr-2"></i>
        Course Engagement
    </h2>

    <?php if(count($analytics['course_engagement']) > 0): ?>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Students</th>
                        <th>Attempts</th>
                        <th>Completion Rate</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $analytics['course_engagement']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold mr-3">
                                        <?php echo e(strtoupper(substr($course['course_name'], 0, 1))); ?>

                                    </div>
                                    <span class="font-medium"><?php echo e($course['course_name']); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <i class="fas fa-users text-blue-400 mr-1"></i>
                                    <span><?php echo e($course['student_count']); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-check text-green-400 mr-1"></i>
                                    <span><?php echo e($course['attempt_count']); ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo e(min($course['completion_rate'], 100)); ?>%"></div>
                                    </div>
                                    <span class="ml-2"><?php echo e($course['completion_rate']); ?>%</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center">
                                    <i class="fas fa-file-alt text-purple-400 mr-1"></i>
                                    <span><?php echo e($course['content_count']); ?> items</span>
                                </div>
                            </td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('admin.analytics.course', $course['course_id'])); ?>" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors" title="View Details">
                                        <i class="fas fa-chart-line"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.analytics.course.report', $course['course_id'])); ?>" class="btn btn-sm bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors" title="Download Report">
                                        <i class="fas fa-file-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-8">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-book-reader text-5xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-300 mb-2">No course engagement data</h3>
            <p class="text-gray-500">Course engagement data will appear here once students start interacting with courses</p>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set Chart.js defaults for dark theme
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.borderColor = '#374151';

        // Performance Distribution Chart
        const distributionCtx = document.getElementById('performanceDistributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($analytics['performance_distribution']['labels']); ?>,
                datasets: [{
                    label: 'Number of Students',
                    data: <?php echo json_encode($analytics['performance_distribution']['data']); ?>,
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
                        },
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleColor: '#f3f4f6',
                        bodyColor: '#e5e7eb',
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/analytics/instructor-dashboard.blade.php ENDPATH**/ ?>