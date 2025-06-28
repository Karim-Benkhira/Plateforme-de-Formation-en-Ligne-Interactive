@extends('layouts.student')

@section('title', 'Face Verification - ' . $quiz->name)

@push('styles')
<style>
    .verification-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .camera-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        border-radius: 12px;
        overflow: hidden;
        background: #1f2937;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }
    
    .camera-video {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .face-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
        border: 3px solid rgba(79, 70, 229, 0.8);
        border-radius: 50%;
        pointer-events: none;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(79, 70, 229, 0); }
        100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
    }
    
    .verification-status {
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
        font-weight: 500;
        text-align: center;
    }
    
    .status-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #3b82f6;
    }
    
    .status-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #10b981;
    }
    
    .status-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #ef4444;
    }
    
    .status-warning {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b;
    }
    
    .progress-bar {
        width: 100%;
        height: 6px;
        background: rgba(75, 85, 99, 0.3);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
        border-radius: 3px;
        transition: width 0.3s ease;
        width: 0%;
    }
    
    .verification-steps {
        display: flex;
        justify-content: space-between;
        margin: 2rem 0;
    }
    
    .step {
        flex: 1;
        text-align: center;
        padding: 0 1rem;
        position: relative;
    }
    
    .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 1rem;
        right: -50%;
        width: 100%;
        height: 2px;
        background: rgba(75, 85, 99, 0.3);
        z-index: 1;
    }
    
    .step.active:not(:last-child)::after {
        background: #4f46e5;
    }
    
    .step-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: rgba(75, 85, 99, 0.3);
        color: #9ca3af;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .step.active .step-icon {
        background: #4f46e5;
        color: white;
    }
    
    .step.completed .step-icon {
        background: #10b981;
        color: white;
    }
    
    .hidden {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="verification-container">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-4">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Face Verification Required
            </h1>
            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                Please verify your identity before accessing the secure exam: <strong>{{ $quiz->name }}</strong>
            </p>
        </div>

        <!-- Verification Steps -->
        <div class="verification-steps">
            <div class="step active" id="step-1">
                <div class="step-icon">
                    <i class="fas fa-camera text-sm"></i>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Start Camera</div>
            </div>
            <div class="step" id="step-2">
                <div class="step-icon">
                    <i class="fas fa-user text-sm"></i>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Position Face</div>
            </div>
            <div class="step" id="step-3">
                <div class="step-icon">
                    <i class="fas fa-check text-sm"></i>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Verify Identity</div>
            </div>
        </div>

        <!-- Main Verification Interface -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <!-- Camera Section -->
            <div class="text-center mb-6">
                <div class="camera-container mb-4">
                    <video id="camera-video" class="camera-video" autoplay muted playsinline></video>
                    <div class="face-overlay"></div>
                    <canvas id="capture-canvas" class="hidden"></canvas>
                </div>
                
                <!-- Status Display -->
                <div id="verification-status" class="verification-status status-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Click "Start Camera" to begin face verification
                </div>
                
                <!-- Progress Bar -->
                <div class="progress-bar mb-4">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
                
                <!-- Controls -->
                <div id="verification-controls" class="space-y-3">
                    <button id="start-camera-btn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-video mr-2"></i>
                        Start Camera
                    </button>
                    
                    <button id="verify-btn" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 hidden">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Verify Identity
                    </button>
                    
                    <button id="retry-btn" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors duration-200 hidden">
                        <i class="fas fa-redo mr-2"></i>
                        Try Again
                    </button>
                    
                    <button id="continue-exam-btn" class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 hidden">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Continue to Exam
                    </button>
                </div>
            </div>
        </div>

        <!-- Exam Information -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                Exam Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-clock text-blue-600 mr-2"></i>
                    <span class="text-blue-800 dark:text-blue-200">Duration: {{ $quiz->duration }} minutes</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-percentage text-blue-600 mr-2"></i>
                    <span class="text-blue-800 dark:text-blue-200">Passing Score: {{ $quiz->passing_score }}%</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-question-circle text-blue-600 mr-2"></i>
                    <span class="text-blue-800 dark:text-blue-200">Questions: {{ $quiz->questions->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Guidelines -->
        <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <h4 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Verification Guidelines
            </h4>
            <ul class="text-yellow-800 dark:text-yellow-200 text-sm space-y-1">
                <li>• Ensure your face is clearly visible and well-lit</li>
                <li>• Look directly at the camera</li>
                <li>• Remove sunglasses, hats, or face coverings</li>
                <li>• Position your face within the circle overlay</li>
                <li>• Stay still during the verification process</li>
            </ul>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm w-full mx-4">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Verifying Identity</h3>
            <p class="text-gray-600 dark:text-gray-400">Please wait while we verify your face...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const startCameraBtn = document.getElementById('start-camera-btn');
    const verifyBtn = document.getElementById('verify-btn');
    const retryBtn = document.getElementById('retry-btn');
    const continueExamBtn = document.getElementById('continue-exam-btn');
    const cameraVideo = document.getElementById('camera-video');
    const captureCanvas = document.getElementById('capture-canvas');
    const verificationStatus = document.getElementById('verification-status');
    const progressFill = document.getElementById('progress-fill');
    const loadingModal = document.getElementById('loading-modal');

    // Steps
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const step3 = document.getElementById('step-3');

    let stream = null;
    let verificationComplete = false;

    // Event listeners
    startCameraBtn.addEventListener('click', startCamera);
    verifyBtn.addEventListener('click', verifyIdentity);
    retryBtn.addEventListener('click', retryVerification);
    continueExamBtn.addEventListener('click', continueToExam);

    async function startCamera() {
        try {
            updateStatus('Starting camera...', 'info');
            updateProgress(25);

            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user'
                }
            });

            cameraVideo.srcObject = stream;

            // Wait for video to load
            cameraVideo.onloadedmetadata = function() {
                updateStatus('Position your face within the circle', 'info');
                updateProgress(50);
                updateStep(2);

                startCameraBtn.classList.add('hidden');
                verifyBtn.classList.remove('hidden');
            };

        } catch (error) {
            console.error('Error accessing camera:', error);
            updateStatus('Unable to access camera. Please check permissions and try again.', 'error');
            updateProgress(0);
        }
    }

    async function verifyIdentity() {
        try {
            updateStatus('Capturing image...', 'info');
            updateProgress(75);
            showLoadingModal();

            // Capture image from video
            const context = captureCanvas.getContext('2d');
            captureCanvas.width = cameraVideo.videoWidth;
            captureCanvas.height = cameraVideo.videoHeight;
            context.drawImage(cameraVideo, 0, 0);

            // Convert to base64
            const imageData = captureCanvas.toDataURL('image/jpeg', 0.8);

            // Send to server for verification
            const response = await fetch('{{ route("face-verification.verify-exam") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quiz_id: {{ $quiz->id }},
                    captured_image: imageData
                })
            });

            const result = await response.json();
            hideLoadingModal();

            if (result.success) {
                updateStatus('Identity verified successfully!', 'success');
                updateProgress(100);
                updateStep(3);

                verifyBtn.classList.add('hidden');
                continueExamBtn.classList.remove('hidden');
                verificationComplete = true;

                // Stop camera
                stopCamera();

            } else {
                updateStatus('Verification failed: ' + result.message, 'error');
                updateProgress(50);

                verifyBtn.classList.add('hidden');
                retryBtn.classList.remove('hidden');
            }

        } catch (error) {
            console.error('Verification error:', error);
            hideLoadingModal();
            updateStatus('An error occurred during verification. Please try again.', 'error');
            updateProgress(50);

            verifyBtn.classList.add('hidden');
            retryBtn.classList.remove('hidden');
        }
    }

    function retryVerification() {
        updateStatus('Position your face within the circle', 'info');
        updateProgress(50);
        updateStep(2);

        retryBtn.classList.add('hidden');
        verifyBtn.classList.remove('hidden');
    }

    function continueToExam() {
        if (verificationComplete) {
            window.location.href = '{{ route("student.quiz", $quiz->id) }}';
        }
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }

    function updateStatus(message, type) {
        verificationStatus.className = `verification-status status-${type}`;

        let icon = 'fas fa-info-circle';
        if (type === 'success') icon = 'fas fa-check-circle';
        else if (type === 'error') icon = 'fas fa-exclamation-circle';
        else if (type === 'warning') icon = 'fas fa-exclamation-triangle';

        verificationStatus.innerHTML = `<i class="${icon} mr-2"></i>${message}`;
    }

    function updateProgress(percentage) {
        progressFill.style.width = percentage + '%';
    }

    function updateStep(stepNumber) {
        // Reset all steps
        [step1, step2, step3].forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index + 1 < stepNumber) {
                step.classList.add('completed');
            } else if (index + 1 === stepNumber) {
                step.classList.add('active');
            }
        });
    }

    function showLoadingModal() {
        loadingModal.classList.remove('hidden');
    }

    function hideLoadingModal() {
        loadingModal.classList.add('hidden');
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', stopCamera);
});
</script>
@endpush
