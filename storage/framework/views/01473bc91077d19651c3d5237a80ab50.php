<?php $__env->startSection('title', 'Generate AI Quiz'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-robot mr-3 text-blue-300"></i>
                Generate AI Quiz
            </h1>
            <p class="text-blue-100 opacity-90">For course: <span class="font-semibold"><?php echo e($course->title); ?></span></p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.showCourse', $course->id)); ?>" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Course
            </a>
        </div>
    </div>
</div>

<!-- Course Information Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
    <div class="relative">
        <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
            <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                <i class="fas fa-info-circle"></i>
            </div>
            <span>Course Information</span>
        </h2>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Title:</div>
                    <div class="text-white"><?php echo e($course->title); ?></div>
                </div>
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Category:</div>
                    <div class="text-white"><?php echo e($course->category->name); ?></div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Created by:</div>
                    <div class="text-white"><?php echo e($course->creator->username); ?></div>
                </div>
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Score:</div>
                    <div class="text-white"><?php echo e($course->score); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quiz Generation Form -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-purple-800/5"></div>
    <div class="relative">
        <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
            <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                <i class="fas fa-magic"></i>
            </div>
            <span>Generate Quiz with AI</span>
        </h2>
        
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
        
        <div class="mb-6 bg-blue-900/30 border border-blue-700/50 text-blue-300 px-4 py-3 rounded-lg shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-blue-600/5"></div>
            <div class="relative flex items-start">
                <i class="fas fa-lightbulb text-blue-400 mr-3 text-xl mt-0.5"></i>
                <p>Our AI will analyze the course content and generate relevant quiz questions. You can preview the questions before saving them.</p>
            </div>
        </div>
        
        <form action="<?php echo e(route('admin.previewAIQuiz', $course->id)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-gray-300 font-medium mb-2">Quiz Name <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-file-alt text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                        </div>
                        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200" placeholder="Enter quiz name" />
                    </div>
                </div>
                
                <div>
                    <label for="num_questions" class="block text-gray-300 font-medium mb-2">Number of Questions <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-list-ol text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                        </div>
                        <select name="num_questions" id="num_questions" required
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                            <?php for($i = 5; $i <= 20; $i += 5): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('num_questions') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-300 font-medium mb-2">Difficulty Level <span class="text-red-500">*</span></label>
                    <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700/50 space-y-2">
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="difficulty" value="easy" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700" <?php echo e(old('difficulty') == 'easy' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-gray-300">Easy</span>
                        </label>
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="difficulty" value="medium" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700" <?php echo e(old('difficulty', 'medium') == 'medium' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-gray-300">Medium</span>
                        </label>
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="difficulty" value="hard" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700" <?php echo e(old('difficulty') == 'hard' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-gray-300">Hard</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gray-300 font-medium mb-2">Question Type <span class="text-red-500">*</span></label>
                    <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700/50 space-y-2">
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="question_type" value="multiple_choice" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-700 bg-gray-700" <?php echo e(old('question_type', 'multiple_choice') == 'multiple_choice' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-gray-300">Multiple Choice</span>
                        </label>
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="question_type" value="true_false" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-700 bg-gray-700" <?php echo e(old('question_type') == 'true_false' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-gray-300">True/False</span>
                        </label>
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="question_type" value="short_answer" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-700 bg-gray-700" <?php echo e(old('question_type') == 'short_answer' ? 'checked' : ''); ?>>
                            <span class="ml-2 text-gray-300">Short Answer</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform duration-200"></i> Preview Quiz
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/generateAIQuiz-new.blade.php ENDPATH**/ ?>