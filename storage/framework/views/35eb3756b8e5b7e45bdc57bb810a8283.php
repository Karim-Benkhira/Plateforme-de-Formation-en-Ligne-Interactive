<?php $__env->startSection('title', 'Test AI Practice Questions'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Test AI Practice Questions</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Test the AI practice questions system</p>
    </div>

    <!-- Test Buttons -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Test with Course ID 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Test Course 1</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Test AI practice questions for course ID 1</p>
            <a href="<?php echo e(route('student.practice.dashboard', 1)); ?>" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-robot mr-2"></i> Test Course 1
            </a>
        </div>

        <!-- Test with Course ID 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Test Course 2</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Test AI practice questions for course ID 2</p>
            <a href="<?php echo e(route('student.practice.dashboard', 2)); ?>" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-robot mr-2"></i> Test Course 2
            </a>
        </div>

        <!-- Test with Course ID 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Test Course 3</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Test AI practice questions for course ID 3</p>
            <a href="<?php echo e(route('student.practice.dashboard', 3)); ?>" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-robot mr-2"></i> Test Course 3
            </a>
        </div>

        <!-- Direct Generate Test -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Direct Generate</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Test direct question generation</p>
            <a href="<?php echo e(route('student.practice.generate.form', 1)); ?>" 
               class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Generate Questions
            </a>
        </div>
    </div>

    <!-- Current User Info -->
    <div class="mt-8 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Current User Info:</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            User: <?php echo e(Auth::user()->username); ?> (ID: <?php echo e(Auth::user()->id); ?>)
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Role: <?php echo e(Auth::user()->role); ?>

        </p>
    </div>

    <!-- Available Courses -->
    <div class="mt-8 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Available Courses:</h4>
        <?php
            $courses = \App\Models\Course::take(5)->get();
        ?>
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-600 last:border-b-0">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    <?php echo e($course->title); ?> (ID: <?php echo e($course->id); ?>)
                </span>
                <a href="<?php echo e(route('student.practice.dashboard', $course->id)); ?>" 
                   class="text-purple-600 hover:text-purple-700 text-sm">
                    Test Practice
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/test-practice.blade.php ENDPATH**/ ?>