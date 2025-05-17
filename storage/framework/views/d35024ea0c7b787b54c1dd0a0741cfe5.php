<?php $__env->startSection('title', 'Quiz Questions'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom styles for quiz questions page */
    .quiz-header {
        background-color: #111827;
        border-radius: 1rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    /* Question card styles */
    .question-card {
        position: relative;
    }

    /* Question action buttons */
    .question-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 1rem;
        gap: 0.5rem;
    }

    /* Individual question card */
    .question-item {
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
    }

    /* Question number */
    .question-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        margin-right: 0.5rem;
        font-size: 0.75rem;
        font-weight: bold;
        color: white;
    }

    .quiz-title-bar {
        background: linear-gradient(90deg, #0284c7, #7c3aed);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .quiz-info-card {
        background-color: #1e293b;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .quiz-info-header {
        background-color: #0f172a;
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quiz-info-content {
        padding: 1.25rem;
    }

    .stat-card {
        background-color: #0f172a;
        border-radius: 0.5rem;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon.blue {
        background-color: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
    }

    .stat-icon.purple {
        background-color: rgba(168, 85, 247, 0.2);
        color: #a855f7;
    }

    .question-card {
        background-color: #1e293b;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .question-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .question-header {
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .question-content {
        padding: 1.5rem;
    }

    .answer-option {
        background-color: #0f172a;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .answer-option:hover {
        background-color: #1e293b;
    }

    .answer-option.correct {
        background-color: rgba(56, 189, 248, 0.2);
        border: 1px solid rgba(56, 189, 248, 0.3);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        min-width: 90px;
        font-size: 0.875rem;
    }

    .action-btn.edit {
        background-color: rgba(79, 70, 229, 0.2);
        border: 1px solid rgba(79, 70, 229, 0.3);
        color: #818cf8;
    }

    .action-btn.edit:hover {
        background-color: rgba(79, 70, 229, 0.3);
        transform: translateY(-2px);
    }

    .action-btn.delete {
        background-color: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #f87171;
    }

    .action-btn.delete:hover {
        background-color: rgba(239, 68, 68, 0.3);
        transform: translateY(-2px);
    }

    /* Common button styles */
    .btn {
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        min-width: 110px;
        height: 36px;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        background: linear-gradient(90deg, #0284c7, #7c3aed);
    }

    .btn-primary:hover {
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(90deg, #7c3aed, #8b5cf6);
    }

    .btn-secondary:hover {
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-blue {
        background: linear-gradient(90deg, #0ea5e9, #3b82f6);
    }

    .btn-blue:hover {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-purple {
        background: linear-gradient(90deg, #8b5cf6, #a855f7);
    }

    .btn-purple:hover {
        box-shadow: 0 4px 12px rgba(168, 85, 247, 0.3);
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }

    .btn-outline:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        min-width: 80px;
        height: 30px;
    }

    .btn-edit {
        background: linear-gradient(90deg, #4f46e5, #818cf8);
    }

    .btn-edit:hover {
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-delete {
        background: linear-gradient(90deg, #ef4444, #f87171);
    }

    .btn-delete:hover {
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Quiz Header -->
<div class="quiz-header">
    <div class="quiz-title-bar">
        <div class="flex items-center">
            <div class="bg-blue-500/20 p-2 rounded-full mr-3">
                <i class="fas fa-question-circle text-blue-400"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white"><?php echo e($quiz->name); ?></h1>
                <p class="text-sm text-blue-200 opacity-80">Manage questions for this quiz</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('teacher.createQuestion', $quiz->id)); ?>" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> Add Question
            </a>
            <a href="<?php echo e(route('teacher.generate-quiz', $quiz->course->id)); ?>" class="btn btn-secondary">
                <i class="fas fa-magic mr-2"></i> AI Generate
            </a>
        </div>
    </div>
</div>

    <!-- Quiz Information Card -->
    <div class="quiz-info-card">
        <div class="quiz-info-header flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                <h2 class="text-white font-semibold">Quiz Information</h2>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full <?php echo e($quiz->is_published ? 'bg-blue-900/50 text-blue-300 border border-blue-700/50' : 'bg-purple-900/50 text-purple-300 border border-purple-700/50'); ?>">
                    <i class="fas <?php echo e($quiz->is_published ? 'fa-check-circle' : 'fa-clock'); ?> mr-1"></i>
                    <?php echo e($quiz->is_published ? 'Published' : 'Draft'); ?>

                </span>
                <a href="#" class="btn btn-sm btn-purple">
                    <i class="fas fa-save mr-1"></i> Draft Quiz
                </a>
                <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" class="btn btn-sm btn-blue">
                    <i class="fas fa-edit mr-1"></i> Edit Quiz
                </a>
            </div>
        </div>
        <div class="quiz-info-content">
            <p class="text-gray-400 mb-4 text-sm">
                <span class="font-medium text-blue-400">Course:</span> <?php echo e($quiz->course->title); ?>

            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-question"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Questions</p>
                        <p class="text-xl font-bold text-white"><?php echo e($quiz->questions->count()); ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Duration</p>
                        <p class="text-xl font-bold text-white"><?php echo e($quiz->duration ?? 'N/A'); ?> min</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Passing Score</p>
                        <p class="text-xl font-bold text-white"><?php echo e($quiz->passing_score ?? 'N/A'); ?>%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-blue-900/20 border border-blue-700/30 text-blue-300 p-4 mb-6 rounded-lg shadow-lg" role="alert">
            <div class="flex items-center">
                <div class="bg-blue-500/20 p-2 rounded-full mr-3 flex-shrink-0">
                    <i class="fas fa-check-circle text-blue-400"></i>
                </div>
                <p class="font-medium text-sm"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if($quiz->questions->count() > 0): ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="question-card">
                    <div class="question-header">
                        <h3 class="text-sm font-bold text-white flex items-center">
                            <div class="question-number">
                                <?php echo e($index + 1); ?>

                            </div>
                            Question <?php echo e($index + 1); ?>

                        </h3>
                    </div>
                    <div class="question-content">
                        <p class="text-gray-200 font-medium mb-4 text-sm"><?php echo e($question->question); ?></p>

                        <?php if($question->type === 'short_answer' || !$question->type): ?>
                            <div class="mt-4">
                                <div class="bg-blue-900/20 p-3 rounded-lg border border-blue-700/30">
                                    <p class="text-xs font-medium text-blue-300 flex items-center">
                                        <i class="fas fa-check-circle text-blue-400 mr-2"></i>
                                        <span class="font-bold">Correct Answer:</span> <?php echo e($question->answers); ?>

                                    </p>
                                </div>
                            </div>

                            <div class="question-actions">
                                <a href="<?php echo e(route('teacher.editQuestion', $question->id)); ?>" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="<?php echo e(route('teacher.deleteQuestion', $question->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="space-y-2">
                                <?php
                                    $answers = explode(',', $question->answers);
                                ?>

                                <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerIndex => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="answer-option <?php echo e($answerIndex == $question->correct ? 'correct' : ''); ?>">
                                        <div class="flex items-center h-5">
                                            <input type="radio" disabled <?php echo e($answerIndex == $question->correct ? 'checked' : ''); ?> class="h-4 w-4 text-blue-400 border-gray-600">
                                        </div>
                                        <div class="ml-3 text-xs">
                                            <label class="font-medium text-gray-300 <?php echo e($answerIndex == $question->correct ? 'text-blue-400 font-bold' : ''); ?>">
                                                <?php echo e($answer); ?>

                                                <?php if($answerIndex == $question->correct): ?>
                                                    <span class="ml-2 text-blue-400 inline-flex items-center">
                                                        <i class="fas fa-check-circle mr-1"></i> Correct
                                                    </span>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="question-actions">
                            <a href="<?php echo e(route('teacher.editQuestion', $question->id)); ?>" class="btn btn-sm btn-edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="<?php echo e(route('teacher.deleteQuestion', $question->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-delete">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="quiz-info-card mt-6">
            <div class="quiz-info-header flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-clipboard-list text-blue-400 mr-2"></i>
                    <h2 class="text-white font-semibold">Quiz Summary</h2>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-900/20 px-3 py-1 rounded-full border border-blue-700/30 text-xs text-blue-300">
                        <span>Total: <?php echo e($quiz->questions->count()); ?></span>
                    </div>
                </div>
            </div>
            <div class="quiz-info-content flex flex-col sm:flex-row justify-between items-center">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="stat-icon blue">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Total Questions</p>
                        <p class="text-xl font-bold text-white"><?php echo e($quiz->questions->count()); ?></p>
                    </div>
                </div>

                <div class="flex items-center justify-between w-full">
                    <div class="flex space-x-3">
                        <a href="#" class="btn btn-purple">
                            <i class="fas fa-save mr-2"></i>
                            <span>Draft Quiz</span>
                        </a>

                        <?php if(!$quiz->is_published): ?>
                            <form action="<?php echo e(route('teacher.quizzes.update', $quiz->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="name" value="<?php echo e($quiz->name); ?>">
                                <input type="hidden" name="course_id" value="<?php echo e($quiz->course_id); ?>">
                                <input type="hidden" name="description" value="<?php echo e($quiz->description); ?>">
                                <input type="hidden" name="duration" value="<?php echo e($quiz->duration ?? 30); ?>">
                                <input type="hidden" name="passing_score" value="<?php echo e($quiz->passing_score ?? 70); ?>">
                                <input type="hidden" name="attempts_allowed" value="<?php echo e($quiz->attempts_allowed ?? 1); ?>">
                                <input type="hidden" name="is_published" value="1">
                                <input type="hidden" name="requires_face_verification" value="<?php echo e($quiz->requires_face_verification ? '1' : '0'); ?>">

                                <button type="submit" class="btn btn-blue">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <span>Publish Quiz</span>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="text-indigo-300 text-sm font-medium">
                        Total: <span class="font-bold"><?php echo e($quiz->questions->count()); ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="quiz-info-card p-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-900/30 mb-6 border border-blue-700/30">
                <i class="fas fa-question-circle text-3xl text-blue-400"></i>
            </div>
            <h3 class="text-xl font-medium text-white mb-3">No Questions Yet</h3>
            <p class="text-gray-400 mb-8 max-w-md mx-auto text-sm">This quiz doesn't have any questions yet. Add some questions to get started and create an effective assessment.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="<?php echo e(route('teacher.createQuestion', $quiz->id)); ?>" class="btn btn-primary" style="min-width: 200px;">
                    <i class="fas fa-plus mr-2"></i>
                    <span>Add Question Manually</span>
                </a>
                <a href="<?php echo e(route('teacher.generate-quiz', $quiz->course->id)); ?>" class="btn btn-secondary" style="min-width: 200px;">
                    <i class="fas fa-magic mr-2"></i>
                    <span>Generate with AI</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/quizQuestions.blade.php ENDPATH**/ ?>