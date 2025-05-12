<?php $__env->startSection('title', 'Edit Quiz'); ?>

<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <a href="<?php echo e(route('teacher.quizzes')); ?>" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center mb-2">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Back to Quizzes</span>
            </a>
            <h1 class="text-3xl font-bold text-white">Edit Quiz</h1>
            <p class="text-gray-400 mt-1">Update quiz details and manage questions</p>
        </div>
        <div class="hidden md:block">
            <img src="<?php echo e(asset('images/quiz-icon.svg')); ?>" alt="Quiz" class="h-24 w-auto" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4205/4205906.png'; this.onerror=null;">
        </div>
    </div>

    <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="section-header">
            <i class="fas fa-question-circle"></i> Quiz Details
        </div>
        <div class="p-6">
            <?php if($errors->any()): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Error</p>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('teacher.quizzes.update', $quiz->id)); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Quiz Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Quiz Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-file-alt text-gray-400"></i>
                            </div>
                            <input type="text" name="name" id="name" value="<?php echo e($quiz->name); ?>" class="pl-10 w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Give your quiz a descriptive name</p>
                    </div>

                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-300 mb-1">Select Course</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-book text-gray-400"></i>
                            </div>
                            <select name="course_id" id="course_id" class="pl-10 w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                                <option value="">Select a course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php echo e($quiz->course_id == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">The course this quiz belongs to</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <label for="duration" class="block text-sm font-medium text-gray-300 mb-1">Duration (minutes)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-gray-400"></i>
                            </div>
                            <input type="number" name="duration" id="duration" min="1" max="180" value="<?php echo e($quiz->duration ?? 30); ?>" class="pl-10 w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Time allowed to complete the quiz</p>
                    </div>

                    <div class="bg-gray-700 p-4 rounded-lg">
                        <label for="passing_score" class="block text-sm font-medium text-gray-300 mb-1">Passing Score (%)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-percent text-gray-400"></i>
                            </div>
                            <input type="number" name="passing_score" id="passing_score" min="1" max="100" value="<?php echo e($quiz->passing_score ?? 70); ?>" class="pl-10 w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Minimum score needed to pass</p>
                    </div>

                    <div class="bg-gray-700 p-4 rounded-lg">
                        <label for="attempts_allowed" class="block text-sm font-medium text-gray-300 mb-1">Attempts Allowed</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-redo text-gray-400"></i>
                            </div>
                            <input type="number" name="attempts_allowed" id="attempts_allowed" min="1" max="10" value="<?php echo e($quiz->attempts_allowed ?? 1); ?>" class="pl-10 w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Number of times students can take this quiz</p>
                    </div>
                </div>

                <div class="bg-gray-700 p-4 rounded-lg">
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full rounded-md border-gray-700 bg-gray-800 text-white shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50"><?php echo e($quiz->description); ?></textarea>
                    <p class="mt-1 text-xs text-gray-400">Provide instructions or information about this quiz</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" class="rounded border-gray-700 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" <?php echo e($quiz->is_published ? 'checked' : ''); ?>>
                            <label for="is_published" class="ml-2 block text-sm font-medium text-gray-300">Publish quiz</label>
                        </div>
                        <p class="mt-1 text-xs text-gray-400 ml-6">When published, students can access this quiz</p>
                    </div>

                    <div class="bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <input type="checkbox" name="requires_face_verification" id="requires_face_verification" class="rounded border-gray-700 text-purple-600 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" <?php echo e($quiz->requires_face_verification ? 'checked' : ''); ?>>
                            <label for="requires_face_verification" class="ml-2 block text-sm font-medium text-gray-300">Require face verification</label>
                        </div>
                        <p class="mt-1 text-xs text-gray-400 ml-6">Enable secure exam mode with facial recognition</p>
                    </div>
                </div>

                <div class="pt-5 border-t border-gray-700">
                    <div class="flex justify-end">
                        <button type="button" onclick="window.location.href='<?php echo e(route('teacher.quizzes')); ?>'" class="bg-gray-700 py-2 px-4 border border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-200 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cancel
                        </button>
                        <button type="submit" class="ml-3 btn-primary">
                            <i class="fas fa-save mr-2"></i> Update Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="section-header flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-list-ol"></i> Quiz Questions
            </div>
            <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="bg-gray-700 text-blue-400 hover:bg-gray-600 text-sm rounded-md px-3 py-1.5">
                <i class="fas fa-edit mr-2"></i> Manage Questions
            </a>
        </div>
        <div class="p-6">
            <?php if($quiz->questions->count() > 0): ?>
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="bg-blue-900 text-blue-200 text-sm font-medium px-3 py-1 rounded-full">
                            <?php echo e($quiz->questions->count()); ?> <?php echo e(Str::plural('question', $quiz->questions->count())); ?>

                        </span>

                        <div class="ml-4 text-sm text-gray-400">
                            <?php
                                $typeCount = [];
                                foreach ($quiz->questions as $q) {
                                    $type = $q->type ?? 'multiple_choice';
                                    $typeCount[$type] = ($typeCount[$type] ?? 0) + 1;
                                }
                            ?>

                            <?php $__currentLoopData = $typeCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="inline-flex items-center mr-3">
                                    <i class="fas <?php echo e($type == 'multiple_choice' ? 'fa-list' : ($type == 'true_false' ? 'fa-toggle-on' : 'fa-pen')); ?> mr-1"></i>
                                    <?php echo e($count); ?> <?php echo e(Str::plural(ucfirst(str_replace('_', ' ', $type)), $count)); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                        <i class="fas fa-plus-circle mr-1"></i> Add More
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-700 p-4 rounded-lg hover:shadow-md transition-all duration-200 border-l-4 <?php echo e($question->type == 'multiple_choice' ? 'border-blue-400' : ($question->type == 'true_false' ? 'border-green-400' : 'border-purple-400')); ?>">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-white flex items-center">
                                    <span class="bg-gray-600 text-gray-300 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2"><?php echo e($index + 1); ?></span>
                                    <span class="line-clamp-1"><?php echo e(Str::limit($question->question, 40)); ?></span>
                                </h3>
                                <span class="text-xs px-2 py-1 rounded-full <?php echo e($question->type == 'multiple_choice' ? 'bg-blue-900/30 text-blue-300' : ($question->type == 'true_false' ? 'bg-green-900/30 text-green-300' : 'bg-purple-900/30 text-purple-300')); ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $question->type ?? 'multiple_choice'))); ?>

                                </span>
                            </div>
                            <p class="mt-2 text-gray-300 text-sm line-clamp-2"><?php echo e($question->question); ?></p>
                            <div class="mt-3 flex justify-end">
                                <a href="<?php echo e(route('teacher.quizQuestions.edit', $question->id)); ?>" class="text-blue-400 hover:text-blue-300 text-xs">
                                    <i class="fas fa-pen mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6 text-center">
                    <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="btn-primary">
                        <i class="fas fa-edit mr-2"></i> Manage All Questions
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="bg-blue-900/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-blue-500 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-300 mb-2">No Questions Yet</h3>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto">This quiz doesn't have any questions yet. Add some questions to make it available to your students.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo e(route('teacher.quizQuestions', $quiz->id)); ?>" class="btn-primary">
                            <i class="fas fa-plus mr-2"></i> Add Questions Manually
                        </a>
                        <a href="<?php echo e(route('teacher.generate-quiz', $quiz->course_id)); ?>" class="btn-secondary">
                            <i class="fas fa-magic mr-2"></i> Generate with AI
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-8 bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="section-header" style="background: linear-gradient(to right, #dc2626, #b91c1c);">
            <i class="fas fa-exclamation-triangle"></i> Danger Zone
        </div>
        <div class="p-6">
            <div class="bg-red-900/10 border border-red-800 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-trash-alt text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-red-300">Delete this quiz</h3>
                        <p class="mt-1 text-sm text-gray-400">Once you delete a quiz, there is no going back. All questions and student results associated with this quiz will be permanently removed.</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-sm text-red-400">
                                <i class="fas fa-info-circle mr-1"></i> This action cannot be undone
                            </div>
                            <form action="<?php echo e(route('teacher.quizzes.delete', $quiz->id)); ?>" method="POST" id="deleteQuizForm">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" onclick="confirmDelete()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-trash-alt mr-2"></i> Delete Quiz
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center text-gray-400 text-sm">
        <p>© 2025 BrightPath Learning Platform. All rights reserved.</p>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this quiz? This action cannot be undone and will remove all associated questions and student results.')) {
            document.getElementById('deleteQuizForm').submit();
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Line clamp utilities */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Quiz-specific styles */
    .quiz-card {
        transition: transform 0.2s;
    }

    .quiz-card:hover {
        transform: translateY(-5px);
    }

    .question-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Custom gradient buttons */
    .btn-gradient-primary {
        background: linear-gradient(to right, #0284c7, #0369a1);
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(to right, #0369a1, #075985);
        transform: translateY(-2px);
    }

    .btn-gradient-secondary {
        background: linear-gradient(to right, #7c3aed, #6d28d9);
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-gradient-secondary:hover {
        background: linear-gradient(to right, #6d28d9, #5b21b6);
        transform: translateY(-2px);
    }

    /* Navigation Bar Styles */
    .dashboard-header {
        background-color: #1e293b;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        margin-bottom: 1.5rem;
    }

    .dashboard-logo {
        color: #38bdf8;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .dashboard-nav {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .dashboard-nav-link {
        color: #94a3b8;
        font-weight: 500;
        transition: color 0.2s;
    }

    .dashboard-nav-link:hover,
    .dashboard-nav-link.active {
        color: #e2e8f0;
    }

    /* Section Headers */
    .section-header {
        background: linear-gradient(to right, #0284c7, #7c3aed);
        padding: 1rem 1.5rem;
        color: white;
        font-weight: 600;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Buttons */
    .btn-primary {
        background-color: #0284c7;
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #0369a1;
    }

    .btn-secondary {
        background-color: #7c3aed;
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s;
    }

    .btn-secondary:hover {
        background-color: #6d28d9;
    }

    .btn-white {
        background-color: #1e293b;
        color: #38bdf8;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s;
    }

    .btn-white:hover {
        background-color: #334155;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/editQuiz.blade.php ENDPATH**/ ?>