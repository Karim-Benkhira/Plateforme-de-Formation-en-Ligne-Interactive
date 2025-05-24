<?php $__env->startSection('title', 'Create New Quiz'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-brain mr-3 text-purple-300"></i>
                Create New Quiz
            </h1>
            <p class="text-blue-100 opacity-90">Create a quiz to assess student knowledge.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.quizzes')); ?>" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Quizzes
            </a>
        </div>
    </div>
</div>

<!-- Quiz Creation Form -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-blue-800/5"></div>
    <div class="relative">
        <form action="<?php echo e(route('admin.storeQuiz')); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <span>Basic Information</span>
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-300 font-medium mb-2">Quiz Name <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-question-circle text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                            </div>
                            <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                placeholder="Enter quiz name" />
                        </div>
                    </div>

                    <div>
                        <label for="course_id" class="block text-gray-300 font-medium mb-2">Course <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-book text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                            </div>
                            <select name="course_id" id="course_id" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 appearance-none">
                                <option value="">Select Course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-gray-300 font-medium mb-2">Quiz Description</label>
                    <div class="relative">
                        <textarea name="description" id="description" rows="4"
                            class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                            placeholder="Enter a description for this quiz"><?php echo e(old('description')); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Quiz Settings Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span>Quiz Settings</span>
                </h2>

                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label for="duration" class="block text-gray-300 font-medium mb-2">Duration (minutes) <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="duration" id="duration" value="<?php echo e(old('duration', 30)); ?>" min="1" max="180" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Time allowed to complete the quiz</p>
                    </div>

                    <div>
                        <label for="passing_score" class="block text-gray-300 font-medium mb-2">Passing Score (%) <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-percentage text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="passing_score" id="passing_score" value="<?php echo e(old('passing_score', 70)); ?>" min="1" max="100" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Minimum score to pass the quiz</p>
                    </div>

                    <div>
                        <label for="attempts_allowed" class="block text-gray-300 font-medium mb-2">Attempts Allowed <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-redo text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="attempts_allowed" id="attempts_allowed" value="<?php echo e(old('attempts_allowed', 3)); ?>" min="1" max="10" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Number of times a student can take this quiz</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-700 bg-gray-700 rounded" <?php echo e(old('is_published') ? 'checked' : ''); ?>>
                            <label for="is_published" class="ml-2 text-gray-300 font-medium">Publish quiz immediately</label>
                        </div>
                        <p class="text-sm text-gray-400 mt-1 ml-7">If unchecked, the quiz will be saved as a draft</p>
                    </div>

                    <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                        <div class="flex items-center">
                            <input type="checkbox" name="requires_face_verification" id="requires_face_verification" value="1" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-700 bg-gray-700 rounded" <?php echo e(old('requires_face_verification') ? 'checked' : ''); ?>>
                            <label for="requires_face_verification" class="ml-2 text-gray-300 font-medium">Require face verification</label>
                        </div>
                        <p class="text-sm text-gray-400 mt-1 ml-7">Students will need to verify their identity with facial recognition</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="mb-6 bg-red-900/40 border border-red-700/50 text-red-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-red-600/5"></div>
                    <div class="relative w-full">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mr-2 text-xl mt-0.5"></i>
                            <div>
                                <ul class="list-disc pl-5 space-y-1">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-700/50">
                <a href="<?php echo e(route('admin.quizzes')); ?>" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg transition duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i> Create Quiz
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/createQuiz-new.blade.php ENDPATH**/ ?>