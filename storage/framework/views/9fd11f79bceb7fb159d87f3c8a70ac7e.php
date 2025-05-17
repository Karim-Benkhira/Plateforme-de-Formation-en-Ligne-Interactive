<?php $__env->startSection('title', 'Generate AI Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-8">
        <a href="<?php echo e(route('teacher.courses.show', $course->id)); ?>" class="mr-4 text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Back to Course</span>
        </a>
    </div>

    <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl p-6 mb-8 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Generate AI Quiz</h1>
                <p class="text-blue-100">For course: <span class="font-semibold"><?php echo e($course->title); ?></span></p>
            </div>
            <div class="hidden md:block">
                <img src="<?php echo e(asset('images/ai-quiz.svg')); ?>" alt="AI Quiz" class="h-24 w-auto" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2021/2021396.png'; this.onerror=null;">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <?php if($errors->any()): ?>
                        <div class="bg-red-900/30 border-l-4 border-red-500 text-red-300 p-4 mb-6" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="font-bold">There was an error with your submission</p>
                                    <ul class="mt-1 list-disc list-inside text-sm">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->has('ai_error')): ?>
                        <div class="bg-yellow-900/30 border-l-4 border-yellow-500 text-yellow-300 p-4 mb-6" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="font-bold">AI Service Notice</p>
                                    <p><?php echo e($errors->first('ai_error')); ?></p>
                                    <p class="mt-2 text-sm">Don't worry! The system will use a local fallback method to generate questions.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('teacher.generate-quiz.store', $course->id)); ?>" method="POST" class="space-y-6" id="quizForm">
                        <?php echo csrf_field(); ?>

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Quiz Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                </div>
                                <input type="text" name="name" id="name" value="<?php echo e(old('name', $course->title . ' Quiz')); ?>" class="pl-10 w-full rounded-md border-gray-700 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Give your quiz a descriptive name</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <label for="num_questions" class="block text-sm font-medium text-gray-300 mb-1">Number of Questions</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-list-ol text-gray-400"></i>
                                    </div>
                                    <select name="num_questions" id="num_questions" class="pl-10 w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                        <?php for($i = 5; $i <= 20; $i += 5): ?>
                                            <option value="<?php echo e($i); ?>" <?php echo e(old('num_questions') == $i ? 'selected' : ''); ?>><?php echo e($i); ?> questions</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-400">How many questions to generate</p>
                            </div>

                            <div class="bg-gray-700 p-4 rounded-lg">
                                <label for="difficulty" class="block text-sm font-medium text-gray-300 mb-1">Difficulty Level</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-signal text-gray-400"></i>
                                    </div>
                                    <select name="difficulty" id="difficulty" class="pl-10 w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                        <option value="easy" <?php echo e(old('difficulty') == 'easy' ? 'selected' : ''); ?>>Easy</option>
                                        <option value="medium" <?php echo e((old('difficulty') == 'medium' || old('difficulty') == null) ? 'selected' : ''); ?>>Medium</option>
                                        <option value="hard" <?php echo e(old('difficulty') == 'hard' ? 'selected' : ''); ?>>Hard</option>
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-400">Select the difficulty level</p>
                            </div>

                            <div class="bg-gray-700 p-4 rounded-lg">
                                <label for="question_type" class="block text-sm font-medium text-gray-300 mb-1">Question Type</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-question-circle text-gray-400"></i>
                                    </div>
                                    <select name="question_type" id="question_type" class="pl-10 w-full rounded-md border-gray-600 bg-gray-700 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                        <option value="multiple_choice" <?php echo e((old('question_type') == 'multiple_choice' || old('question_type') == null) ? 'selected' : ''); ?>>Multiple Choice</option>
                                        <option value="true_false" <?php echo e(old('question_type') == 'true_false' ? 'selected' : ''); ?>>True/False</option>
                                        <option value="mixed" <?php echo e(old('question_type') == 'mixed' ? 'selected' : ''); ?>>Mixed</option>
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-400">Type of questions to generate</p>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <a href="<?php echo e(route('teacher.courses.show', $course->id)); ?>" class="inline-flex justify-center py-2 px-4 border border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                            <button type="submit" id="generateBtn" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                                <i class="fas fa-magic mr-2"></i> Generate Quiz
                            </button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('quizForm').addEventListener('submit', function(e) {
                            // Show loading state
                            const generateBtn = document.getElementById('generateBtn');
                            generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating...';
                            generateBtn.disabled = true;
                        });
                    </script>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i> How It Works
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4 text-gray-300">
                        <p class="text-lg">Our AI Quiz Generator analyzes your course content and creates relevant questions based on the key concepts and learning objectives.</p>

                        <div class="grid grid-cols-1 gap-6 mt-8">
                            <div class="bg-gray-700 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center justify-center w-12 h-12 bg-blue-800 rounded-full mb-4 mx-auto">
                                    <span class="text-blue-300 text-xl font-bold">1</span>
                                </div>
                                <h3 class="font-bold text-lg mb-3 text-blue-300 text-center">Configure</h3>
                                <p class="text-center">Choose the number of questions, difficulty level, and question type that best suits your assessment needs.</p>
                                <div class="mt-4 flex justify-center">
                                    <i class="fas fa-sliders-h text-blue-400 text-2xl"></i>
                                </div>
                            </div>

                            <div class="bg-gray-700 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center justify-center w-12 h-12 bg-blue-800 rounded-full mb-4 mx-auto">
                                    <span class="text-blue-300 text-xl font-bold">2</span>
                                </div>
                                <h3 class="font-bold text-lg mb-3 text-blue-300 text-center">Generate</h3>
                                <p class="text-center">Our AI analyzes your course content and creates relevant questions based on the key concepts.</p>
                                <div class="mt-4 flex justify-center">
                                    <i class="fas fa-robot text-blue-400 text-2xl"></i>
                                </div>
                            </div>

                            <div class="bg-gray-700 p-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center justify-center w-12 h-12 bg-blue-800 rounded-full mb-4 mx-auto">
                                    <span class="text-blue-300 text-xl font-bold">3</span>
                                </div>
                                <h3 class="font-bold text-lg mb-3 text-blue-300 text-center">Review & Save</h3>
                                <p class="text-center">Preview the generated questions, make any necessary adjustments, and save the quiz to your course.</p>
                                <div class="mt-4 flex justify-center">
                                    <i class="fas fa-check-circle text-blue-400 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-blue-900/20 rounded-lg text-center">
                            <p class="text-blue-400 font-medium">Ready to create your first AI-generated quiz?</p>
                            <p class="text-gray-400 text-sm mt-1">Fill out the form and click "Generate Quiz" to get started!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/generateAIQuiz-updated.blade.php ENDPATH**/ ?>