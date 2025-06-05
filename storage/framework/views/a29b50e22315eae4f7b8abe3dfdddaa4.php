<?php $__env->startSection('title', 'My Quizzes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">My Quizzes</h1>
                <p class="text-blue-100">Create and manage your course quizzes</p>
                <div class="flex items-center mt-2 space-x-4">
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-quiz mr-1"></i>
                        <?php echo e($quizzes->count()); ?> Total Quizzes
                    </span>
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-eye mr-1"></i>
                        <?php echo e($quizzes->where('is_published', true)->count()); ?> Published
                    </span>
                </div>
            </div>
            <a href="<?php echo e(route('teacher.simple-quiz.create')); ?>" 
               class="bg-white hover:bg-gray-100 text-blue-600 font-medium py-3 px-6 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Create New Quiz
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($quizzes->count() > 0): ?>
        <!-- Quizzes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Quiz Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2"><?php echo e($quiz->name); ?></h3>
                            <div class="flex items-center space-x-2">
                                <?php if($quiz->is_published): ?>
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-eye mr-1"></i>Published
                                    </span>
                                <?php else: ?>
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-1 rounded-full">
                                        <i class="fas fa-eye-slash mr-1"></i>Draft
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-3"><?php echo e($quiz->course->title); ?></p>
                        
                        <?php if($quiz->description): ?>
                            <p class="text-sm text-gray-500 line-clamp-2"><?php echo e($quiz->description); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Quiz Stats -->
                    <div class="px-6 py-4 bg-gray-50">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-lg font-semibold text-blue-600"><?php echo e($quiz->quizQuestions->count()); ?></div>
                                <div class="text-xs text-gray-500">Questions</div>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-purple-600"><?php echo e($quiz->duration); ?></div>
                                <div class="text-xs text-gray-500">Minutes</div>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-green-600"><?php echo e($quiz->passing_score); ?>%</div>
                                <div class="text-xs text-gray-500">Pass Score</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Actions -->
                    <div class="p-6 bg-white">
                        <div class="flex items-center justify-between space-x-2">
                            <a href="<?php echo e(route('teacher.simple-quiz.questions', $quiz->id)); ?>" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-3 rounded-lg transition-colors text-center">
                                <i class="fas fa-list mr-1"></i> Manage Questions
                            </a>
                            
                            <form action="<?php echo e(route('teacher.simple-quiz.toggle-publish', $quiz->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" 
                                        class="px-3 py-2 rounded-lg text-sm font-medium transition-colors <?php echo e($quiz->is_published ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200'); ?>">
                                    <?php if($quiz->is_published): ?>
                                        <i class="fas fa-eye-slash"></i>
                                    <?php else: ?>
                                        <i class="fas fa-eye"></i>
                                    <?php endif; ?>
                                </button>
                            </form>
                            
                            <form action="<?php echo e(route('teacher.simple-quiz.destroy', $quiz->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="px-3 py-2 bg-red-100 text-red-800 hover:bg-red-200 rounded-lg text-sm font-medium transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this quiz?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-quiz text-4xl text-blue-500"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Quizzes Yet</h3>
            <p class="text-gray-600 mb-6">Create your first quiz to start testing your students' knowledge.</p>
            <a href="<?php echo e(route('teacher.simple-quiz.create')); ?>" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Create Your First Quiz
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/simple-quiz/index.blade.php ENDPATH**/ ?>