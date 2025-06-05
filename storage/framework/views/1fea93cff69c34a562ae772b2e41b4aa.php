<?php $__env->startSection('title', 'Create New Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Create New Quiz</h1>
                <p class="text-green-100">Create your quiz and add questions all in one place</p>
            </div>
            <a href="<?php echo e(route('teacher.simple-quiz.index')); ?>"
               class="bg-white/20 hover:bg-white/30 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="<?php echo e(route('teacher.simple-quiz.store')); ?>" method="POST" id="quiz-form">
        <?php echo csrf_field(); ?>

        <!-- Quiz Information -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Quiz Information</h2>
                <p class="text-gray-600 mt-1">Basic details about your quiz</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <!-- Quiz Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Quiz Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                               value="<?php echo e(old('name')); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter quiz name" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Course Selection -->
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Course <span class="text-red-500">*</span>
                        </label>
                        <select id="course_id" name="course_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Select a course</option>
                            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>>
                                    <?php echo e($course->title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                            Duration (minutes) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="duration" name="duration" min="5" max="180"
                               value="<?php echo e(old('duration', 30)); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Passing Score -->
                    <div>
                        <label for="passing_score" class="block text-sm font-medium text-gray-700 mb-2">
                            Passing Score (%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="passing_score" name="passing_score" min="1" max="100"
                               value="<?php echo e(old('passing_score', 70)); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <?php $__errorArgs = ['passing_score'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Face Verification -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Face Verification</label>
                        <div class="flex items-center h-10">
                            <input type="checkbox" id="requires_face_verification" name="requires_face_verification" value="1"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                   <?php echo e(old('requires_face_verification') ? 'checked' : ''); ?>>
                            <label for="requires_face_verification" class="ml-2 text-sm text-gray-700">
                                Required
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (Optional)
                    </label>
                    <textarea id="description" name="description" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Brief description of what this quiz covers"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Quiz Questions</h2>
                        <p class="text-gray-600 mt-1">Add multiple choice questions to your quiz</p>
                    </div>
                    <button type="button" id="add-question-btn"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i> Add Question
                    </button>
                </div>
            </div>

            <div id="questions-container" class="divide-y divide-gray-200">
                <!-- Questions will be added here dynamically -->
            </div>
        </div>

        <!-- Submit Button -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-600">Make sure to add at least one question before creating the quiz.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('teacher.simple-quiz.index')); ?>"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit" id="submit-quiz-btn"
                            class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors" disabled>
                        <i class="fas fa-save mr-2"></i> Create Quiz with Questions
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.question-item {
    border-left: 4px solid #e5e7eb;
    transition: all 0.3s ease;
}

.question-item:hover {
    border-left-color: #3b82f6;
    background-color: #f8fafc;
}

.question-item.active {
    border-left-color: #10b981;
    background-color: #f0fdf4;
}

.option-input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.add-question-animation {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = 0;
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionBtn = document.getElementById('add-question-btn');
    const submitBtn = document.getElementById('submit-quiz-btn');

    // Add first question automatically
    addQuestion();

    // Add question button click
    addQuestionBtn.addEventListener('click', function() {
        addQuestion();
    });

    function addQuestion() {
        questionCount++;

        const questionHtml = `
            <div class="question-item p-6 add-question-animation" data-question="${questionCount}">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-medium mr-3">
                            ${questionCount}
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Question ${questionCount}</h3>
                    </div>
                    ${questionCount > 1 ? `
                        <button type="button" class="remove-question text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    ` : ''}
                </div>

                <!-- Question Text -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Question Text <span class="text-red-500">*</span>
                    </label>
                    <textarea name="questions[${questionCount - 1}][question]" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Enter your question here..." required></textarea>
                </div>

                <!-- Answer Options -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Answer Options <span class="text-red-500">*</span>
                        <span class="text-gray-500 text-xs">(Select the correct answer)</span>
                    </label>

                    <div class="space-y-2">
                        ${[0, 1, 2, 3].map(i => `
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <input type="radio" name="questions[${questionCount - 1}][correct_answer]" value="${i}"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" required>
                                </div>
                                <div class="flex-shrink-0 mr-3">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">
                                        ${String.fromCharCode(65 + i)}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="questions[${questionCount - 1}][options][]"
                                           class="option-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter option ${String.fromCharCode(65 + i)}" required>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                <!-- Points -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Points <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="questions[${questionCount - 1}][points]" min="1" max="10" value="1"
                           class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <span class="text-xs text-gray-500 ml-2">Points for correct answer</span>
                </div>
            </div>
        `;

        questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
        updateSubmitButton();
        updateQuestionNumbers();
    }

    // Remove question functionality
    questionsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            const questionItem = e.target.closest('.question-item');
            questionItem.remove();
            questionCount--;
            updateSubmitButton();
            updateQuestionNumbers();
        }
    });

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-item');
        questions.forEach((question, index) => {
            const questionNumber = index + 1;

            // Update question number badge
            const badge = question.querySelector('.w-8.h-8');
            if (badge) {
                badge.textContent = questionNumber;
            }

            // Update question title
            const title = question.querySelector('h3');
            title.textContent = `Question ${questionNumber}`;

            // Update form field names
            const textarea = question.querySelector('textarea');
            textarea.name = `questions[${index}][question]`;

            const radioButtons = question.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                radio.name = `questions[${index}][correct_answer]`;
            });

            const textInputs = question.querySelectorAll('input[type="text"]');
            textInputs.forEach(input => {
                input.name = `questions[${index}][options][]`;
            });

            const pointsInput = question.querySelector('input[type="number"]');
            pointsInput.name = `questions[${index}][points]`;

            // Update question data attribute
            question.setAttribute('data-question', questionNumber);
        });
    }

    function updateSubmitButton() {
        const hasQuestions = questionsContainer.children.length > 0;
        submitBtn.disabled = !hasQuestions;

        if (hasQuestions) {
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Form validation before submit
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
        const questions = questionsContainer.querySelectorAll('.question-item');

        if (questions.length === 0) {
            e.preventDefault();
            alert('Please add at least one question to the quiz.');
            return;
        }

        // Check if all questions have correct answers selected
        let allValid = true;
        questions.forEach((question, index) => {
            const radioButtons = question.querySelectorAll('input[type="radio"]');
            const hasSelection = Array.from(radioButtons).some(radio => radio.checked);

            if (!hasSelection) {
                allValid = false;
                alert(`Please select a correct answer for Question ${index + 1}.`);
            }
        });

        if (!allValid) {
            e.preventDefault();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/simple-quiz/create.blade.php ENDPATH**/ ?>