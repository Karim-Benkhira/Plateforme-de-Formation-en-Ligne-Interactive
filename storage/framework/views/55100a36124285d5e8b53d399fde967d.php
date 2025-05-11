<?php $__env->startSection('title', 'Analytics Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white">Analytics Dashboard</h1>
            <p class="text-blue-100">Track student performance and course effectiveness</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn-white">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="stats-label">Total Courses</p>
            <p class="stats-value"><?php echo e(count($courses)); ?></p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="stats-label">Active Students</p>
            <p class="stats-value"><?php echo e($studentProgress['total_students'] ?? 0); ?></p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon secondary">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div>
            <p class="stats-label">Quiz Completions</p>
            <p class="stats-value"><?php echo e($studentProgress['total_completions'] ?? 0); ?></p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon secondary">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <p class="stats-label">Avg. Score</p>
            <p class="stats-value"><?php echo e($studentProgress['average_score'] ?? 0); ?>%</p>
        </div>
    </div>
</div>

<!-- Main Analytics Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Course Performance -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-chart-bar mr-2"></i> Course Performance
            </div>
            <div class="section-content">
                <?php if(count($courses) > 0): ?>
                    <div class="mb-6">
                        <canvas id="coursePerformanceChart" height="300"></canvas>
                    </div>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg hover:bg-gray-650 transition-colors">
                                <div class="flex items-center">
                                    <?php if($course->image): ?>
                                        <img class="h-10 w-10 rounded-full object-cover mr-4" src="<?php echo e(asset('storage/' . $course->image)); ?>" alt="<?php echo e($course->title); ?>">
                                    <?php else: ?>
                                        <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center mr-4">
                                            <i class="fas fa-book text-gray-300"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h3 class="font-medium text-white"><?php echo e($course->title); ?></h3>
                                        <p class="text-sm text-gray-400">
                                            <?php echo e(isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['student_count'] : 0); ?> students
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-white">
                                        <?php echo e(isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['average_score'] : 0); ?>%
                                    </div>
                                    <a href="<?php echo e(route('teacher.course-analytics', $course->id)); ?>" class="text-sm text-primary-400 hover:text-primary-300 flex items-center justify-end">
                                        View Details <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-chart-bar text-primary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No course data available yet.</p>
                        <p class="text-sm text-gray-500 mt-2">Create courses and assign quizzes to see performance data.</p>
                        <a href="<?php echo e(route('teacher.courses.create')); ?>" class="mt-4 btn-primary">
                            <i class="fas fa-plus mr-2"></i> Create Course
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Student Progress -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-user-graduate mr-2"></i> Student Progress
            </div>
            <div class="section-content">
                <?php if(isset($studentProgress['students']) && count($studentProgress['students']) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Student</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Courses</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quizzes</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Avg. Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php $__currentLoopData = $studentProgress['students']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                                                    <span class="text-gray-300 font-bold"><?php echo e(substr($student['name'], 0, 1)); ?></span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-white"><?php echo e($student['name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-200"><?php echo e($student['courses_count']); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-200"><?php echo e($student['quizzes_completed']); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                <?php echo e($student['average_score'] >= 70 ? 'bg-primary-900 text-primary-300' : ($student['average_score'] >= 50 ? 'bg-secondary-900 text-secondary-300' : 'bg-red-900 text-red-300')); ?>">
                                                <?php echo e($student['average_score']); ?>%
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-user-graduate text-primary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No student progress data available yet.</p>
                        <p class="text-sm text-gray-500 mt-2">Data will appear once students start taking your quizzes.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Quiz Completion Rates -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-clipboard-list mr-2"></i> Quiz Completion Rates
            </div>
            <div class="section-content">
                <?php if(isset($coursePerformance) && count($coursePerformance) > 0): ?>
                    <div class="mb-6">
                        <canvas id="quizCompletionChart" height="250"></canvas>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-clipboard-list text-primary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No quiz completion data available yet.</p>
                        <p class="text-sm text-gray-500 mt-2">Create quizzes and assign them to students to see completion rates.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Performance by Category -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-tags mr-2"></i> Performance by Category
            </div>
            <div class="section-content">
                <?php if(isset($coursePerformance) && count($coursePerformance) > 0): ?>
                    <div class="mb-6">
                        <canvas id="categoryPerformanceChart" height="250"></canvas>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-secondary-900 mb-4">
                            <i class="fas fa-tags text-secondary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No category performance data available yet.</p>
                        <p class="text-sm text-gray-500 mt-2">Categorize your courses to see performance by category.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Analytics Tips -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-lightbulb mr-2"></i> Analytics Tips
            </div>
            <div class="section-content">
                <div class="space-y-4">
                    <div class="tip-card">
                        <div class="tip-icon bg-primary-900">
                            <i class="fas fa-chart-line text-primary-400"></i>
                        </div>
                        <p class="tip-text">Monitor student performance regularly to identify areas where they may need additional support.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon bg-primary-900">
                            <i class="fas fa-users text-primary-400"></i>
                        </div>
                        <p class="tip-text">Compare performance across different courses to identify which teaching methods are most effective.</p>
                    </div>
                    <div class="tip-card">
                        <div class="tip-icon bg-secondary-900">
                            <i class="fas fa-clipboard-check text-secondary-400"></i>
                        </div>
                        <p class="tip-text">Use quiz completion rates to gauge student engagement with your course materials.</p>
                    </div>
                </div>
            </div>
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
        const courseLabels = <?php echo json_encode(array_map(function($course) { return $course->title; }, $courses->toArray()), 512) ?>;
        const courseScores = <?php echo json_encode(array_map(function($course) use ($coursePerformance) {
            return isset($coursePerformance[$course->id]) ? $coursePerformance[$course->id]['average_score'] : 0;
        }, $courses->toArray()), 512) ?>;

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
                        backgroundColor: 'rgba(56, 189, 248, 0.5)', // primary-400 with opacity
                        borderColor: 'rgb(56, 189, 248)', // primary-400
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: '#1e293b' // darker grid lines
                            }
                        },
                        x: {
                            grid: {
                                color: '#1e293b' // darker grid lines
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
                            'rgba(56, 189, 248, 0.7)', // primary-400
                            'rgba(168, 85, 247, 0.7)', // secondary-400
                            'rgba(239, 68, 68, 0.7)' // red-500
                        ],
                        borderColor: [
                            'rgb(56, 189, 248)', // primary-400
                            'rgb(168, 85, 247)', // secondary-400
                            'rgb(239, 68, 68)' // red-500
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e2e8f0' // text color
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
                            'rgba(56, 189, 248, 0.5)', // primary-400
                            'rgba(168, 85, 247, 0.5)', // secondary-400
                            'rgba(251, 146, 60, 0.5)', // orange-400
                            'rgba(52, 211, 153, 0.5)' // emerald-400
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#e2e8f0' // text color
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/analytics.blade.php ENDPATH**/ ?>