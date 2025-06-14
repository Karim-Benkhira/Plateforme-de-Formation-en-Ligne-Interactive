<?php $__env->startSection('title', 'Student Dashboard'); ?>

<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Banner -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">Welcome, <?php echo e(Auth::user()->username); ?>!</h1>
            <p class="text-blue-100">Your learning journey starts here. Explore courses and track your progress.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('student.courses')); ?>" class="btn-white">
                <i class="fas fa-book"></i> Explore Courses
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <p class="stats-label">Enrolled Courses</p>
            <p class="stats-value">
                <?php if(method_exists(Auth::user(), 'enrolledCourses')): ?>
                    <?php echo e(Auth::user()->enrolledCourses()->count()); ?>

                <?php else: ?>
                    0
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <p class="stats-label">Completed Courses</p>
            <p class="stats-value">
                <?php if(method_exists(Auth::user(), 'completedCourses')): ?>
                    <?php echo e(Auth::user()->completedCourses()->count()); ?>

                <?php else: ?>
                    0
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon secondary">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <p class="stats-label">Quizzes Taken</p>
            <p class="stats-value">
                <?php if(method_exists(Auth::user(), 'quizResults')): ?>
                    <?php echo e(Auth::user()->quizResults()->count()); ?>

                <?php else: ?>
                    0
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon secondary">
            <i class="fas fa-trophy"></i>
        </div>
        <div>
            <p class="stats-label">Achievements</p>
            <p class="stats-value">
                <?php if(method_exists(Auth::user(), 'achievements')): ?>
                    <?php echo e(Auth::user()->achievements()->count()); ?>

                <?php else: ?>
                    0
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<!-- Main Dashboard Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Learning Resources -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-graduation-cap mr-2"></i> Learning Resources
            </div>
            <div class="section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="<?php echo e(route('student.myCourses')); ?>" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div>
                            <h3 class="action-title">My Courses</h3>
                            <p class="action-description">Access your enrolled courses</p>
                        </div>
                    </a>
                    <a href="<?php echo e(route('student.courses')); ?>" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-search"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Explore Courses</h3>
                            <p class="action-description">Discover new learning opportunities</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- AI Practice Questions -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-robot mr-2"></i> AI Practice Questions
            </div>
            <div class="section-content">
                <?php
                    $enrolledCourses = Auth::user()->enrolledCourses ?? collect();
                    $completedCourses = $enrolledCourses->filter(function($course) {
                        return Auth::user()->quizResults()->whereHas('quiz', function($query) use ($course) {
                            $query->where('course_id', $course->id);
                        })->exists();
                    });
                ?>

                <?php if($completedCourses->count() > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <?php $__currentLoopData = $completedCourses->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('student.ai.quiz', $course->id)); ?>" class="action-card bg-gradient-to-r from-purple-900 to-indigo-900 hover:from-purple-800 hover:to-indigo-800">
                                <div class="action-icon">
                                    <i class="fas fa-brain text-purple-300"></i>
                                </div>
                                <div>
                                    <h3 class="action-title"><?php echo e(Str::limit($course->title, 20)); ?></h3>
                                    <p class="action-description">Take AI Quiz</p>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <?php if($completedCourses->count() > 4): ?>
                        <div class="text-center">
                            <p class="text-gray-400 text-sm">And <?php echo e($completedCourses->count() - 4); ?> more courses available for practice</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-900 mb-4">
                            <i class="fas fa-robot text-purple-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">Complete a course quiz to unlock AI practice questions</p>
                        <p class="text-sm text-gray-500 mt-2">Finish your first quiz to start practicing with AI-generated questions</p>

                        <!-- Test Button -->
                        <div class="mt-4">
                            <a href="<?php echo e(route('student.test.practice')); ?>"
                               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                <i class="fas fa-flask mr-2"></i> Test AI Practice Questions
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Progress & Performance -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-chart-line mr-2"></i> Progress & Performance
            </div>
            <div class="section-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="<?php echo e(route('student.progress')); ?>" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Learning Progress</h3>
                            <p class="action-description">Track your course completion</p>
                        </div>
                    </a>
                    <a href="<?php echo e(route('student.achievements')); ?>" class="action-card">
                        <div class="action-icon secondary">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Achievements</h3>
                            <p class="action-description">View your earned badges</p>
                        </div>
                    </a>
                    <a href="<?php echo e(route('student.leaderboard')); ?>" class="action-card">
                        <div class="action-icon secondary">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Leaderboard</h3>
                            <p class="action-description">See how you rank among peers</p>
                        </div>
                    </a>
                    <?php if(Route::has('student.analytics')): ?>
                    <a href="<?php echo e(route('student.analytics')); ?>" class="action-card">
                        <div class="action-icon primary">
                            <i class="fas fa-analytics"></i>
                        </div>
                        <div>
                            <h3 class="action-title">Analytics</h3>
                            <p class="action-description">Detailed performance insights</p>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Recent Activity -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-history mr-2"></i> Recent Activity
            </div>
            <div class="section-content">
                <?php if(method_exists(Auth::user(), 'recentActivities')): ?>
                    <?php $__empty_1 = true; $__currentLoopData = Auth::user()->recentActivities()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center p-3 bg-gray-800 rounded-lg mb-3">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center">
                                    <i class="fas fa-<?php echo e(isset($activity->type) && $activity->type == 'quiz' ? 'question-circle' : (isset($activity->type) && $activity->type == 'course' ? 'book' : 'trophy')); ?> text-primary-300"></i>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="text-white"><?php echo e($activity->description); ?></div>
                                <div class="text-xs text-gray-400"><?php echo e($activity->created_at->diffForHumans()); ?></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                                <i class="fas fa-history text-primary-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-400">No recent activity</p>
                            <p class="text-sm text-gray-500 mt-2">Start learning to see your activity here</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-history text-primary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">Activity tracking coming soon</p>
                        <p class="text-sm text-gray-500 mt-2">We're working on this feature</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Leaderboard Preview -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-medal mr-2"></i> Top Performers
            </div>
            <div class="section-content">
                <?php
                    $students = \App\Models\User::where('role', 'user');
                    if (Schema::hasColumn('users', 'points')) {
                        $students = $students->orderByDesc('points');
                    }
                    $students = $students->take(5)->get();
                ?>

                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center p-3 <?php echo e($user->id == Auth::id() ? 'bg-primary-900/30' : 'bg-gray-800'); ?> rounded-lg mb-2">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full <?php echo e($index < 3 ? 'bg-yellow-900' : 'bg-gray-700'); ?> flex items-center justify-center mr-3">
                            <span class="<?php echo e($index < 3 ? 'text-yellow-400' : 'text-gray-400'); ?> font-bold"><?php echo e($index + 1); ?></span>
                        </div>
                        <div class="flex-1 flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center mr-2">
                                <span class="text-white font-bold"><?php echo e(substr($user->username, 0, 1)); ?></span>
                            </div>
                            <span class="text-white <?php echo e($user->id == Auth::id() ? 'font-bold' : ''); ?>"><?php echo e($user->username); ?></span>
                        </div>
                        <div class="text-right">
                            <span class="text-yellow-400 font-bold"><?php echo e($user->points ?? 0); ?></span>
                            <span class="text-gray-400 text-xs">pts</span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-900 mb-4">
                            <i class="fas fa-trophy text-yellow-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No leaderboard data yet</p>
                        <p class="text-sm text-gray-500 mt-2">Complete quizzes to earn points</p>
                    </div>
                <?php endif; ?>

                <div class="mt-4 text-center">
                    <a href="<?php echo e(route('student.leaderboard')); ?>" class="text-blue-400 hover:text-blue-300 inline-flex items-center">
                        View Full Leaderboard <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Add any dashboard-specific JavaScript here
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/dashboard-new.blade.php ENDPATH**/ ?>