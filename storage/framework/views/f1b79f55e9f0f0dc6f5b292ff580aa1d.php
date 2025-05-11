

<?php $__env->startSection('title', 'Create New Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Create New Quiz</h1>
            <p class="text-blue-100">Create a quiz to assess student knowledge.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.quizzes')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
            </a>
        </div>
    </div>
</div>

<div class="data-card p-6 max-w-4xl">
    <form action="<?php echo e(route('admin.storeQuiz')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-gray-300 font-medium mb-2">Quiz Name <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-question-circle text-gray-500"></i>
                    </div>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Enter quiz name" />
                </div>
            </div>

            <div>
                <label for="course_id" class="block text-gray-300 font-medium mb-2">Course <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-book text-gray-500"></i>
                    </div>
                    <select name="course_id" id="course_id" required
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none">
                        <option value="">Select Course</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label for="description" class="block text-gray-300 font-medium mb-2">Quiz Description</label>
            <div class="relative">
                <textarea name="description" id="description" rows="3"
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="Enter quiz description (optional)"><?php echo e(old('description')); ?></textarea>
            </div>
            <p class="text-sm text-gray-400 mt-1">Provide a brief description of what this quiz covers</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="duration" class="block text-gray-300 font-medium mb-2">Duration (minutes) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clock text-gray-500"></i>
                    </div>
                    <input type="number" name="duration" id="duration" value="<?php echo e(old('duration', 30)); ?>" required min="1" max="180"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                </div>
                <p class="text-sm text-gray-400 mt-1">Time allowed to complete the quiz</p>
            </div>

            <div>
                <label for="passing_score" class="block text-gray-300 font-medium mb-2">Passing Score (%) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-percent text-gray-500"></i>
                    </div>
                    <input type="number" name="passing_score" id="passing_score" value="<?php echo e(old('passing_score', 70)); ?>" required min="1" max="100"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                </div>
                <p class="text-sm text-gray-400 mt-1">Minimum score required to pass</p>
            </div>

            <div>
                <label for="attempts_allowed" class="block text-gray-300 font-medium mb-2">Attempts Allowed <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-redo text-gray-500"></i>
                    </div>
                    <input type="number" name="attempts_allowed" id="attempts_allowed" value="<?php echo e(old('attempts_allowed', 1)); ?>" required min="1" max="10"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                </div>
                <p class="text-sm text-gray-400 mt-1">Number of attempts students can make</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-700">
            <div class="flex items-center">
                <input type="checkbox" name="is_published" id="is_published" class="w-5 h-5 bg-gray-700 border-gray-600 rounded text-purple-600 focus:ring-purple-500" <?php echo e(old('is_published') ? 'checked' : ''); ?>>
                <label for="is_published" class="ml-2 text-gray-300">Publish quiz immediately</label>
                <div class="ml-2 group relative">
                    <i class="fas fa-info-circle text-gray-500 cursor-help"></i>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-48 p-2 bg-gray-800 text-xs text-gray-300 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                        If unchecked, the quiz will be saved as a draft
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="requires_face_verification" id="requires_face_verification" class="w-5 h-5 bg-gray-700 border-gray-600 rounded text-purple-600 focus:ring-purple-500" <?php echo e(old('requires_face_verification') ? 'checked' : ''); ?>>
                <label for="requires_face_verification" class="ml-2 text-gray-300">Require face verification</label>
                <div class="ml-2 group relative">
                    <i class="fas fa-info-circle text-gray-500 cursor-help"></i>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-48 p-2 bg-gray-800 text-xs text-gray-300 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                        Students will need to verify their identity with facial recognition before taking the quiz
                    </div>
                </div>
            </div>
        </div>

        <?php if($errors->any()): ?>
            <div class="bg-red-900 border border-red-800 text-red-300 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="flex justify-end space-x-4 pt-4">
            <a href="<?php echo e(route('admin.quizzes')); ?>" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-200">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i> Create Quiz
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/createQuiz.blade.php ENDPATH**/ ?>