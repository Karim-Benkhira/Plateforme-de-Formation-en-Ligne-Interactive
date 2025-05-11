<?php $__env->startSection('title', 'My Quizzes'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white">My Quizzes</h1>
            <p class="text-blue-100">Create and manage quizzes for your courses</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="btn-white">
                <i class="fas fa-plus mr-2"></i> Create Quiz
            </a>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-primary-900/20 border-l-4 border-primary-500 text-primary-300 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-primary-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if($quizzes->count() > 0): ?>
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-clipboard-list mr-2"></i> Your Quizzes
        </div>
        <div class="section-content">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quiz Name</th>
                            <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Questions</th>
                            <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white"><?php echo e($quiz->name); ?></div>
                                    <div class="text-sm text-gray-400 mt-1">
                                        <?php if($quiz->requires_face_verification): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-900 text-secondary-300">
                                                <i class="fas fa-user-shield mr-1"></i> Secure Exam
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-200"><?php echo e($quiz->course->title); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm bg-primary-900/20 text-primary-300 py-1 px-3 rounded-full inline-flex items-center">
                                        <i class="fas fa-question-circle mr-1"></i> <?php echo e($quiz->questions->count()); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($quiz->is_published): ?>
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-primary-900 text-primary-300">
                                            <i class="fas fa-check-circle mr-1"></i> Published
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-secondary-900 text-secondary-300">
                                            <i class="fas fa-clock mr-1"></i> Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="action-icon primary" title="View Questions">
                                            <i class="fas fa-list-ul"></i>
                                        </a>
                                        <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" class="action-icon primary" title="Edit Quiz">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('teacher.quizzes.delete', $quiz->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="action-icon secondary" title="Delete Quiz">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-700 mt-4">
                <?php echo e($quizzes->links()); ?>

            </div>
        </div>
    </div>
<?php else: ?>
    <div class="section-card">
        <div class="section-content p-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-900 mb-6">
                <i class="fas fa-clipboard-list text-5xl text-primary-400"></i>
            </div>
            <h3 class="text-2xl font-medium text-gray-300 mb-3">No Quizzes Yet</h3>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">You haven't created any quizzes yet. Get started by creating your first quiz to assess your students' knowledge.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i> Create Quiz
                </a>
                <a href="<?php echo e(route('teacher.courses')); ?>" class="btn-secondary">
                    <i class="fas fa-book mr-2"></i> View My Courses
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Quick Actions -->
<div class="section-card mt-8">
    <div class="section-header">
        <i class="fas fa-bolt mr-2"></i> Quick Actions
    </div>
    <div class="section-content">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?php echo e(route('teacher.courses')); ?>" class="action-card">
                <div class="action-icon primary">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div>
                    <h3 class="action-title">AI Quiz Generation</h3>
                    <p class="action-description">Create quizzes automatically from your course content</p>
                </div>
            </a>
            <a href="<?php echo e(route('teacher.analytics')); ?>" class="action-card">
                <div class="action-icon primary">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="action-title">Track Performance</h3>
                    <p class="action-description">Monitor student progress and results</p>
                </div>
            </a>
            <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="action-card">
                <div class="action-icon secondary">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h3 class="action-title">Secure Exams</h3>
                    <p class="action-description">Create exams with face verification</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Tips Section -->
<div class="section-card mt-8">
    <div class="section-header">
        <i class="fas fa-lightbulb mr-2"></i> Quiz Tips
    </div>
    <div class="section-content">
        <div class="space-y-4">
            <div class="tip-card">
                <div class="tip-icon bg-primary-900">
                    <i class="fas fa-robot text-primary-400"></i>
                </div>
                <p class="tip-text">Use AI to generate quizzes from your course content to save time.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon bg-primary-900">
                    <i class="fas fa-question-circle text-primary-400"></i>
                </div>
                <p class="tip-text">Include a mix of question types to test different levels of understanding.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon bg-secondary-900">
                    <i class="fas fa-user-shield text-secondary-400"></i>
                </div>
                <p class="tip-text">Enable face verification for high-stakes assessments to ensure academic integrity.</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/quizzes.blade.php ENDPATH**/ ?>