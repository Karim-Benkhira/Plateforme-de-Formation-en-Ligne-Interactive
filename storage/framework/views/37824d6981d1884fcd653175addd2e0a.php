<?php $__env->startSection('title', 'My Progress'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Learning Progress</h1>
            <p class="text-blue-100">Track your achievements and growth across all courses.</p>
        </div>
        <div class="flex items-center space-x-4">
            <select id="timeFilter" class="bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="all">All Time</option>
                <option value="month">This Month</option>
                <option value="week">This Week</option>
            </select>
        </div>
    </div>
</div>

<!-- Progress Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="stats-label">Enrolled Courses</div>
            <div class="stats-value"><?php echo e($enrolledCount); ?></div>
        </div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="stats-label">Completed Courses</div>
            <div class="stats-value"><?php echo e($completedCount); ?></div>
        </div>
    </div>
    
    <div class="stats-card">
        <div class="stats-icon warning">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <div class="stats-label">Overall Progress</div>
            <div class="stats-value"><?php echo e($overallProgress); ?>%</div>
        </div>
    </div>
</div>

<!-- Learning Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Activity Chart -->
    <div class="data-card p-6">
        <h2 class="section-title flex items-center mb-6">
            <i class="fas fa-chart-line text-blue-500 mr-2"></i>
            Learning Activity
        </h2>
        
        <div class="h-80">
            <canvas id="activityChart"></canvas>
        </div>
    </div>
    
    <!-- Quiz Performance -->
    <div class="data-card p-6">
        <h2 class="section-title flex items-center mb-6">
            <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
            Quiz Performance
        </h2>
        
        <div class="h-80">
            <canvas id="quizChart"></canvas>
        </div>
    </div>
</div>

<!-- Course Progress -->
<div class="data-card p-6 mb-8">
    <h2 class="section-title flex items-center mb-6">
        <i class="fas fa-tasks text-blue-500 mr-2"></i>
        Course Progress
    </h2>
    
    <?php if(count($courseProgress) > 0): ?>
        <div class="space-y-6">
            <?php $__currentLoopData = $courseProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-blue-900 flex items-center justify-center mr-4">
                                <i class="fas fa-book text-blue-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white"><?php echo e($course['title']); ?></h3>
                                <p class="text-gray-400 text-sm"><?php echo e($course['category']); ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-white"><?php echo e($course['progress']); ?>%</div>
                            <div class="text-sm text-gray-400">
                                <?php if($course['progress'] == 100): ?>
                                    <span class="text-green-400">Completed</span>
                                <?php elseif($course['progress'] > 0): ?>
                                    <span class="text-yellow-400">In Progress</span>
                                <?php else: ?>
                                    <span class="text-gray-400">Not Started</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo e($course['progress']); ?>%"></div>
                    </div>
                    
                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="flex items-center mr-4">
                                <i class="fas fa-clock text-gray-500 mr-1"></i>
                                <span class="text-gray-400 text-sm"><?php echo e($course['time_spent']); ?> hrs</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                <span class="text-gray-400 text-sm"><?php echo e($course['score']); ?>/100</span>
                            </div>
                        </div>
                        <a href="<?php echo e(route('student.showCourse', $course['id'])); ?>" class="text-blue-400 hover:text-blue-300 text-sm flex items-center">
                            <span>Continue Learning</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-8">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-open text-gray-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">No Course Progress Yet</h3>
            <p class="text-gray-400 mb-6">You haven't started any courses yet. Enroll in courses to track your progress.</p>
            <a href="<?php echo e(route('student.courses')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
                <i class="fas fa-search mr-2"></i> Explore Courses
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Skills Acquired -->
<div class="data-card p-6 mb-8">
    <h2 class="section-title flex items-center mb-6">
        <i class="fas fa-brain text-blue-500 mr-2"></i>
        Skills Acquired
    </h2>
    
    <?php if(count($skills) > 0): ?>
        <div class="flex flex-wrap gap-3">
            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-800 rounded-full px-4 py-2 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-<?php echo e($skill['color']); ?>-900 flex items-center justify-center mr-2">
                        <i class="fas fa-<?php echo e($skill['icon']); ?> text-<?php echo e($skill['color']); ?>-400 text-sm"></i>
                    </div>
                    <span class="text-white"><?php echo e($skill['name']); ?></span>
                    <span class="ml-2 bg-<?php echo e($skill['color']); ?>-900 text-<?php echo e($skill['color']); ?>-400 text-xs font-bold px-2 py-0.5 rounded-full"><?php echo e($skill['level']); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-4">
            <p class="text-gray-400">Complete courses to acquire skills.</p>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activity Chart
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($activityData['labels']); ?>,
                datasets: [{
                    label: 'Hours Spent',
                    data: <?php echo json_encode($activityData['values']); ?>,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
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
                            color: 'rgba(255, 255, 255, 0.7)'
                        }
                    }
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
                    data: <?php echo json_encode($quizData); ?>,
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green
                        'rgba(59, 130, 246, 0.8)',  // Blue
                        'rgba(245, 158, 11, 0.8)',  // Yellow
                        'rgba(239, 68, 68, 0.8)'    // Red
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
        
        // Time filter functionality
        document.getElementById('timeFilter').addEventListener('change', function() {
            // In a real application, this would trigger an AJAX request to update the data
            // For now, we'll just show an alert
            alert('Time filter changed to: ' + this.value);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/progress.blade.php ENDPATH**/ ?>