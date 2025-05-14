<?php $__env->startSection('title', 'Secure Exam Verification'); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/face-recognition.css')); ?>" rel="stylesheet">
<style>
    /* Dark theme styles for face recognition */
    .face-video-container {
        position: relative;
        overflow: hidden;
        aspect-ratio: 4/3;
        background-color: #1f2937;
        border-radius: 0;
    }

    .face-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .face-canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .face-video-container.active {
        border-color: #3b82f6;
    }

    .face-video-container.success {
        border-color: #10b981;
    }

    .face-status {
        background-color: #1f2937;
        color: #e5e7eb;
        border-left: 4px solid #3b82f6;
        padding: 0.75rem 1rem;
        font-weight: 500;
    }

    .status-info {
        background-color: #1f2937;
        color: #93c5fd;
        border-left: 4px solid #3b82f6;
    }

    .status-success {
        background-color: #1f2937;
        color: #6ee7b7;
        border-left: 4px solid #10b981;
    }

    .status-warning {
        background-color: #1f2937;
        color: #fcd34d;
        border-left: 4px solid #f59e0b;
    }

    .status-error {
        background-color: #1f2937;
        color: #fca5a5;
        border-left: 4px solid #ef4444;
    }

    .face-progress {
        background-color: #374151;
        height: 0.25rem;
        overflow: hidden;
    }

    .face-progress-bar {
        background-color: #3b82f6;
        height: 100%;
        transition: width 0.5s ease;
    }

    .face-controls {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    #start-verification-btn, #continue-exam-btn {
        flex: 1;
        height: 2.5rem;
    }

    #start-verification-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .exam-verification-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">Secure Exam Verification</h1>
            <p class="text-blue-300">Your identity will be verified using facial recognition before and during the exam</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Face Recognition Section -->
    <div class="lg:col-span-2">
        <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="mb-4 flex items-start">
                <div class="flex-shrink-0 mr-3">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-yellow-500 text-white">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                </div>
                <div>
                    <h4 class="text-yellow-400 font-semibold mb-1">Important Notice</h4>
                    <p class="text-gray-300">Your face will be verified periodically during the exam. If verification fails multiple times, your exam session may be terminated.</p>
                </div>
            </div>

            <div class="bg-gray-900 rounded-lg overflow-hidden shadow-md">
                <div class="face-video-container">
                    <video id="face-video" class="face-video" autoplay muted playsinline></video>
                    <canvas id="face-canvas" class="face-canvas"></canvas>
                </div>

                <div class="p-4">
                    <div class="text-center mb-4 text-gray-300 text-sm" id="camera-status">Camera started successfully</div>
                    <div class="face-controls">
                        <button id="start-verification-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full transition-colors duration-200 flex items-center justify-center mx-auto w-48">
                            <i class="fas fa-camera mr-2"></i>
                            Start Verification
                        </button>
                        <button id="continue-exam-btn" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-full transition-colors duration-200 flex items-center justify-center mx-auto w-48 hidden">
                            <i class="fas fa-check-circle mr-2"></i>
                            Continue to Exam
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exam Information Section -->
    <div class="lg:col-span-1">
        <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-500 text-white mr-3">
                    <i class="fas fa-info"></i>
                </span>
                <h2 class="text-xl font-bold text-white">Exam Information</h2>
            </div>

            <div class="bg-gray-900 rounded-lg p-4 mb-4">
                <div class="grid grid-cols-1 gap-3">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-500 text-white mr-3">
                            <i class="fas fa-question-circle text-xs"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400">QUIZ</p>
                            <p class="text-white"><?php echo e($quiz->name); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-purple-500 text-white mr-3">
                            <i class="fas fa-book text-xs"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400">COURSE</p>
                            <p class="text-white"><?php echo e($quiz->course->title); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-green-500 text-white mr-3">
                            <i class="fas fa-list-ol text-xs"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400">QUESTIONS</p>
                            <p class="text-white"><?php echo e($quiz->questions->count()); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-500 text-white mr-3">
                            <i class="fas fa-clock text-xs"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400">TIME LIMIT</p>
                            <p class="text-white"><?php echo e($quiz->duration ?? 'No limit'); ?> minutes</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-red-500 text-white mr-3">
                            <i class="fas fa-percent text-xs"></i>
                        </span>
                        <div>
                            <p class="text-xs text-gray-400">PASSING SCORE</p>
                            <p class="text-white"><?php echo e($quiz->passing_score); ?>%</p>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="quiz-id" value="<?php echo e($quiz->id); ?>">
            </div>

            <div class="bg-gray-900 rounded-lg p-4">
                <div class="flex items-center mb-4">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-500 text-white mr-3">
                        <i class="fas fa-exclamation"></i>
                    </span>
                    <h3 class="text-lg font-semibold text-white">Exam Rules</h3>
                </div>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <span class="text-gray-300">Ensure your face remains visible throughout the exam</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <span class="text-gray-300">Do not leave the exam screen until you have completed the exam</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <span class="text-gray-300">No additional persons should be visible in the frame</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <span class="text-gray-300">Maintain good lighting conditions</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <span class="text-gray-300">Periodic identity verification will occur automatically</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-xs"></i>
                        </span>
                        <span class="text-gray-300">Multiple verification failures will terminate your session</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Verification in Progress Modal -->
<div id="verification-modal" class="exam-verification-overlay hidden">
    <div class="max-w-md w-full bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-500 p-3">
            <h3 class="text-lg font-medium text-white flex items-center">
                <i class="fas fa-shield-alt mr-3"></i>
                Identity Verification
            </h3>
        </div>
        <div class="p-6 bg-gray-800">
            <div class="text-center">
                <div class="mx-auto mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500/20">
                        <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <p class="text-lg font-medium mb-3 text-white">Verifying your identity...</p>
                <p class="text-sm text-gray-400 flex items-center justify-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Please keep your face clearly visible
                </p>

                <!-- Progress bar -->
                <div class="mt-6 h-2 w-full bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 animate-pulse" style="width: 75%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/face-api/face-api.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/face-recognition.js')); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        // Elements
        const startVerificationBtn = document.getElementById('start-verification-btn');
        const continueExamBtn = document.getElementById('continue-exam-btn');
        const statusEl = document.getElementById('face-status');
        const progressBar = document.getElementById('face-progress-bar');
        const verificationModal = document.getElementById('verification-modal');

        let verificationComplete = false;

        // Initialize face recognition
        await faceRecognition.init();

        // Start camera
        await faceRecognition.startVideo();

        // Event listeners
        startVerificationBtn.addEventListener('click', async function() {
            startVerificationBtn.disabled = true;
            startVerificationBtn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Verifying...`;

            // Show verification modal
            verificationModal.classList.remove('hidden');

            try {
                // Perform verification
                const result = await verifyIdentity();

                // Hide verification modal
                verificationModal.classList.add('hidden');

                if (result.success) {
                    statusEl.textContent = 'Verification successful!';
                    statusEl.className = 'face-status status-success';
                    progressBar.style.width = '100%';

                    startVerificationBtn.classList.add('hidden');
                    continueExamBtn.classList.remove('hidden');

                    verificationComplete = true;
                } else {
                    statusEl.textContent = 'Verification failed: ' + result.message;
                    statusEl.className = 'face-status status-error';

                    startVerificationBtn.disabled = false;
                    startVerificationBtn.innerHTML = `<i class="fas fa-redo mr-2"></i> Retry Verification`;
                }
            } catch (error) {
                console.error('Error during verification:', error);

                // Hide verification modal
                verificationModal.classList.add('hidden');

                statusEl.textContent = 'An error occurred during verification. Please try again.';
                statusEl.className = 'face-status status-error';

                startVerificationBtn.disabled = false;
                startVerificationBtn.innerHTML = `<i class="fas fa-redo mr-2"></i> Retry Verification`;
            }
        });

        continueExamBtn.addEventListener('click', function() {
            if (verificationComplete) {
                // Start continuous verification
                faceRecognition.startVerification(30, 3);

                // Redirect to exam
                window.location.href = '<?php echo e(route("student.quiz", ["id" => $quiz->id])); ?>';
            }
        });

        // Handle exam termination event
        document.addEventListener('exam-terminated', function(e) {
            alert('Exam session terminated: ' + e.detail.reason);
            window.location.href = '<?php echo e(route("student.dashboard")); ?>';
        });

        // Verify identity against registered face
        async function verifyIdentity() {
            try {
                // Capture face
                const descriptor = await faceRecognition.captureFace();

                if (!descriptor) {
                    return {
                        success: false,
                        message: 'No face detected. Please ensure your face is clearly visible.'
                    };
                }

                // Send to server for verification
                const descriptorArray = Array.from(descriptor);

                const response = await fetch('<?php echo e(route("face.verify")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        face_descriptor: JSON.stringify(descriptorArray)
                    })
                });

                const result = await response.json();
                console.log('Verification result:', result);

                return result;
            } catch (error) {
                console.error('Error verifying identity:', error);
                return {
                    success: false,
                    message: 'An error occurred during verification: ' + error.message
                };
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/secure-exam.blade.php ENDPATH**/ ?>