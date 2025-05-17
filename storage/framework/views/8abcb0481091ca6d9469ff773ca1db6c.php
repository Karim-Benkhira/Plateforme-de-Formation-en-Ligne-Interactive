<?php $__env->startSection('title', 'AI Generated Questions'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/ai-quiz-buttons.css')); ?>">
<style>
    .question-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .quiz-summary {
        background-color: #1e293b;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-top: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .quiz-summary-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .quiz-summary-icon {
        background-color: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .quiz-summary-text {
        color: white;
    }
    
    .quiz-summary-count {
        font-size: 1.5rem;
        font-weight: bold;
    }
    
    .quiz-summary-label {
        color: #94a3b8;
        font-size: 0.875rem;
    }
    
    .quiz-actions {
        display: flex;
        gap: 1rem;
    }
    
    .quiz-action-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .quiz-action-btn.primary {
        background: linear-gradient(90deg, #0284c7, #7c3aed);
        color: white;
    }
    
    .quiz-action-btn.primary:hover {
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        transform: translateY(-2px);
    }
    
    .quiz-action-btn.secondary {
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .quiz-action-btn.secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }
    
    .quiz-action-btn i {
        margin-right: 0.5rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Quiz Header -->
    <div class="quiz-header">
        <div class="quiz-title-bar">
            <div class="flex items-center">
                <div class="bg-blue-500/20 p-2 rounded-full mr-3">
                    <i class="fas fa-robot text-blue-400"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white"><?php echo e($quiz->name); ?></h1>
                    <p class="text-sm text-blue-200 opacity-80">AI Generated Questions</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('teacher.quizzes')); ?>" class="bg-white/10 hover:bg-white/20 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center transition-all duration-300 border border-white/20">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
                </a>
            </div>
        </div>
    </div>
    
    <!-- Questions List -->
    <div class="question-list">
        <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="ai-question-card">
                <div class="ai-question-header">
                    <div class="ai-question-number">
                        <div class="ai-question-number-circle">
                            <?php echo e($index + 1); ?>

                        </div>
                        Question <?php echo e($index + 1); ?>

                    </div>
                    <div class="ai-question-actions">
                        <a href="<?php echo e(route('teacher.editQuestion', $question->id)); ?>" class="ai-action-btn edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="<?php echo e(route('teacher.deleteQuestion', $question->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="ai-action-btn delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div class="ai-question-content">
                    <p class="text-gray-200 font-medium mb-4"><?php echo e($question->question); ?></p>
                    
                    <?php if($question->type === 'short_answer' || !$question->type): ?>
                        <div class="mt-4">
                            <div class="bg-blue-900/20 p-3 rounded-lg border border-blue-700/30">
                                <p class="text-sm font-medium text-blue-300 flex items-center">
                                    <i class="fas fa-check-circle text-blue-400 mr-2"></i>
                                    <span class="font-bold">Correct Answer:</span> <?php echo e($question->answers); ?>

                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="space-y-2">
                            <?php
                                $answers = explode(',', $question->answers);
                            ?>
                            
                            <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerIndex => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ai-answer-option <?php echo e($answerIndex == $question->correct ? 'correct' : ''); ?>">
                                    <div class="flex items-center h-5">
                                        <input type="radio" disabled <?php echo e($answerIndex == $question->correct ? 'checked' : ''); ?> class="h-4 w-4 text-blue-400 border-gray-600">
                                    </div>
                                    <div class="ml-3 text-sm">
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
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <!-- Quiz Summary -->
    <div class="quiz-summary">
        <div class="quiz-summary-info">
            <div class="quiz-summary-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="quiz-summary-text">
                <div class="quiz-summary-count"><?php echo e($quiz->questions->count()); ?></div>
                <div class="quiz-summary-label">Total Questions</div>
            </div>
        </div>
        
        <div class="quiz-actions">
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
                    
                    <button type="submit" class="quiz-action-btn primary">
                        <i class="fas fa-check-circle"></i> Publish Quiz
                    </button>
                </form>
            <?php endif; ?>
            
            <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" class="quiz-action-btn secondary">
                <i class="fas fa-cog"></i> Quiz Settings
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/ai-quiz-buttons.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/aiGeneratedQuestions.blade.php ENDPATH**/ ?>