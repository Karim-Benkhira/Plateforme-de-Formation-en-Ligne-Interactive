<?php $__env->startSection('title', 'Create Quiz'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom styles for create quiz page */
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

    .section-title {
        color: white;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1.25rem;
    }

    .section-title i {
        color: #38bdf8;
        margin-right: 0.5rem;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }

    .input-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #e2e8f0;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background-color: #0f172a;
        border: 1px solid #334155;
        border-radius: 0.5rem;
        color: white;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        outline: none;
    }

    .form-input::placeholder {
        color: #64748b;
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background-color: #0f172a;
        border: 1px solid #334155;
        border-radius: 0.5rem;
        color: white;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }

    .form-select:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        outline: none;
    }

    .setting-card {
        background-color: #0f172a;
        border-radius: 0.5rem;
        padding: 1rem;
        border: 1px solid #1e293b;
    }

    .setting-card.blue {
        border-left: 3px solid #38bdf8;
    }

    .setting-card.purple {
        border-left: 3px solid #a855f7;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        background-color: #0f172a;
        border-radius: 0.5rem;
        padding: 1rem;
        border: 1px solid #1e293b;
    }

    .checkbox-group.blue {
        border-left: 3px solid #38bdf8;
    }

    .checkbox-group.purple {
        border-left: 3px solid #a855f7;
    }

    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.25rem;
        border: 1px solid #4b5563;
        background-color: #1f2937;
        transition: all 0.2s ease;
        position: relative;
        appearance: none;
    }

    .form-checkbox:checked {
        background-color: #38bdf8;
        border-color: #38bdf8;
    }

    .form-checkbox:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0.75rem;
        height: 0.75rem;
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        background-size: cover;
    }

    .checkbox-label {
        margin-left: 0.75rem;
    }

    .checkbox-title {
        font-size: 0.875rem;
        font-weight: 500;
        color: #e2e8f0;
    }

    .checkbox-desc {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.25rem;
    }

    /* Question Styles - Kahoot-like */
    .question-card {
        background-color: #0f172a;
        border-radius: 0.75rem;
        border: 1px solid #1e293b;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .question-card:hover {
        border-color: #38bdf8;
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.1);
    }

    .question-header {
        background: linear-gradient(90deg, #7c3aed, #0284c7);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .question-number {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .question-content {
        padding: 1.5rem;
    }

    .question-input {
        width: 100%;
        padding: 1rem;
        background-color: #1e293b;
        border: 2px solid #334155;
        border-radius: 0.5rem;
        color: white;
        font-size: 1rem;
        transition: all 0.2s ease;
        margin-bottom: 1rem;
    }

    .question-input:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        outline: none;
    }

    .options-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1rem;
    }

    .option-card {
        background-color: #1e293b;
        border: 2px solid #334155;
        border-radius: 0.75rem;
        padding: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }

    .option-card.option-a { border-color: #ef4444; }
    .option-card.option-b { border-color: #3b82f6; }
    .option-card.option-c { border-color: #f59e0b; }
    .option-card.option-d { border-color: #10b981; }

    .option-card.correct {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
        border-color: #10b981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
    }

    .option-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: white;
        margin-bottom: 0.5rem;
    }

    .option-letter {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 0.75rem;
        font-size: 0.875rem;
    }

    .option-a .option-letter { background-color: #ef4444; }
    .option-b .option-letter { background-color: #3b82f6; }
    .option-c .option-letter { background-color: #f59e0b; }
    .option-d .option-letter { background-color: #10b981; }

    .option-input {
        width: 100%;
        background: transparent;
        border: none;
        color: #e2e8f0;
        font-size: 0.875rem;
        outline: none;
    }

    .option-input::placeholder {
        color: #64748b;
    }

    .correct-indicator {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: #10b981;
        color: white;
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .option-card.correct .correct-indicator {
        opacity: 1;
    }

    .question-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 1rem;
    }

    .btn-remove-question {
        background-color: #dc2626;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-remove-question:hover {
        background-color: #b91c1c;
        transform: translateY(-1px);
    }

    .btn-add-question {
        background: linear-gradient(90deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        margin: 2rem auto;
        font-size: 1rem;
    }

    .btn-add-question:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .btn-add-question i {
        margin-right: 0.5rem;
    }

    .btn-container {
        display: flex;
        justify-content: flex-end;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-cancel {
        background-color: transparent;
        border: 1px solid #4b5563;
        color: #e2e8f0;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .btn-submit {
        background: linear-gradient(90deg, #0284c7, #7c3aed);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        margin-left: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        border: none;
        cursor: pointer;
    }

    .btn-submit:hover {
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        transform: translateY(-2px);
    }

    .tip-card {
        display: flex;
        align-items: flex-start;
        background-color: #0f172a;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid #1e293b;
    }

    .tip-card.blue {
        border-left: 3px solid #38bdf8;
    }

    .tip-card.purple {
        border-left: 3px solid #a855f7;
    }

    .tip-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    .tip-icon.blue {
        background-color: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
    }

    .tip-icon.purple {
        background-color: rgba(168, 85, 247, 0.2);
        color: #a855f7;
    }

    .tip-text {
        font-size: 0.875rem;
        color: #e2e8f0;
    }

    /* Animation for adding questions */
    .question-card {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .options-grid {
            grid-template-columns: 1fr;
        }

        .question-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }

    /* Empty state */
    .empty-questions {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .empty-questions i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #38bdf8;
    }

    .questions-counter {
        background: linear-gradient(90deg, #10b981, #059669);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .questions-counter i {
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
                    <i class="fas fa-plus-circle text-blue-400"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">Create New Quiz</h1>
                    <p class="text-sm text-blue-200 opacity-80">Create a new quiz for your students</p>
                </div>
            </div>
            <a href="<?php echo e(route('teacher.quizzes')); ?>" class="bg-white/10 hover:bg-white/20 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center transition-all duration-300 border border-white/20">
                <i class="fas fa-arrow-left mr-2"></i> Back to Quizzes
            </a>
        </div>
    </div>

    <div class="form-card">
        <div class="form-header">
            <i class="fas fa-question-circle text-blue-400 mr-2"></i>
            <h2 class="text-white font-semibold">Quiz Details</h2>
        </div>
        <div class="form-content">
            <form action="<?php echo e(route('teacher.quizzes.store-with-questions')); ?>" method="POST" class="space-y-6" id="quizForm">
                <?php echo csrf_field(); ?>

                <!-- Quiz Information -->
                <div class="mb-6">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>Basic Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="input-group">
                            <label for="name" class="input-label">
                                <i class="fas fa-font text-blue-400 mr-1"></i> Quiz Name
                            </label>
                            <input type="text" name="name" id="name" placeholder="Enter quiz name" class="form-input" required>
                        </div>

                        <div class="input-group">
                            <label for="course_id" class="input-label">
                                <i class="fas fa-book text-blue-400 mr-1"></i> Select Course
                            </label>
                            <select name="course_id" id="course_id" class="form-select" required>
                                <option value="">Select a course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>"><?php echo e($course->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Quiz Settings -->
                <div class="mb-6">
                    <h3 class="section-title">
                        <i class="fas fa-cog"></i>Quiz Settings
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="setting-card blue">
                            <label for="duration" class="input-label">
                                <i class="fas fa-clock text-blue-400 mr-1"></i>Duration (minutes)
                            </label>
                            <input type="number" name="duration" id="duration" min="1" max="180" value="30" class="form-input" required>
                        </div>

                        <div class="setting-card blue">
                            <label for="passing_score" class="input-label">
                                <i class="fas fa-percentage text-blue-400 mr-1"></i>Passing Score (%)
                            </label>
                            <input type="number" name="passing_score" id="passing_score" min="1" max="100" value="70" class="form-input" required>
                        </div>

                        <div class="setting-card purple">
                            <label for="attempts_allowed" class="input-label">
                                <i class="fas fa-redo text-purple-400 mr-1"></i>Attempts Allowed
                            </label>
                            <input type="number" name="attempts_allowed" id="attempts_allowed" min="1" max="10" value="2" class="form-input" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="description" class="input-label">
                            <i class="fas fa-align-left text-blue-400 mr-1"></i>Description
                        </label>
                        <textarea name="description" id="description" rows="4" placeholder="Enter quiz description" class="form-input"></textarea>
                        <p class="text-xs text-gray-400 mt-1">Provide a brief description of what this quiz covers and its purpose.</p>
                    </div>
                </div>

                <!-- Quiz Options -->
                <div class="mb-6">
                    <h3 class="section-title">
                        <i class="fas fa-sliders-h"></i>Additional Options
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="checkbox-group blue">
                            <input type="checkbox" name="is_published" id="is_published" value="1" class="form-checkbox" <?php echo e(old('is_published') ? 'checked' : ''); ?>>
                            <div class="checkbox-label">
                                <div class="checkbox-title">Publish immediately</div>
                                <div class="checkbox-desc">If checked, the quiz will be available to students right away.</div>
                            </div>
                        </div>

                        <div class="checkbox-group purple">
                            <input type="checkbox" name="requires_face_verification" id="requires_face_verification" value="1" class="form-checkbox" <?php echo e(old('requires_face_verification') ? 'checked' : ''); ?>>
                            <div class="checkbox-label">
                                <div class="checkbox-title">Require face verification</div>
                                <div class="checkbox-desc">Enable secure exam mode with facial recognition to prevent cheating.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="section-title mb-0">
                            <i class="fas fa-question-circle"></i>Quiz Questions
                        </h3>
                        <div class="questions-counter">
                            <i class="fas fa-list-ol"></i>
                            <span id="questionsCount">0</span> Questions
                        </div>
                    </div>

                    <div id="questionsContainer">
                        <div class="empty-questions" id="emptyState">
                            <i class="fas fa-question-circle"></i>
                            <h4 class="text-lg font-semibold mb-2">No questions yet</h4>
                            <p>Click "Add Question" to start creating your quiz questions</p>
                        </div>
                    </div>

                    <button type="button" class="btn-add-question" onclick="addQuestion()">
                        <i class="fas fa-plus"></i>
                        Add Question
                    </button>
                </div>

                <div class="btn-container">
                    <button type="button" onclick="window.location.href='<?php echo e(route('teacher.quizzes')); ?>'" class="btn-cancel">
                        Cancel
                    </button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-save mr-2"></i> Create Quiz with Questions
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="form-card mt-6">
        <div class="form-header">
            <i class="fas fa-lightbulb text-blue-400 mr-2"></i>
            <h2 class="text-white font-semibold">Tips for Creating Effective Quizzes</h2>
        </div>
        <div class="form-content">
            <div class="space-y-3">
                <div class="tip-card blue">
                    <div class="tip-icon blue">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="tip-text">Keep questions clear and concise to avoid confusion.</p>
                </div>

                <div class="tip-card blue">
                    <div class="tip-icon blue">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="tip-text">Include a mix of question types (multiple choice, true/false, etc.).</p>
                </div>

                <div class="tip-card blue">
                    <div class="tip-icon blue">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <p class="tip-text">Ensure questions align with your course learning objectives.</p>
                </div>

                <div class="tip-card purple">
                    <div class="tip-icon purple">
                        <i class="fas fa-magic"></i>
                    </div>
                    <p class="tip-text">Consider using the AI quiz generation feature for time-saving and variety.</p>
                </div>

                <div class="tip-card purple">
                    <div class="tip-icon purple">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <p class="tip-text">For high-stakes assessments, enable face verification to ensure academic integrity.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let questionCount = 0;

function addQuestion() {
    questionCount++;

    const questionsContainer = document.getElementById('questionsContainer');
    const emptyState = document.getElementById('emptyState');

    // Hide empty state
    if (emptyState) {
        emptyState.style.display = 'none';
    }

    const questionHtml = `
        <div class="question-card" id="question-${questionCount}">
            <div class="question-header">
                <div class="question-number">Question ${questionCount}</div>
                <button type="button" class="btn-remove-question" onclick="removeQuestion(${questionCount})">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
            <div class="question-content">
                <div class="input-group">
                    <label class="input-label">
                        <i class="fas fa-question text-blue-400 mr-1"></i> Question Text
                    </label>
                    <input type="text" name="questions[${questionCount}][question]"
                           placeholder="Enter your question here..."
                           class="question-input" required>
                </div>

                <div class="options-grid">
                    <div class="option-card option-a" onclick="selectCorrectAnswer(${questionCount}, 0)">
                        <div class="option-label">
                            <div class="option-letter">A</div>
                            <span>Option A</span>
                        </div>
                        <input type="text" name="questions[${questionCount}][options][0]"
                               placeholder="Enter option A..."
                               class="option-input" required>
                        <div class="correct-indicator">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>

                    <div class="option-card option-b" onclick="selectCorrectAnswer(${questionCount}, 1)">
                        <div class="option-label">
                            <div class="option-letter">B</div>
                            <span>Option B</span>
                        </div>
                        <input type="text" name="questions[${questionCount}][options][1]"
                               placeholder="Enter option B..."
                               class="option-input" required>
                        <div class="correct-indicator">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>

                    <div class="option-card option-c" onclick="selectCorrectAnswer(${questionCount}, 2)">
                        <div class="option-label">
                            <div class="option-letter">C</div>
                            <span>Option C</span>
                        </div>
                        <input type="text" name="questions[${questionCount}][options][2]"
                               placeholder="Enter option C..."
                               class="option-input" required>
                        <div class="correct-indicator">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>

                    <div class="option-card option-d" onclick="selectCorrectAnswer(${questionCount}, 3)">
                        <div class="option-label">
                            <div class="option-letter">D</div>
                            <span>Option D</span>
                        </div>
                        <input type="text" name="questions[${questionCount}][options][3]"
                               placeholder="Enter option D..."
                               class="option-input" required>
                        <div class="correct-indicator">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="questions[${questionCount}][correct]" id="correct-${questionCount}" value="">
                <input type="hidden" name="questions[${questionCount}][type]" value="multiple_choice">

                <div class="question-actions">
                    <div class="text-sm text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        Click on an option to mark it as the correct answer
                    </div>
                </div>
            </div>
        </div>
    `;

    questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
    updateQuestionsCount();
}

function removeQuestion(questionId) {
    const questionElement = document.getElementById(`question-${questionId}`);
    if (questionElement) {
        questionElement.remove();
        updateQuestionsCount();

        // Show empty state if no questions
        const remainingQuestions = document.querySelectorAll('.question-card').length;
        if (remainingQuestions === 0) {
            document.getElementById('emptyState').style.display = 'block';
        }
    }
}

function selectCorrectAnswer(questionId, optionIndex) {
    // Remove correct class from all options in this question
    const questionElement = document.getElementById(`question-${questionId}`);
    const options = questionElement.querySelectorAll('.option-card');
    options.forEach(option => option.classList.remove('correct'));

    // Add correct class to selected option
    options[optionIndex].classList.add('correct');

    // Update hidden input
    document.getElementById(`correct-${questionId}`).value = optionIndex;
}

function updateQuestionsCount() {
    const count = document.querySelectorAll('.question-card').length;
    document.getElementById('questionsCount').textContent = count;
}

// Form validation
document.getElementById('quizForm').addEventListener('submit', function(e) {
    const questions = document.querySelectorAll('.question-card');

    if (questions.length === 0) {
        e.preventDefault();
        alert('Please add at least one question to your quiz.');
        return;
    }

    // Check if all questions have correct answers selected
    let hasErrors = false;
    questions.forEach((question, index) => {
        const correctInput = question.querySelector('input[name*="[correct]"]');
        if (!correctInput.value) {
            hasErrors = true;
            question.scrollIntoView({ behavior: 'smooth' });
            question.style.border = '2px solid #ef4444';
            setTimeout(() => {
                question.style.border = '';
            }, 3000);
        }
    });

    if (hasErrors) {
        e.preventDefault();
        alert('Please select the correct answer for all questions.');
    }
});

// Add first question by default
document.addEventListener('DOMContentLoaded', function() {
    // You can uncomment this line if you want to add a question by default
    // addQuestion();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/createQuiz.blade.php ENDPATH**/ ?>