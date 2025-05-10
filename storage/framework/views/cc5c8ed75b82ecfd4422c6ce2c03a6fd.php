<?php $__env->startSection('title', 'Teacher Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-8 text-white">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome, <?php echo e(Auth::user()->username); ?>!</h1>
                <p class="text-blue-100">Manage your courses, create interactive quizzes, and track student progress.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="<?php echo e(route('teacher.courses.create')); ?>" class="bg-white text-blue-700 hover:bg-blue-50 font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Create Course
                </a>
                <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
                    <i class="fas fa-question-circle mr-2"></i> Create Quiz
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-blue-500 transform hover:scale-105 transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                    <i class="fas fa-book text-blue-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Courses</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($coursesCount); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-green-500 transform hover:scale-105 transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                    <i class="fas fa-question-circle text-green-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Quizzes</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($quizzesCount); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-purple-500 transform hover:scale-105 transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                    <i class="fas fa-users text-purple-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Students</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($studentCount); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-yellow-500 transform hover:scale-105 transition duration-300">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 mr-4">
                    <i class="fas fa-graduation-cap text-yellow-500 text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Avg. Score</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">
                        <?php echo e(count($recentQuizResults) > 0 ? round($recentQuizResults->avg('score')) : 0); ?>%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Course Management -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-book-open mr-2"></i> Course Management
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="<?php echo e(route('teacher.courses')); ?>" class="flex items-center p-4 bg-blue-50 dark:bg-gray-700 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                                <i class="fas fa-list text-blue-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Manage Courses</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">View and edit your courses</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('teacher.courses.create')); ?>" class="flex items-center p-4 bg-blue-50 dark:bg-gray-700 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                                <i class="fas fa-plus text-blue-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Create New Course</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Add a new course to your catalog</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quiz & Assessment -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-question-circle mr-2"></i> Quiz & Assessment
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="<?php echo e(route('teacher.quizzes')); ?>" class="flex items-center p-4 bg-green-50 dark:bg-gray-700 rounded-lg hover:bg-green-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                <i class="fas fa-list-alt text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Manage Quizzes</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">View and edit your quizzes</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="flex items-center p-4 bg-green-50 dark:bg-gray-700 rounded-lg hover:bg-green-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                <i class="fas fa-plus text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Create Manual Quiz</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Create a quiz manually</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('teacher.courses')); ?>" class="flex items-center p-4 bg-green-50 dark:bg-gray-700 rounded-lg hover:bg-green-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                <i class="fas fa-robot text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">AI-Generated Quiz</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Create quiz using AI</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('face.exam.monitoring')); ?>" class="flex items-center p-4 bg-green-50 dark:bg-gray-700 rounded-lg hover:bg-green-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                                <i class="fas fa-video text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Secure Exam Monitoring</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Monitor exams with face recognition</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Analytics & Reporting -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-chart-line mr-2"></i> Analytics & Reporting
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="<?php echo e(route('teacher.analytics')); ?>" class="flex items-center p-4 bg-purple-50 dark:bg-gray-700 rounded-lg hover:bg-purple-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                                <i class="fas fa-chart-bar text-purple-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Performance Dashboard</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">View overall analytics</p>
                            </div>
                        </a>
                        <a href="<?php echo e(route('teacher.analytics')); ?>" class="flex items-center p-4 bg-purple-50 dark:bg-gray-700 rounded-lg hover:bg-purple-100 dark:hover:bg-gray-600 transition">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                                <i class="fas fa-user-graduate text-purple-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">Student Progress</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Track individual student performance</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Recent Quiz Results -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i> Recent Quiz Results
                    </h2>
                </div>
                <div class="p-6">
                    <?php if(count($recentQuizResults) > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $recentQuizResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-gray-700 dark:text-gray-300 font-bold"><?php echo e(substr($result->student_name, 0, 1)); ?></span>
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center">
                                            <h3 class="font-medium text-gray-800 dark:text-white"><?php echo e($result->student_name); ?></h3>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                <?php echo e($result->score >= 70 ? 'bg-green-100 text-green-800' : ($result->score >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                                                <?php echo e($result->score); ?>%
                                            </span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <p class="text-gray-600 dark:text-gray-400"><?php echo e($result->quiz_name); ?></p>
                                            <p class="text-gray-500 dark:text-gray-400"><?php echo e($result->created_at->diffForHumans()); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 dark:bg-yellow-900 mb-4">
                                <i class="fas fa-clipboard text-yellow-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">No recent quiz results available.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Results will appear here once students complete quizzes.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-400 to-blue-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i> Teaching Tips
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-robot text-blue-500"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">Use AI to generate quizzes from your course content to save time.</p>
                            </div>
                        </div>
                        <div class="flex p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-chart-pie text-blue-500"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">Check analytics regularly to identify struggling students early.</p>
                            </div>
                        </div>
                        <div class="flex p-3 bg-blue-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-video text-blue-500"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">Use secure exams with face recognition for high-stakes assessments.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Add any dashboard-specific JavaScript here
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/dashboard.blade.php ENDPATH**/ ?>