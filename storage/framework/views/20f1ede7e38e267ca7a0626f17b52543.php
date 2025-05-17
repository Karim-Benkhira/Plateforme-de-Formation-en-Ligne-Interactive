<?php $__env->startSection('title', 'Edit Question'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom styles for edit question page */
    .quiz-header {
        background-color: #111827;
        border-radius: 1rem;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .quiz-title-bar {
        background: linear-gradient(90deg, #0284c7, #7c3aed);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .form-card {
        background-color: #1e293b;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .form-header {
        background-color: #0f172a;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
    }

    .form-content {
        padding: 1.5rem;
    }

    .btn-primary {
        background: linear-gradient(90deg, #0284c7, #7c3aed);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #334155;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #475569;
        box-shadow: 0 4px 12px rgba(51, 65, 85, 0.3);
        transform: translateY(-2px);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4">
    <!-- Quiz Header -->
    <div class="quiz-header">
        <div class="quiz-title-bar">
            <div class="flex items-center">
                <div class="bg-blue-500/20 p-2 rounded-full mr-3">
                    <i class="fas fa-edit text-blue-400"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Edit Question</h1>
                    <p class="text-sm text-blue-200 opacity-80">Update question details</p>
                </div>
            </div>
            <div>
                <a href="<?php echo e(route('teacher.quizQuestions', $question->quiz_id)); ?>" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Questions
                </a>
            </div>
        </div>
    </div>

    <div class="form-card">
        <div class="form-header">
            <i class="fas fa-question-circle text-blue-400 mr-2"></i>
            <h2 class="text-white font-semibold">Question Details</h2>
        </div>
        <div class="form-content">
            <?php if($errors->any()): ?>
                <div class="bg-red-900/20 border border-red-700/30 text-red-300 p-4 mb-6 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <div class="bg-red-500/20 p-2 rounded-full mr-3 flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div>
                            <p class="font-bold">Error</p>
                            <ul class="mt-1 text-sm">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <form action="<?php echo e(route('teacher.updateQuestion', $question->id)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="question" class="block text-sm font-medium text-gray-300 mb-2">Question</label>
                <textarea name="question" id="question" rows="3" class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white" required><?php echo e(old('question', $question->question)); ?></textarea>
            </div>

            <div>
                <label for="question_type" class="block text-sm font-medium text-gray-300 mb-2">Question Type</label>
                <select name="question_type" id="question_type" class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white" onchange="toggleQuestionType()">
                    <option value="multiple_choice" <?php echo e((old('question_type', $question->type) == 'multiple_choice' || !$question->type) ? 'selected' : ''); ?>>Multiple Choice</option>
                    <option value="true_false" <?php echo e(old('question_type', $question->type) == 'true_false' ? 'selected' : ''); ?>>True/False</option>
                    <option value="short_answer" <?php echo e(old('question_type', $question->type) == 'short_answer' ? 'selected' : ''); ?>>Short Answer</option>
                </select>
            </div>

            <div id="multiple_choice_options" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Answer Options</label>
                    <p class="text-sm text-gray-400 mb-2">Enter each option on a new line. Mark the correct answer with an asterisk (*) at the beginning.</p>
                    <textarea name="options" id="options" rows="6" class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white"><?php echo e(old('options', $formattedOptions ?? '')); ?></textarea>
                    <p class="text-sm text-gray-400 mt-2">Example:<br>Option 1<br>*Option 2 (correct)<br>Option 3</p>
                </div>
            </div>

            <div id="true_false_options" class="space-y-4 hidden">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Correct Answer</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="true" name="correct_tf" value="true" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-600"
                                <?php echo e(old('correct_tf', ($question->type == 'true_false' && $question->correct == 0) ? 'true' : '') == 'true' ? 'checked' : ''); ?>>
                            <label for="true" class="ml-2 block text-sm text-gray-300">True</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="false" name="correct_tf" value="false" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-600"
                                <?php echo e(old('correct_tf', ($question->type == 'true_false' && $question->correct == 1) ? 'false' : '') == 'false' ? 'checked' : ''); ?>>
                            <label for="false" class="ml-2 block text-sm text-gray-300">False</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="short_answer_options" class="space-y-4 hidden">
                <div>
                    <label for="correct_answer" class="block text-sm font-medium text-gray-300 mb-2">Correct Answer</label>
                    <input type="text" name="correct_answer" id="correct_answer" value="<?php echo e(old('correct_answer', $question->type == 'short_answer' ? $question->answers : '')); ?>" class="w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-700 text-white">
                    <p class="text-sm text-gray-400 mt-2">Enter the correct answer. Student responses will be checked against this.</p>
                </div>
            </div>

            <div class="pt-5 border-t border-gray-700">
                <div class="flex justify-end space-x-3">
                    <a href="<?php echo e(route('teacher.quizQuestions', $question->quiz_id)); ?>" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i> Update Question
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Format the options for display in the textarea
    document.addEventListener('DOMContentLoaded', function() {
        const questionType = "<?php echo e($question->type ?? 'multiple_choice'); ?>";
        const optionsTextarea = document.getElementById('options');

        if (questionType === 'multiple_choice' || !questionType) {
            const answers = "<?php echo e($question->answers); ?>".split(',');
            const correctIndex = <?php echo e($question->correct ?? 0); ?>;

            let formattedOptions = '';
            answers.forEach((answer, index) => {
                if (index === correctIndex) {
                    formattedOptions += '*' + answer + '\n';
                } else {
                    formattedOptions += answer + '\n';
                }
            });

            optionsTextarea.value = formattedOptions;
        }

        toggleQuestionType();

        // Add animation effects to buttons
        const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(124, 58, 237, 0.3)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });

    function toggleQuestionType() {
        const questionType = document.getElementById('question_type').value;

        // Hide all option sections first
        document.getElementById('multiple_choice_options').classList.add('hidden');
        document.getElementById('true_false_options').classList.add('hidden');
        document.getElementById('short_answer_options').classList.add('hidden');

        // Show the selected option section
        if (questionType === 'multiple_choice') {
            document.getElementById('multiple_choice_options').classList.remove('hidden');
        } else if (questionType === 'true_false') {
            document.getElementById('true_false_options').classList.remove('hidden');
        } else if (questionType === 'short_answer') {
            document.getElementById('short_answer_options').classList.remove('hidden');
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/editQuestion.blade.php ENDPATH**/ ?>