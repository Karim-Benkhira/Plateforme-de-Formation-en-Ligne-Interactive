<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Generate AI Quiz for: <?php echo e($course->title); ?></h1>
            <a href="<?php echo e(route('admin.showCourse', $course->id)); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Course
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Course Information</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600"><span class="font-medium">Title:</span> <?php echo e($course->title); ?></p>
                        <p class="text-gray-600"><span class="font-medium">Category:</span> <?php echo e($course->category->name); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600"><span class="font-medium">Created by:</span> <?php echo e($course->creator->username); ?></p>
                        <p class="text-gray-600"><span class="font-medium">Score:</span> <?php echo e($course->score); ?></p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Generate Quiz with AI</h2>

                <?php if($errors->any()): ?>
                    <div class="bg-red-50 text-red-500 p-4 rounded-md mb-6">
                        <ul class="list-disc pl-5">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Our AI will analyze the course content and generate relevant quiz questions. You can preview the questions before saving them.
                            </p>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('admin.previewAIQuiz', $course->id)); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Quiz Name</label>
                            <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="num_questions" class="block text-sm font-medium text-gray-700 mb-1">Number of Questions</label>
                            <select name="num_questions" id="num_questions" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php for($i = 5; $i <= 20; $i += 5): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e(old('num_questions') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Difficulty Level</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="difficulty" value="easy" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" <?php echo e(old('difficulty') == 'easy' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-700">Easy</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="difficulty" value="medium" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" <?php echo e(old('difficulty', 'medium') == 'medium' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-700">Medium</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="difficulty" value="hard" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" <?php echo e(old('difficulty') == 'hard' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-700">Hard</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="question_type" value="multiple_choice" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" <?php echo e(old('question_type', 'multiple_choice') == 'multiple_choice' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-700">Multiple Choice</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="question_type" value="true_false" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" <?php echo e(old('question_type') == 'true_false' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-700">True/False</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="question_type" value="short_answer" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" <?php echo e(old('question_type') == 'short_answer' ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-gray-700">Short Answer</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Preview Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/generateAIQuiz.blade.php ENDPATH**/ ?>