<?php $__env->startSection('title', 'Quiz: ' . $quiz->name); ?>

<?php $__env->startSection('content'); ?>
<!-- Quiz Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white"><?php echo e($quiz->name); ?></h1>
            <p class="text-blue-100"><?php echo e($quiz->description ?? 'Test your knowledge with this quiz'); ?></p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-4">
            <div class="bg-white/20 rounded-lg px-4 py-2 text-white">
                <span class="block text-sm">Questions</span>
                <span class="font-bold text-xl"><?php echo e(count($quiz->questions)); ?></span>
            </div>
            <div class="bg-white/20 rounded-lg px-4 py-2 text-white">
                <span class="block text-sm">Time</span>
                <span class="font-bold text-xl"><?php echo e($quiz->duration ?? '30'); ?> min</span>
            </div>
        </div>
    </div>
</div>

<!-- Quiz Content -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Left Column - Quiz Questions -->
    <div class="lg:col-span-3">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-question-circle mr-2"></i> Quiz Questions
            </div>
            <div class="section-content">
                <?php if(count($quiz->questions) > 0): ?>
                    <form id="quizForm" action="<?php echo e(route('student.submitQuiz')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="quiz_id" value="<?php echo e($quiz->id); ?>">

                        <div id="quiz-timer" class="bg-gradient-to-r from-gray-800 to-gray-700 p-4 rounded-lg mb-6 flex items-center justify-between shadow-lg border border-gray-700">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-primary-400"></i>
                                </div>
                                <span class="text-white font-medium">Time Remaining:</span>
                            </div>
                            <div class="text-2xl font-bold text-white bg-gray-900 px-4 py-2 rounded-lg shadow-inner" id="timer-display">
                                <span id="minutes"><?php echo e($quiz->duration ?? '30'); ?></span>:<span id="seconds">00</span>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-gray-800 rounded-lg overflow-hidden question-card" id="question-<?php echo e($index + 1); ?>">
                                    <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                                        <h3 class="text-white font-medium flex items-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-900 text-primary-300 mr-3">
                                                <?php echo e($index + 1); ?>

                                            </span>
                                            <?php echo e($question->question); ?>

                                        </h3>
                                        <?php if($question->type): ?>
                                            <span class="text-xs px-2 py-1 rounded-full bg-secondary-900 text-secondary-300">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $question->type))); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="p-6">
                                        <?php if($question->type == 'multiple_choice' || $question->type == 'true_false' || !$question->type): ?>
                                            <?php $answers = $question->getFormattedAnswers(); ?>
                                            <div class="space-y-3">
                                                <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerIndex => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label class="block w-full">
                                                        <input
                                                            type="radio"
                                                            name="answers[<?php echo e($question->id); ?>]"
                                                            value="<?php echo e($answerIndex); ?>"
                                                            class="peer hidden"
                                                            id="answer<?php echo e($question->id); ?>_<?php echo e($answerIndex); ?>"
                                                            required
                                                        />
                                                        <span class="flex items-center w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white cursor-pointer transition-all duration-200
                                                            peer-checked:bg-primary-900 peer-checked:border-primary-500 peer-checked:shadow-lg
                                                            hover:bg-gray-600 hover:border-primary-400 hover:shadow">
                                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full border border-gray-500 mr-3 transition-all duration-200
                                                                peer-checked:bg-primary-500 peer-checked:border-primary-300 peer-checked:scale-110">
                                                                <i class="fas fa-check text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200"></i>
                                                            </span>
                                                            <?php echo e(trim($answer)); ?>

                                                        </span>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php elseif($question->type == 'short_answer'): ?>
                                            <div class="space-y-3">
                                                <textarea
                                                    name="answers[<?php echo e($question->id); ?>]"
                                                    rows="4"
                                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg p-4 text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent shadow-inner transition-all duration-200 hover:border-gray-500 focus:shadow-lg"
                                                    placeholder="Type your answer here..."
                                                    required
                                                ></textarea>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="flex justify-between items-center pt-6">
                            <button type="button" id="prev-btn" class="bg-gray-700 hover:bg-gray-600 text-white font-medium px-5 py-3 rounded-lg shadow transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-gray-700" disabled>
                                <i class="fas fa-arrow-left mr-2"></i> Previous
                            </button>

                            <div class="flex items-center bg-gray-800 px-4 py-2 rounded-lg shadow">
                                <span id="current-question" class="text-primary-400 font-bold text-xl">1</span>
                                <span class="text-gray-400 mx-2">/</span>
                                <span class="text-white"><?php echo e(count($quiz->questions)); ?></span>
                            </div>

                            <button type="button" id="next-btn" class="bg-primary-600 hover:bg-primary-700 text-white font-medium px-5 py-3 rounded-lg shadow transition-colors flex items-center disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-primary-600">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>

                        <div class="mt-8 text-center">
                            <button type="submit" id="submit-quiz" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold text-lg px-10 py-4 rounded-xl shadow-lg transform transition-transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Quiz
                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-question-circle text-primary-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Questions Available</h3>
                        <p class="text-gray-400">This quiz doesn't have any questions yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Column - Quiz Information -->
    <div class="space-y-8">
        <!-- Quiz Details -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-info-circle mr-2"></i> Quiz Information
            </div>
            <div class="section-content">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-book text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Course</p>
                            <p class="text-white"><?php echo e($quiz->course->title ?? $quiz->course->name ?? 'Unknown Course'); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-user-tie text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Created By</p>
                            <p class="text-white"><?php echo e($quiz->creator->username ?? 'Unknown Teacher'); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-trophy text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Passing Score</p>
                            <p class="text-white"><?php echo e($quiz->passing_score ?? '60'); ?>%</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-redo-alt text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Attempts Allowed</p>
                            <p class="text-white"><?php echo e($quiz->attempts_allowed ?? 'Unlimited'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Navigation -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-map-marker-alt mr-2"></i> Question Navigator
            </div>
            <div class="section-content">
                <div class="grid grid-cols-5 gap-3">
                    <?php for($i = 1; $i <= count($quiz->questions); $i++): ?>
                        <button type="button" class="question-nav-btn w-10 h-10 rounded-lg bg-gray-700 text-white font-medium flex items-center justify-center hover:bg-gray-600 transition-all duration-200 transform hover:scale-110 shadow-md <?php echo e($i === 1 ? 'active bg-primary-600 hover:bg-primary-700 ring-2 ring-primary-400' : ''); ?>" data-question="<?php echo e($i); ?>">
                            <?php echo e($i); ?>

                        </button>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quiz navigation
        const questions = document.querySelectorAll('.question-card');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const currentQuestionSpan = document.getElementById('current-question');
        const navBtns = document.querySelectorAll('.question-nav-btn');
        const submitBtn = document.getElementById('submit-quiz');

        let currentQuestion = 1;
        const totalQuestions = questions.length;

        // Show only the first question initially
        showQuestion(currentQuestion);

        // Handle next button click
        nextBtn.addEventListener('click', function() {
            if (currentQuestion < totalQuestions) {
                currentQuestion++;
                showQuestion(currentQuestion);
                // Add animation effect
                animateQuestionChange();
            }
        });

        // Handle previous button click
        prevBtn.addEventListener('click', function() {
            if (currentQuestion > 1) {
                currentQuestion--;
                showQuestion(currentQuestion);
                // Add animation effect
                animateQuestionChange();
            }
        });

        // Handle navigation buttons
        navBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                currentQuestion = parseInt(this.dataset.question);
                showQuestion(currentQuestion);
                // Add animation effect
                animateQuestionChange();
            });
        });

        // Function to show a specific question
        function showQuestion(questionNumber) {
            // Hide all questions
            questions.forEach(q => q.style.display = 'none');

            // Show the current question
            document.getElementById(`question-${questionNumber}`).style.display = 'block';

            // Update current question display
            currentQuestionSpan.textContent = questionNumber;

            // Update button states
            prevBtn.disabled = questionNumber === 1;
            nextBtn.disabled = questionNumber === totalQuestions;

            // Update navigation buttons
            navBtns.forEach(btn => {
                btn.classList.remove('active', 'bg-primary-600', 'hover:bg-primary-700', 'ring-2', 'ring-primary-400');
                btn.classList.add('bg-gray-700', 'hover:bg-gray-600');
            });

            navBtns[questionNumber - 1].classList.add('active', 'bg-primary-600', 'hover:bg-primary-700', 'ring-2', 'ring-primary-400');
            navBtns[questionNumber - 1].classList.remove('bg-gray-700', 'hover:bg-gray-600');

            // Update progress indicator
            updateProgressIndicator(questionNumber, totalQuestions);
        }

        // Function to animate question change
        function animateQuestionChange() {
            const activeQuestion = document.getElementById(`question-${currentQuestion}`);
            activeQuestion.classList.add('opacity-0');
            setTimeout(() => {
                activeQuestion.classList.remove('opacity-0');
                activeQuestion.classList.add('animate-fadeIn');
                setTimeout(() => {
                    activeQuestion.classList.remove('animate-fadeIn');
                }, 500);
            }, 50);
        }

        // Function to update progress indicator
        function updateProgressIndicator(current, total) {
            const progress = (current / total) * 100;
            // You could add a progress bar here if desired
        }

        // Quiz timer
        const timerDisplay = document.getElementById('timer-display');
        const minutesDisplay = document.getElementById('minutes');
        const secondsDisplay = document.getElementById('seconds');

        let duration = <?php echo e($quiz->duration ?? 30); ?> * 60; // Convert minutes to seconds
        let timer = duration;

        // Update timer every second
        const interval = setInterval(function() {
            const minutes = parseInt(timer / 60, 10);
            const seconds = parseInt(timer % 60, 10);

            minutesDisplay.textContent = minutes < 10 ? "0" + minutes : minutes;
            secondsDisplay.textContent = seconds < 10 ? "0" + seconds : seconds;

            if (--timer < 0) {
                clearInterval(interval);
                // Use a nicer modal instead of alert
                showTimeUpModal();
            }

            // Change color when less than 5 minutes remaining
            if (timer < 300) {
                timerDisplay.classList.add('text-red-500', 'animate-pulse');
                timerDisplay.classList.remove('text-white');
            }

            // Add warning when less than 1 minute
            if (timer < 60) {
                timerDisplay.classList.add('bg-red-900');
            }
        }, 1000);

        // Function to show time up modal
        function showTimeUpModal() {
            // Create modal overlay
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';

            // Create modal content
            const modal = document.createElement('div');
            modal.className = 'bg-gray-800 rounded-xl p-6 max-w-md mx-auto shadow-2xl border border-red-500 animate-scaleIn';

            modal.innerHTML = `
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-900 mb-4">
                        <i class="fas fa-clock text-red-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Time's Up!</h3>
                    <p class="text-gray-300 mb-6">Your quiz will be submitted automatically.</p>
                    <div class="animate-spin inline-block w-8 h-8 border-4 border-primary-500 border-t-transparent rounded-full mb-4"></div>
                </div>
            `;

            // Add to DOM
            overlay.appendChild(modal);
            document.body.appendChild(overlay);

            // Submit form after delay
            setTimeout(() => {
                document.getElementById('quizForm').submit();
            }, 2000);
        }

        // Form submission confirmation with custom modal
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Create modal overlay
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';

            // Create modal content
            const modal = document.createElement('div');
            modal.className = 'bg-gray-800 rounded-xl p-6 max-w-md mx-auto shadow-2xl border border-primary-500 animate-scaleIn';

            modal.innerHTML = `
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                        <i class="fas fa-question-circle text-primary-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Submit Quiz?</h3>
                    <p class="text-gray-300">Are you sure you want to submit your quiz? You cannot change your answers after submission.</p>
                </div>
                <div class="flex space-x-4">
                    <button id="cancel-submit" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button id="confirm-submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                        Submit Quiz
                    </button>
                </div>
            `;

            // Add to DOM
            overlay.appendChild(modal);
            document.body.appendChild(overlay);

            // Handle cancel
            document.getElementById('cancel-submit').addEventListener('click', function() {
                document.body.removeChild(overlay);
            });

            // Handle confirm
            document.getElementById('confirm-submit').addEventListener('click', function() {
                // Show loading state
                this.innerHTML = '<span class="inline-block animate-spin mr-2"><i class="fas fa-circle-notch"></i></span> Submitting...';
                this.disabled = true;
                document.getElementById('cancel-submit').disabled = true;

                // Submit the form
                document.getElementById('quizForm').submit();
            });
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scaleIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-in-out;
    }

    .animate-scaleIn {
        animation: scaleIn 0.3s ease-out;
    }

    .question-card {
        transition: opacity 0.2s ease-in-out;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/quiz-new.blade.php ENDPATH**/ ?>