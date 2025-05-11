<?php $__env->startSection('title', 'My Quizzes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
            <span class="bg-primary-100 dark:bg-primary-900 p-2 rounded-full mr-3">
                <i class="fas fa-clipboard-list text-primary-600 dark:text-primary-400"></i>
            </span>
            My Quizzes
        </h1>
        <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition duration-300 shadow-sm">
            <i class="fas fa-plus mr-2"></i> Create Quiz
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-primary-100 border-l-4 border-primary-500 text-primary-700 p-4 mb-6 rounded-r-md shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-primary-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($quizzes->count() > 0): ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-primary-50 dark:bg-primary-900/20">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-primary-700 dark:text-primary-300 uppercase tracking-wider">Quiz Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-primary-700 dark:text-primary-300 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-primary-700 dark:text-primary-300 uppercase tracking-wider">Questions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-primary-700 dark:text-primary-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-primary-700 dark:text-primary-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($quiz->name); ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        <?php if($quiz->requires_face_verification): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800 dark:bg-secondary-800 dark:text-secondary-100">
                                                <i class="fas fa-user-shield mr-1"></i> Secure Exam
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white"><?php echo e($quiz->course->title); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 py-1 px-3 rounded-full inline-flex items-center">
                                        <i class="fas fa-question-circle mr-1"></i> <?php echo e($quiz->questions->count()); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($quiz->is_published): ?>
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-800 dark:text-primary-100">
                                            <i class="fas fa-check-circle mr-1"></i> Published
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-secondary-100 text-secondary-800 dark:bg-secondary-800 dark:text-secondary-100">
                                            <i class="fas fa-clock mr-1"></i> Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 flex items-center">
                                            <i class="fas fa-list-ul mr-1"></i> Questions
                                        </a>
                                        <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('teacher.quizzes.delete', $quiz->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-secondary-600 hover:text-secondary-900 dark:text-secondary-400 dark:hover:text-secondary-300 flex items-center">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <?php echo e($quizzes->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="bg-primary-100 dark:bg-primary-900/30 inline-block p-6 rounded-full mb-6">
                <i class="fas fa-clipboard-list text-6xl text-primary-600 dark:text-primary-400"></i>
            </div>
            <h3 class="text-2xl font-medium text-gray-700 dark:text-gray-300 mb-3">No Quizzes Yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">You haven't created any quizzes yet. Get started by creating your first quiz to assess your students' knowledge.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                    <i class="fas fa-plus mr-2"></i> Create Quiz
                </a>
                <a href="<?php echo e(route('teacher.courses')); ?>" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                    <i class="fas fa-book mr-2"></i> View My Courses
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-full">
                    <i class="fas fa-lightbulb text-primary-600 dark:text-primary-400 text-xl"></i>
                </div>
                <h3 class="ml-4 text-lg font-medium text-gray-800 dark:text-white">Quick Quiz Creation</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Create a quiz in minutes by selecting a course and using our AI-powered quiz generator.</p>
            <a href="<?php echo e(route('teacher.courses')); ?>" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center">
                Select a course <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-full">
                    <i class="fas fa-chart-line text-primary-600 dark:text-primary-400 text-xl"></i>
                </div>
                <h3 class="ml-4 text-lg font-medium text-gray-800 dark:text-white">Track Performance</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Monitor student performance and identify areas where they may need additional support.</p>
            <a href="<?php echo e(route('teacher.analytics')); ?>" class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center">
                View analytics <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
            <div class="flex items-center mb-4">
                <div class="bg-secondary-100 dark:bg-secondary-900/30 p-3 rounded-full">
                    <i class="fas fa-user-shield text-secondary-600 dark:text-secondary-400 text-xl"></i>
                </div>
                <h3 class="ml-4 text-lg font-medium text-gray-800 dark:text-white">Secure Exams</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Enable face verification to ensure academic integrity during high-stakes assessments.</p>
            <a href="<?php echo e(route('teacher.quizzes.create')); ?>" class="text-secondary-600 hover:text-secondary-800 dark:text-secondary-400 dark:hover:text-secondary-300 inline-flex items-center">
                Create secure quiz <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/quizzes.blade.php ENDPATH**/ ?>