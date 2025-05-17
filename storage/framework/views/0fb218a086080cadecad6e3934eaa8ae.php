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
            <form action="<?php echo e(route('teacher.quizzes.store')); ?>" method="POST" class="space-y-6">
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

                <div class="btn-container">
                    <button type="button" onclick="window.location.href='<?php echo e(route('teacher.quizzes')); ?>'" class="btn-cancel">
                        Cancel
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save mr-2"></i> Create Quiz and Add Questions
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/createQuiz.blade.php ENDPATH**/ ?>