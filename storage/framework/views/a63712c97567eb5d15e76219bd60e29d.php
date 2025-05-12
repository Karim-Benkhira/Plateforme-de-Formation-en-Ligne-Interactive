<?php $__env->startSection('title', $course->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('teacher.courses')); ?>" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white"><?php echo e($course->title); ?></h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Course Information -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    <?php if($course->image): ?>
                        <img src="<?php echo e(asset('storage/' . $course->image)); ?>" alt="<?php echo e($course->title); ?>" class="w-full h-64 object-cover">
                    <?php else: ?>
                        <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-book text-gray-400 dark:text-gray-500 text-5xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="absolute top-4 right-4 flex space-x-2">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($course->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                            <?php echo e($course->is_published ? 'Published' : 'Draft'); ?>

                        </span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            <?php echo e(ucfirst($course->level ?? 'Beginner')); ?>

                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Category: <?php echo e($course->category ? $course->category->name : 'Uncategorized'); ?></span>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Created: <?php echo e($course->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('teacher.courses.edit', $course->id)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm">
                                <i class="fas fa-edit mr-2"></i> Edit Course
                            </a>
                            <a href="<?php echo e(route('teacher.generate-quiz', $course->id)); ?>" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm">
                                <i class="fas fa-magic mr-2"></i> Generate Quiz
                            </a>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Description</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-6"><?php echo e($course->description); ?></p>

                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Course Content</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        <?php if($course->contents && $course->contents->count() > 0): ?>
                            <?php $__currentLoopData = $course->contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($content->type == 'text'): ?>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                                                <i class="fas fa-file-alt text-blue-500"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Text Content</h3>
                                        </div>
                                        <div class="pl-13">
                                            <?php echo e($content->content); ?>

                                        </div>
                                    </div>
                                <?php elseif($content->type == 'pdf'): ?>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center mr-3">
                                                <i class="fas fa-file-pdf text-red-500"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">PDF Document</h3>
                                        </div>
                                        <div class="mt-3">
                                            <a href="<?php echo e(asset('storage/' . $content->file)); ?>" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                                                <i class="fas fa-file-pdf mr-2"></i> View PDF Document
                                            </a>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Click the button above to open the PDF document in a new tab.</p>
                                        </div>
                                    </div>
                                <?php elseif($content->type == 'video'): ?>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-3">
                                                <i class="fas fa-video text-purple-500"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Video Content</h3>
                                        </div>
                                        <div class="mt-3">
                                            <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                                                <video controls class="w-full h-full object-contain">
                                                    <source src="<?php echo e(asset('storage/' . $content->file)); ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif($content->type == 'youtube'): ?>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                        <div class="flex items-center mb-3">
                                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center mr-3">
                                                <i class="fab fa-youtube text-red-500"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">YouTube Video</h3>
                                        </div>
                                        <div class="mt-3">
                                            <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                                                <iframe
                                                    src="<?php echo e(str_replace('watch?v=', 'embed/', $content->file)); ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen
                                                    class="w-full h-full">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl text-center">
                                <div class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-book-open text-blue-500 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">No content available for this course yet.</p>
                                <a href="<?php echo e(route('teacher.courses.edit', $course->id)); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i> Add Course Content
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Course Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Course Stats</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 dark:text-blue-400">Quizzes</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($quizzes->count()); ?></p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <p class="text-sm text-green-600 dark:text-green-400">Students</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($course->students_count ?? 0); ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="<?php echo e(route('teacher.course-analytics', $course->id)); ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i> View Detailed Analytics
                    </a>
                </div>
            </div>

            <!-- Course Quizzes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Quizzes</h2>
                    <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <?php if($quizzes->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-800 dark:text-white"><?php echo e($quiz->name); ?></h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($quiz->questions->count()); ?> questions</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($quiz->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e($quiz->is_published ? 'Published' : 'Draft'); ?>

                                    </span>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-list-ul mr-1"></i> Questions
                                    </a>
                                    <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" class="text-sm text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-6">
                        <p class="text-gray-500 dark:text-gray-400 mb-4">No quizzes created for this course yet.</p>
                        <div class="flex justify-center space-x-3">
                            <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                <i class="fas fa-plus mr-2"></i> Create Quiz
                            </a>
                            <a href="<?php echo e(route('teacher.generate-quiz', $course->id)); ?>" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 disabled:opacity-25 transition">
                                <i class="fas fa-magic mr-2"></i> AI Generate
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/courseDetails.blade.php ENDPATH**/ ?>