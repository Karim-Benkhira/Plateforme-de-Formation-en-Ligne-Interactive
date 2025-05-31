<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($course->title); ?> - Course Preview</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            min-height: 100vh;
        }

        .course-header {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        }

        .section-card {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .lesson-item {
            background: rgba(51, 65, 85, 0.6);
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .lesson-item:hover {
            border-left-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .lesson-item.free {
            border-left-color: #10b981;
        }

        .lesson-item.locked {
            opacity: 0.6;
        }

        .progress-bar {
            background: linear-gradient(90deg, #10b981 0%, #3b82f6 100%);
        }
    </style>
</head>
<body class="text-white">
    <!-- Navigation -->
    <nav class="bg-gray-900/90 backdrop-blur-sm border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-blue-400">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Learning Platform
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->role === 'teacher' && $course->creator_id === auth()->id()): ?>
                            <a href="<?php echo e(route('teacher.course-builder.edit', $course->id)); ?>"
                               class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Course
                            </a>
                        <?php endif; ?>

                        <div class="text-gray-300">
                            Welcome, <?php echo e(auth()->user()->username); ?>

                        </div>

                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-gray-400 hover:text-white">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-blue-400 hover:text-blue-300">
                            Login
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Course Header -->
    <div class="course-header py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <!-- Course Info -->
                <div class="lg:col-span-2">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                            <i class="fas fa-tag mr-2"></i>
                            <?php echo e($course->category->name ?? 'General'); ?>

                        </span>

                        <?php if($course->is_published): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-300 ml-2">
                                <i class="fas fa-check-circle mr-2"></i>
                                Published
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-300 ml-2">
                                <i class="fas fa-clock mr-2"></i>
                                Draft
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="text-4xl font-bold mb-4"><?php echo e($course->title); ?></h1>
                    <p class="text-xl text-blue-100 mb-6"><?php echo e($course->description); ?></p>

                    <div class="flex flex-wrap items-center gap-6 text-blue-100">
                        <div class="flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            <span><?php echo e($course->creator->username ?? 'Unknown'); ?></span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-signal mr-2"></i>
                            <span><?php echo e(ucfirst($course->level)); ?></span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-list mr-2"></i>
                            <span><?php echo e($course->sections->count()); ?> Sections</span>
                        </div>

                        <div class="flex items-center">
                            <i class="fas fa-play-circle mr-2"></i>
                            <span><?php echo e($totalLessons); ?> Lessons</span>
                        </div>

                        <?php if($totalDuration > 0): ?>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span><?php echo e(gmdate('H:i:s', $totalDuration)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Course Image -->
                <div class="lg:col-span-1">
                    <div class="relative">
                        <img src="<?php echo e($course->thumbnail_url); ?>"
                             alt="<?php echo e($course->title); ?>"
                             class="w-full h-64 object-cover rounded-xl shadow-2xl">

                        <?php if($isEnrolled && $completionRate > 0): ?>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="bg-black/50 rounded-lg p-3">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium">Progress</span>
                                        <span class="text-sm font-bold"><?php echo e(round($completionRate)); ?>%</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="progress-bar h-2 rounded-full" style="width: <?php echo e($completionRate); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Course Content -->
            <div class="lg:col-span-2">
                <div class="section-card rounded-xl p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class="fas fa-list-ul mr-3 text-blue-400"></i>
                        Course Content
                    </h2>

                    <?php if($course->sections->count() > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-600 rounded-lg overflow-hidden">
                                    <div class="bg-gray-700/50 px-6 py-4 border-b border-gray-600">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-lg font-semibold"><?php echo e($section->title); ?></h3>
                                            <span class="text-sm text-gray-400">
                                                <?php echo e($section->lessons->count()); ?> lessons
                                            </span>
                                        </div>
                                        <?php if($section->description): ?>
                                            <p class="text-gray-300 mt-2"><?php echo e($section->description); ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if($section->lessons->count() > 0): ?>
                                        <div class="divide-y divide-gray-600">
                                            <?php $__currentLoopData = $section->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="lesson-item px-6 py-4 flex items-center justify-between <?php echo e($lesson->is_free ? 'free' : ($isEnrolled ? '' : 'locked')); ?>">
                                                    <div class="flex items-center">
                                                        <div class="mr-4">
                                                            <?php if($lesson->content_type === 'video'): ?>
                                                                <i class="fas fa-play-circle text-blue-400"></i>
                                                            <?php elseif($lesson->content_type === 'pdf'): ?>
                                                                <i class="fas fa-file-pdf text-red-400"></i>
                                                            <?php elseif($lesson->content_type === 'text'): ?>
                                                                <i class="fas fa-file-text text-green-400"></i>
                                                            <?php else: ?>
                                                                <i class="fas fa-file text-gray-400"></i>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div>
                                                            <h4 class="font-medium"><?php echo e($lesson->title); ?></h4>
                                                            <?php if($lesson->description): ?>
                                                                <p class="text-sm text-gray-400"><?php echo e(Str::limit($lesson->description, 60)); ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center space-x-3">
                                                        <?php if($lesson->duration > 0): ?>
                                                            <span class="text-sm text-gray-400">
                                                                <?php echo e(gmdate('i:s', $lesson->duration)); ?>

                                                            </span>
                                                        <?php endif; ?>

                                                        <?php if($lesson->is_free): ?>
                                                            <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded text-xs font-medium">
                                                                Free
                                                            </span>
                                                        <?php elseif(!$isEnrolled): ?>
                                                            <i class="fas fa-lock text-gray-500"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="px-6 py-4 text-center text-gray-400">
                                            <i class="fas fa-file-circle-plus text-2xl mb-2"></i>
                                            <p>No lessons in this section yet.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <i class="fas fa-folder-open text-4xl text-gray-500 mb-4"></i>
                            <p class="text-gray-400">No content available yet.</p>
                            <p class="text-sm text-gray-500 mt-2">This course doesn't have any published sections.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="section-card rounded-xl p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-6">Course Actions</h3>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if($isEnrolled): ?>
                            <div class="space-y-4">
                                <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                                    <div class="flex items-center text-green-300">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <span class="font-medium">You're enrolled!</span>
                                    </div>
                                </div>

                                <a href="<?php echo e(route('student.showCourse', $course->id)); ?>"
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                    <i class="fas fa-play mr-2"></i>
                                    Continue Learning
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <div class="text-center">
                                    <p class="text-gray-300 mb-4">Ready to start learning?</p>

                                    <form action="<?php echo e(route('student.enrollCourse', $course->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 px-4 rounded-lg transition-all transform hover:scale-105 flex items-center justify-center">
                                            <i class="fas fa-graduation-cap mr-2"></i>
                                            Enroll Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="space-y-4">
                            <p class="text-gray-300 text-center mb-4">Sign in to enroll in this course</p>

                            <a href="<?php echo e(route('login')); ?>"
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In
                            </a>

                            <a href="<?php echo e(route('register')); ?>"
                               class="w-full border border-blue-600 text-blue-400 hover:bg-blue-600 hover:text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Account
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Course Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-600">
                        <h4 class="font-semibold mb-4">Course Statistics</h4>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Sections:</span>
                                <span><?php echo e($course->sections->count()); ?></span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-400">Lessons:</span>
                                <span><?php echo e($totalLessons); ?></span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-400">Level:</span>
                                <span><?php echo e(ucfirst($course->level)); ?></span>
                            </div>

                            <?php if($totalDuration > 0): ?>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Duration:</span>
                                    <span><?php echo e(gmdate('H:i:s', $totalDuration)); ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-between">
                                <span class="text-gray-400">Created:</span>
                                <span><?php echo e($course->created_at->format('M d, Y')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-700 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">
                © <?php echo e(date('Y')); ?> Learning Platform. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH /var/www/resources/views/course/preview.blade.php ENDPATH**/ ?>