<?php $__env->startSection('title', 'AI Practice Questions'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">AI Practice Questions</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Practice with AI-generated questions from your enrolled courses</p>
            </div>
            <a href="<?php echo e(route('student.dashboard')); ?>" 
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    <?php
        $user = Auth::user();
        $enrolledCourses = $user->enrolledCourses()
            ->wherePivot('status', 'approved')
            ->with(['category', 'contents', 'sections.publishedLessons'])
            ->get();
        
        $coursesWithContent = $enrolledCourses->filter(function($course) {
            return $course->contents->count() > 0 || $course->sections->count() > 0;
        });
    ?>

    <?php if($coursesWithContent->count() > 0): ?>
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <p class="stats-label">Enrolled Courses</p>
                    <p class="stats-value"><?php echo e($enrolledCourses->count()); ?></p>
                </div>
            </div>
            <div class="stats-card">
                <div class="stats-icon secondary">
                    <i class="fas fa-brain"></i>
                </div>
                <div>
                    <p class="stats-label">Available for AI Practice</p>
                    <p class="stats-value"><?php echo e($coursesWithContent->count()); ?></p>
                </div>
            </div>
            <div class="stats-card">
                <div class="stats-icon success">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <p class="stats-label">Practice Sessions</p>
                    <p class="stats-value"><?php echo e($user->practiceQuestions()->count() ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Course Categories -->
        <?php
            $coursesByCategory = $coursesWithContent->groupBy('category.name');
        ?>

        <?php $__currentLoopData = $coursesByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $courses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="section-card mb-8">
                <div class="section-header">
                    <i class="fas fa-folder mr-2"></i> <?php echo e($categoryName ?? 'Uncategorized'); ?>

                    <span class="ml-2 text-sm text-gray-500">(<?php echo e($courses->count()); ?> courses)</span>
                </div>
                <div class="section-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="course-card">
                                <div class="course-card-header">
                                    <?php if($course->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $course->image)); ?>" 
                                             alt="<?php echo e($course->title); ?>" 
                                             class="course-image">
                                    <?php else: ?>
                                        <div class="course-image-placeholder">
                                            <i class="fas fa-book text-4xl text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="course-level-badge <?php echo e($course->level); ?>">
                                        <?php echo e(ucfirst($course->level ?? 'beginner')); ?>

                                    </div>
                                </div>
                                
                                <div class="course-card-content">
                                    <h3 class="course-title"><?php echo e($course->title); ?></h3>
                                    <p class="course-description"><?php echo e(Str::limit($course->description, 100)); ?></p>
                                    
                                    <!-- Course Content Info -->
                                    <div class="course-info">
                                        <?php
                                            $contentCount = $course->contents->count() + $course->sections->sum(function($section) {
                                                return $section->publishedLessons->count();
                                            });
                                        ?>
                                        <div class="info-item">
                                            <i class="fas fa-file-alt text-blue-500"></i>
                                            <span><?php echo e($contentCount); ?> content items</span>
                                        </div>
                                        <div class="info-item">
                                            <i class="fas fa-clock text-green-500"></i>
                                            <span><?php echo e($course->sections->sum('estimated_duration') ?? 'N/A'); ?> min</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="course-card-footer">
                                    <a href="<?php echo e(route('student.ai.quiz', $course->id)); ?>" 
                                       class="btn-primary w-full">
                                        <i class="fas fa-brain mr-2"></i>
                                        Generate AI Quiz
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Quick Actions -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-bolt mr-2"></i> Quick Actions
            </div>
            <div class="section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="<?php echo e(route('student.ai.quiz', $coursesWithContent->first()->id)); ?>?difficulty=easy" 
                       class="action-card bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700">
                        <div class="action-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Easy Practice</h3>
                            <p class="action-description">Start with basics</p>
                        </div>
                    </a>
                    
                    <a href="<?php echo e(route('student.ai.quiz', $coursesWithContent->first()->id)); ?>?difficulty=medium" 
                       class="action-card bg-gradient-to-r from-yellow-500 to-orange-500 text-white hover:from-yellow-600 hover:to-orange-600">
                        <div class="action-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Medium Practice</h3>
                            <p class="action-description">Test understanding</p>
                        </div>
                    </a>
                    
                    <a href="<?php echo e(route('student.ai.quiz', $coursesWithContent->first()->id)); ?>?difficulty=hard" 
                       class="action-card bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700">
                        <div class="action-icon">
                            <i class="fas fa-fire"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Hard Practice</h3>
                            <p class="action-description">Challenge yourself</p>
                        </div>
                    </a>
                    
                    <a href="<?php echo e(route('student.ai.quiz', $coursesWithContent->random()->id)); ?>?question_type=mixed" 
                       class="action-card bg-gradient-to-r from-purple-500 to-indigo-500 text-white hover:from-purple-600 hover:to-indigo-600">
                        <div class="action-icon">
                            <i class="fas fa-random"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Random Quiz</h3>
                            <p class="action-description">Surprise me!</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Empty State -->
        <div class="section-card">
            <div class="section-content">
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-purple-100 dark:bg-purple-900 mb-6">
                        <i class="fas fa-robot text-purple-600 dark:text-purple-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">No Courses Available for AI Practice</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        You need to be enrolled in courses with content to use AI practice questions. 
                        Enroll in courses and wait for teacher approval to get started.
                    </p>
                    <div class="space-y-4">
                        <a href="<?php echo e(route('student.courses')); ?>" 
                           class="btn-primary">
                            <i class="fas fa-search mr-2"></i>
                            Browse Available Courses
                        </a>
                        <div class="text-sm text-gray-500">
                            <p>Once enrolled and approved, you'll be able to:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Generate AI-powered practice questions</li>
                                <li>Test your knowledge with custom quizzes</li>
                                <li>Track your learning progress</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.course-card {
    @apply bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-200 hover:shadow-lg;
}

.course-card-header {
    @apply relative;
}

.course-image {
    @apply w-full h-48 object-cover;
}

.course-image-placeholder {
    @apply w-full h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center;
}

.course-level-badge {
    @apply absolute top-3 right-3 px-2 py-1 rounded-full text-xs font-medium;
}

.course-level-badge.beginner {
    @apply bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200;
}

.course-level-badge.intermediate {
    @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200;
}

.course-level-badge.advanced {
    @apply bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200;
}

.course-card-content {
    @apply p-6;
}

.course-title {
    @apply text-lg font-semibold text-gray-900 dark:text-white mb-2;
}

.course-description {
    @apply text-gray-600 dark:text-gray-400 text-sm mb-4;
}

.course-info {
    @apply space-y-2;
}

.info-item {
    @apply flex items-center text-sm text-gray-500 dark:text-gray-400;
}

.info-item i {
    @apply mr-2;
}

.course-card-footer {
    @apply p-6 pt-0;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/ai-practice.blade.php ENDPATH**/ ?>