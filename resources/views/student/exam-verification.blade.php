@extends('layouts.student')

@section('title', 'Face Verification - ' . $quiz->name)

@push('styles')
<style>
    .face-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
        border: 3px solid rgba(59, 130, 246, 0.8);
        border-radius: 50%;
        pointer-events: none;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    .camera-video {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 1rem;
    }

    .verification-step {
        transition: all 0.3s ease;
    }

    .verification-step.active {
        transform: scale(1.05);
    }

    .verification-step.completed {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .verification-step.active:not(.completed) {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .status-indicator {
        transition: all 0.3s ease;
        transform: translateY(0);
    }

    .status-indicator.bounce {
        animation: bounce 0.6s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
        40%, 43% { transform: translateY(-10px); }
        70% { transform: translateY(-5px); }
        90% { transform: translateY(-2px); }
    }

    .progress-bar {
        height: 8px;
        background: rgba(75, 85, 99, 0.2);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        border-radius: 4px;
        transition: width 0.5s ease;
        width: 0%;
    }
</style>
@endpush

@section('content')
<!-- Main Container -->
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full mb-6 shadow-lg">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">
                🔐 Secure Exam Verification
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto mb-2">
                Please verify your identity before accessing the secure exam
            </p>
            <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-6 py-2 text-white">
                <i class="fas fa-graduation-cap mr-2 text-yellow-400"></i>
                <span class="font-semibold">{{ $quiz->name }}</span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="max-w-2xl mx-auto mb-8">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-blue-200">Verification Progress</span>
                <span class="text-sm font-medium text-blue-200" id="progress-text">0%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-bar"></div>
            </div>
        </div>

        <!-- Verification Steps -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Step 1: Start Camera -->
                <div class="verification-step bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 text-center" id="step-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-camera text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Start Camera</h3>
                    <p class="text-gray-400 text-sm">Allow camera access and position yourself</p>
                </div>

                <!-- Step 2: Position Face -->
                <div class="verification-step bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 text-center" id="step-2">
                    <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-400 mb-2">Position Face</h3>
                    <p class="text-gray-500 text-sm">Align your face within the circle</p>
                </div>

                <!-- Step 3: Verify Identity -->
                <div class="verification-step bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50 text-center" id="step-3">
                    <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-400 mb-2">Verify Identity</h3>
                    <p class="text-gray-500 text-sm">Complete face verification process</p>
                </div>
            </div>
        </div>

        <!-- Main Verification Interface -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-gray-700/50 p-8 shadow-2xl">
                <!-- Camera Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Camera Feed -->
                    <div class="text-center">
                        <div class="relative bg-gray-900 rounded-2xl overflow-hidden shadow-xl mb-6">
                            <video id="camera-video" class="camera-video w-full h-auto" autoplay muted playsinline style="min-height: 300px;"></video>
                            <div class="face-overlay"></div>
                            <canvas id="capture-canvas" class="hidden"></canvas>

                            <!-- Camera Status Overlay -->
                            <div class="absolute top-4 left-4 right-4">
                                <div class="bg-black/50 backdrop-blur-sm rounded-lg px-4 py-2 text-white text-sm" id="camera-status">
                                    <i class="fas fa-camera mr-2"></i>
                                    <span>Camera not started</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status and Controls Panel -->
                    <div class="space-y-6">
                        <!-- Current Status -->
                        <div class="bg-gray-900/50 rounded-xl p-6 border border-gray-700/50">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                                Verification Status
                            </h3>

                            <!-- Status Indicator -->
                            <div id="verification-status" class="status-indicator bg-blue-500/20 border border-blue-500/30 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                                    <span class="text-blue-200 font-medium">Click "Start Camera" to begin face verification</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div id="verification-controls" class="space-y-3">
                                <button id="start-camera-btn" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-video mr-2"></i>
                                    Start Camera
                                </button>

                                <button id="verify-btn" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hidden">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    Verify Identity
                                </button>

                                <button id="retry-btn" class="w-full bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hidden">
                                    <i class="fas fa-redo mr-2"></i>
                                    Try Again
                                </button>

                                <button id="continue-exam-btn" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-xl hidden">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Continue to Exam
                                </button>
                            </div>
                        </div>

                        <!-- Exam Information Card -->
                        <div class="bg-gray-900/50 rounded-xl p-6 border border-gray-700/50">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <i class="fas fa-graduation-cap mr-2 text-yellow-400"></i>
                                Exam Details
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">Duration:</span>
                                    <span class="text-white font-medium">{{ $quiz->duration }} minutes</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">Passing Score:</span>
                                    <span class="text-white font-medium">{{ $quiz->passing_score }}%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-400">Questions:</span>
                                    <span class="text-white font-medium">{{ $quiz->questions->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Guidelines Card -->
                        <div class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-amber-200 mb-4 flex items-center">
                                <i class="fas fa-lightbulb mr-2 text-amber-400"></i>
                                Verification Tips
                            </h3>
                            <ul class="text-amber-100 text-sm space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-check text-amber-400 mr-2 mt-0.5 text-xs"></i>
                                    Ensure your face is clearly visible and well-lit
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-amber-400 mr-2 mt-0.5 text-xs"></i>
                                    Look directly at the camera
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-amber-400 mr-2 mt-0.5 text-xs"></i>
                                    Remove sunglasses, hats, or face coverings
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check text-amber-400 mr-2 mt-0.5 text-xs"></i>
                                    Position your face within the circle overlay
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6">
                <svg class="animate-spin h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">🔍 Processing Verification</h3>
            <p class="text-gray-300">Please wait while we verify your identity...</p>
            <div class="mt-4 w-full bg-gray-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
            </div>
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
                updateCameraStatus('Camera active - Position your face', true);
                updateProgress(50);
                updateStep(2);

                startCameraBtn.classList.add('hidden');
                verifyBtn.classList.remove('hidden');
            };

        } catch (error) {
            console.error('Error accessing camera:', error);
            updateStatus('Unable to access camera. Please check permissions and try again.', 'error');
            updateCameraStatus('Camera access denied');
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
        // Update status indicator with new design
        let bgColor, borderColor, textColor, iconColor, icon;

        if (type === 'success') {
            bgColor = 'bg-green-500/20';
            borderColor = 'border-green-500/30';
            textColor = 'text-green-200';
            iconColor = 'bg-green-500';
            icon = 'fas fa-check-circle';
        } else if (type === 'error') {
            bgColor = 'bg-red-500/20';
            borderColor = 'border-red-500/30';
            textColor = 'text-red-200';
            iconColor = 'bg-red-500';
            icon = 'fas fa-exclamation-circle';
        } else if (type === 'warning') {
            bgColor = 'bg-yellow-500/20';
            borderColor = 'border-yellow-500/30';
            textColor = 'text-yellow-200';
            iconColor = 'bg-yellow-500';
            icon = 'fas fa-exclamation-triangle';
        } else {
            bgColor = 'bg-blue-500/20';
            borderColor = 'border-blue-500/30';
            textColor = 'text-blue-200';
            iconColor = 'bg-blue-500';
            icon = 'fas fa-info-circle';
        }

        verificationStatus.className = `status-indicator ${bgColor} border ${borderColor} rounded-lg p-4 mb-4`;
        verificationStatus.innerHTML = `
            <div class="flex items-center">
                <div class="w-3 h-3 ${iconColor} rounded-full mr-3 ${type === 'info' ? 'animate-pulse' : ''}"></div>
                <span class="${textColor} font-medium">${message}</span>
            </div>
        `;

        // Add bounce animation for status changes
        verificationStatus.classList.add('bounce');
        setTimeout(() => verificationStatus.classList.remove('bounce'), 600);

        // Update camera status
        const cameraStatus = document.getElementById('camera-status');
        if (cameraStatus) {
            cameraStatus.innerHTML = `<i class="${icon} mr-2"></i><span>${message}</span>`;
        }

        // Update progress text
        const progressText = document.getElementById('progress-text');
        if (progressText) {
            if (type === 'success') progressText.textContent = '100%';
            else if (type === 'error') progressText.textContent = '50%';
        }
    }

    function updateProgress(percentage) {
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');

        if (progressBar) {
            progressBar.style.width = percentage + '%';
        }
        if (progressText) {
            progressText.textContent = percentage + '%';
        }
    }

    function updateStep(stepNumber) {
        // Update verification steps with new design
        [step1, step2, step3].forEach((step, index) => {
            const stepIcon = step.querySelector('.w-16');
            const stepTitle = step.querySelector('h3');
            const stepDesc = step.querySelector('p');

            if (index + 1 < stepNumber) {
                // Completed step
                step.classList.add('completed');
                step.classList.remove('active');
                stepIcon.className = 'w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4';
                stepTitle.className = 'text-lg font-semibold text-green-400 mb-2';
                stepDesc.className = 'text-green-300 text-sm';
            } else if (index + 1 === stepNumber) {
                // Active step
                step.classList.add('active');
                step.classList.remove('completed');
                stepIcon.className = 'w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4';
                stepTitle.className = 'text-lg font-semibold text-white mb-2';
                stepDesc.className = 'text-gray-300 text-sm';
            } else {
                // Inactive step
                step.classList.remove('active', 'completed');
                stepIcon.className = 'w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4';
                stepTitle.className = 'text-lg font-semibold text-gray-400 mb-2';
                stepDesc.className = 'text-gray-500 text-sm';
            }
        });
    }

    function showLoadingModal() {
        loadingModal.classList.remove('hidden');
    }

    function hideLoadingModal() {
        loadingModal.classList.add('hidden');
    }

    // Initialize camera status
    function updateCameraStatus(message, isActive = false) {
        const cameraStatus = document.getElementById('camera-status');
        if (cameraStatus) {
            const icon = isActive ? 'fas fa-video text-green-400' : 'fas fa-camera text-gray-400';
            cameraStatus.innerHTML = `<i class="${icon} mr-2"></i><span>${message}</span>`;
        }
    }

    // Initialize the page
    updateCameraStatus('Camera not started');
    updateProgress(0);

    // Cleanup on page unload
    window.addEventListener('beforeunload', stopCamera);
});
</script>
@endpush
