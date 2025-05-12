<?php $__env->startSection('title', 'Edit Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Quiz</h1>
        <a href="<?php echo e(route('teacher.quizzes')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-question-circle mr-2"></i> Quiz Details
            </h2>
        </div>
        <div class="p-6">
            <form action="<?php echo e(route('teacher.quizzes.update', $quiz->id)); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <!-- Quiz Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quiz Name</label>
                        <input type="text" name="name" id="name" value="<?php echo e($quiz->name); ?>" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Course</label>
                        <select name="course_id" id="course_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="">Select a course</option>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course->id); ?>" <?php echo e($quiz->course_id == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duration (minutes)</label>
                        <input type="number" name="duration" id="duration" min="1" max="180" value="<?php echo e($quiz->duration ?? 30); ?>" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label for="passing_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Passing Score (%)</label>
                        <input type="number" name="passing_score" id="passing_score" min="1" max="100" value="<?php echo e($quiz->passing_score ?? 70); ?>" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                    
                    <div>
                        <label for="attempts_allowed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Attempts Allowed</label>
                        <input type="number" name="attempts_allowed" id="attempts_allowed" min="1" max="10" value="<?php echo e($quiz->attempts_allowed ?? 1); ?>" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"><?php echo e($quiz->description); ?></textarea>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" <?php echo e($quiz->is_published ? 'checked' : ''); ?>>
                    <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Publish quiz</label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="requires_face_verification" id="requires_face_verification" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" <?php echo e($quiz->requires_face_verification ? 'checked' : ''); ?>>
                    <label for="requires_face_verification" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Require face verification (secure exam)</label>
                </div>
                
                <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.location.href='<?php echo e(route('teacher.quizzes')); ?>'" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-list-ol mr-2"></i> Quiz Questions
            </h2>
            <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-edit mr-2"></i> Manage Questions
            </a>
        </div>
        <div class="p-6">
            <?php if($quiz->questions->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex justify-between">
                                <h3 class="font-bold text-gray-800 dark:text-white">Question <?php echo e($index + 1); ?></h3>
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(ucfirst($question->type ?? 'multiple_choice')); ?></span>
                            </div>
                            <p class="mt-2 text-gray-700 dark:text-gray-300"><?php echo e($question->question); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="text-gray-400 dark:text-gray-500 mb-4">
                        <i class="fas fa-question-circle text-5xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No Questions Yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">This quiz doesn't have any questions yet.</p>
                    <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i> Add Questions
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-trash-alt mr-2"></i> Danger Zone
            </h2>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete this quiz</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Once you delete a quiz, there is no going back. Please be certain.</p>
                </div>
                <form action="<?php echo e(route('teacher.quizzes.delete', $quiz->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz? This action cannot be undone.');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Quiz
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/editQuiz.blade.php ENDPATH**/ ?>