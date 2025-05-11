<?php $__env->startSection('title', 'Create Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
            <span class="bg-primary-100 dark:bg-primary-900 p-2 rounded-full mr-3">
                <i class="fas fa-plus-circle text-primary-600 dark:text-primary-400"></i>
            </span>
            Create New Quiz
        </h1>
        <a href="<?php echo e(route('teacher.quizzes')); ?>" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium py-2 px-4 rounded-lg inline-flex items-center transition duration-300 shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-question-circle mr-2"></i> Quiz Details
            </h2>
        </div>
        <div class="p-8">
            <form action="<?php echo e(route('teacher.quizzes.store')); ?>" method="POST" class="space-y-8">
                <?php echo csrf_field(); ?>

                <!-- Quiz Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                        <i class="fas fa-info-circle mr-2 text-primary-600"></i>Basic Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quiz Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter quiz name" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200" required>
                        </div>

                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Course</label>
                            <select name="course_id" id="course_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200" required>
                                <option value="">Select a course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Quiz Settings -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                        <i class="fas fa-cog mr-2 text-primary-600"></i>Quiz Settings
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800">
                            <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-clock text-primary-600 mr-2"></i>Duration (minutes)
                            </label>
                            <input type="number" name="duration" id="duration" min="1" max="180" value="30" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200" required>
                        </div>

                        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800">
                            <label for="passing_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-percentage text-primary-600 mr-2"></i>Passing Score (%)
                            </label>
                            <input type="number" name="passing_score" id="passing_score" min="1" max="100" value="70" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200" required>
                        </div>

                        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800">
                            <label for="attempts_allowed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-redo text-primary-600 mr-2"></i>Attempts Allowed
                            </label>
                            <input type="number" name="attempts_allowed" id="attempts_allowed" min="1" max="10" value="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-align-left text-primary-600 mr-2"></i>Description
                        </label>
                        <textarea name="description" id="description" rows="4" placeholder="Enter quiz description" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200"></textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Provide a brief description of what this quiz covers and its purpose.</p>
                    </div>
                </div>

                <!-- Quiz Options -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                        <i class="fas fa-sliders-h mr-2 text-primary-600"></i>Additional Options
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800 flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 rounded transition duration-200">
                            <label for="is_published" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                <span class="font-medium">Publish immediately</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">If checked, the quiz will be available to students right away.</p>
                            </label>
                        </div>

                        <div class="bg-secondary-50 dark:bg-secondary-900/20 p-4 rounded-lg border border-secondary-100 dark:border-secondary-800 flex items-center">
                            <input type="checkbox" name="requires_face_verification" id="requires_face_verification" class="h-5 w-5 text-secondary-600 focus:ring-secondary-500 border-gray-300 rounded transition duration-200">
                            <label for="requires_face_verification" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                <span class="font-medium">Require face verification</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enable secure exam mode with facial recognition to prevent cheating.</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.location.href='<?php echo e(route('teacher.quizzes')); ?>'" class="bg-white dark:bg-gray-700 py-3 px-6 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                            Cancel
                        </button>
                        <button type="submit" class="ml-4 inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                            <i class="fas fa-save mr-2"></i> Create Quiz and Add Questions
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-lightbulb mr-2"></i> Tips for Creating Effective Quizzes
            </h2>
        </div>
        <div class="p-8">
            <ul class="space-y-4 text-gray-700 dark:text-gray-300">
                <li class="flex items-start bg-primary-50 dark:bg-primary-900/20 p-3 rounded-lg">
                    <div class="bg-primary-100 dark:bg-primary-800 p-2 rounded-full mr-3">
                        <i class="fas fa-check-circle text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span>Keep questions clear and concise to avoid confusion.</span>
                </li>
                <li class="flex items-start bg-primary-50 dark:bg-primary-900/20 p-3 rounded-lg">
                    <div class="bg-primary-100 dark:bg-primary-800 p-2 rounded-full mr-3">
                        <i class="fas fa-check-circle text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span>Include a mix of question types (multiple choice, true/false, etc.).</span>
                </li>
                <li class="flex items-start bg-primary-50 dark:bg-primary-900/20 p-3 rounded-lg">
                    <div class="bg-primary-100 dark:bg-primary-800 p-2 rounded-full mr-3">
                        <i class="fas fa-check-circle text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <span>Ensure questions align with your course learning objectives.</span>
                </li>
                <li class="flex items-start bg-secondary-50 dark:bg-secondary-900/20 p-3 rounded-lg">
                    <div class="bg-secondary-100 dark:bg-secondary-800 p-2 rounded-full mr-3">
                        <i class="fas fa-check-circle text-secondary-600 dark:text-secondary-400"></i>
                    </div>
                    <span>Consider using the AI quiz generation feature for time-saving and variety.</span>
                </li>
                <li class="flex items-start bg-secondary-50 dark:bg-secondary-900/20 p-3 rounded-lg">
                    <div class="bg-secondary-100 dark:bg-secondary-800 p-2 rounded-full mr-3">
                        <i class="fas fa-check-circle text-secondary-600 dark:text-secondary-400"></i>
                    </div>
                    <span>For high-stakes assessments, enable face verification to ensure academic integrity.</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/createQuiz.blade.php ENDPATH**/ ?>