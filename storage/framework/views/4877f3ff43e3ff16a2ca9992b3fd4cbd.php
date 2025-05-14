<?php $__env->startSection('title', 'Face Registration'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Banner -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Face Registration</h1>
            <p class="text-blue-100">Register your face to enable secure identity verification during exams</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Registration Process -->
<div class="section-card mb-8">
    <div class="section-header">
        <i class="fas fa-user-shield mr-2"></i> Secure Exam Registration
    </div>
    <div class="section-content">
        <!-- Steps Indicator -->
        <div class="flex justify-between items-center mb-8 relative">
            <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-700 -z-10 transform -translate-y-1/2"></div>

            <div class="flex flex-col items-center" id="step1">
                <div class="w-12 h-12 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold text-lg mb-2 shadow-lg border-2 border-primary-500 active-step">1</div>
                <div class="text-white font-medium">Setup</div>
            </div>

            <div class="flex flex-col items-center" id="step2">
                <div class="w-12 h-12 rounded-full bg-gray-700 text-gray-300 flex items-center justify-center font-bold text-lg mb-2 border-2 border-gray-600">2</div>
                <div class="text-gray-400">Capture</div>
            </div>

            <div class="flex flex-col items-center" id="step3">
                <div class="w-12 h-12 rounded-full bg-gray-700 text-gray-300 flex items-center justify-center font-bold text-lg mb-2 border-2 border-gray-600">3</div>
                <div class="text-gray-400">Confirm</div>
            </div>
        </div>

        <!-- Step Content Container -->
        <div>
            <!-- Step 1: Setup -->
            <div id="step1-content" class="step-content">
                <div class="bg-primary-900/30 border-l-4 border-primary-500 p-5 mb-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-primary-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-white font-medium">
                                Before we begin, please ensure you are in a well-lit environment and your face is clearly visible.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg p-6 mb-8 shadow-md">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Requirements for Face Registration
                    </h3>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 mt-1 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Good lighting on your face
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 mt-1 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Clear background
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 mt-1 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Remove glasses, hats, or other face coverings
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 mt-1 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Position your face in the center of the frame
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-400 mt-1 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Maintain a neutral expression
                        </li>
                    </ul>
                </div>

                <div class="mt-8 flex justify-center">
                    <button id="start-camera-btn" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        Start Camera
                    </button>
                </div>
            </div>

            <!-- Step 2: Capture -->
            <div id="step2-content" class="step-content hidden">
                <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="relative w-full max-w-2xl mx-auto mb-6">
                        <div class="relative w-full rounded-xl overflow-hidden border-4 border-gray-700 transition-all duration-300" id="video-container">
                            <div class="aspect-w-4 aspect-h-3 bg-black">
                                <video id="face-video" class="w-full h-full object-cover" autoplay muted playsinline></video>
                                <canvas id="face-canvas" class="absolute inset-0 w-full h-full"></canvas>
                            </div>

                            <!-- Face detection overlay -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-30">
                                <svg width="300" height="300" viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M150 20C150 8.954 158.954 0 170 0H280C291.046 0 300 8.954 300 20V130C300 141.046 291.046 150 280 150V150" stroke="white" stroke-width="4"/>
                                    <path d="M150 280C150 291.046 158.954 300 170 300H280C291.046 300 300 291.046 300 280V170C300 158.954 291.046 150 280 150V150" stroke="white" stroke-width="4"/>
                                    <path d="M150 20C150 8.954 141.046 0 130 0H20C8.954 0 0 8.954 0 20V130C0 141.046 8.954 150 20 150V150" stroke="white" stroke-width="4"/>
                                    <path d="M150 280C150 291.046 141.046 300 130 300H20C8.954 300 0 291.046 0 280V170C0 158.954 8.954 150 20 150V150" stroke="white" stroke-width="4"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div id="face-status" class="bg-primary-900/30 text-primary-300 p-4 rounded-lg mb-6 text-center font-medium flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Camera starting...
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button id="capture-btn" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center shadow-md disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Capture Face
                        </button>
                        <button id="retry-btn" class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Retry
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Confirm -->
            <div id="step3-content" class="step-content hidden">
                <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
                    <div class="text-center mb-8">
                        <div class="inline-block w-40 h-40 rounded-full overflow-hidden border-4 border-primary-500 mb-6 shadow-lg">
                            <img id="captured-face" class="w-full h-full object-cover" src="" alt="Captured face">
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Face Captured Successfully</h3>
                        <p class="text-gray-300">Your face image is ready for registration</p>
                    </div>

                    <div class="bg-green-900/30 border-l-4 border-green-500 p-5 mb-8 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-green-300 font-medium">
                                    Your face has been captured. Please confirm to complete the registration.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        <button id="back-to-capture-btn" class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Retake Photo
                        </button>
                        <button id="register-btn" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Confirm & Register
                        </button>
                    </div>
                </div>
            </div>

            <!-- Registration Complete -->
            <div id="registration-complete" class="step-content hidden">
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-900/50 mb-8 shadow-md border-4 border-green-600">
                        <svg class="h-14 w-14 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-4">Registration Complete!</h3>
                    <p class="text-gray-300 text-lg mb-8 max-w-md mx-auto">Your face has been successfully registered for secure exams. You're now ready to take secure exams with facial verification.</p>
                    <a href="<?php echo e(route('student.dashboard')); ?>" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 inline-flex items-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        Return to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styles for face recognition page */
    .pulse-animation {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(234, 179, 8, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(234, 179, 8, 0);
        }
    }

    /* Fix for aspect ratio */
    .aspect-w-4 {
        position: relative;
        padding-bottom: 75%;
    }

    .aspect-h-3 {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/face-api/face-api.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/face-recognition.js')); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        // Elements
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const step1Content = document.getElementById('step1-content');
        const step2Content = document.getElementById('step2-content');
        const step3Content = document.getElementById('step3-content');
        const registrationComplete = document.getElementById('registration-complete');
        const startCameraBtn = document.getElementById('start-camera-btn');
        const captureBtn = document.getElementById('capture-btn');
        const retryBtn = document.getElementById('retry-btn');
        const backToCaptureBtn = document.getElementById('back-to-capture-btn');
        const registerBtn = document.getElementById('register-btn');
        const videoEl = document.getElementById('face-video');
        const capturedFaceImg = document.getElementById('captured-face');

        // Initialize face recognition
        await faceRecognition.init();

        // Initialize canvas
        const canvasEl = document.getElementById('face-canvas');
        if (canvasEl) {
            canvasEl.width = 640;
            canvasEl.height = 480;
        }

        // Variables
        let capturedDescriptor = null;
        let capturedImage = null;

        // Start camera button
        startCameraBtn.addEventListener('click', async function() {
            // Show step 2
            const step1Circle = step1.querySelector('div:first-child');
            step1Circle.classList.remove('bg-primary-600', 'text-white', 'border-primary-500');
            step1Circle.classList.add('bg-green-600', 'border-green-500');

            const step2Circle = step2.querySelector('div:first-child');
            step2Circle.classList.remove('bg-gray-700', 'text-gray-300', 'border-gray-600');
            step2Circle.classList.add('bg-primary-600', 'text-white', 'border-primary-500', 'shadow-lg');
            step2.querySelector('div:last-child').classList.remove('text-gray-400');
            step2.querySelector('div:last-child').classList.add('text-white', 'font-medium');

            step1Content.classList.add('hidden');
            step2Content.classList.remove('hidden');

            // Start camera
            const cameraStarted = await faceRecognition.startVideo();
            if (cameraStarted) {
                captureBtn.disabled = false;
                document.getElementById('video-container').classList.add('border-primary-500');

                // Update status
                const statusEl = document.getElementById('face-status');
                statusEl.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Camera ready. Position your face in the center.
                `;
                statusEl.classList.remove('bg-primary-900/30', 'text-primary-300');
                statusEl.classList.add('bg-green-900/30', 'text-green-300');
            }
        });

        captureBtn.addEventListener('click', async function() {
            // Show capturing status
            const statusEl = document.getElementById('face-status');
            statusEl.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Capturing your face...
            `;
            statusEl.classList.remove('bg-green-900/30', 'text-green-300');
            statusEl.classList.add('bg-primary-900/30', 'text-primary-300');
            captureBtn.disabled = true;

            // Add animation effect
            const videoContainer = document.getElementById('video-container');
            videoContainer.classList.add('pulse-animation');
            videoContainer.classList.add('border-yellow-500');
            videoContainer.classList.remove('border-primary-500');

            // Capture face with slight delay for visual effect
            setTimeout(async () => {
                const descriptor = await faceRecognition.captureFace();

                if (descriptor) {
                    capturedDescriptor = descriptor;

                    // Capture image from video
                    const canvas = document.createElement('canvas');
                    canvas.width = videoEl.videoWidth;
                    canvas.height = videoEl.videoHeight;
                    canvas.getContext('2d').drawImage(videoEl, 0, 0);
                    capturedImage = canvas.toDataURL('image/png');

                    // Display captured image
                    capturedFaceImg.src = capturedImage;

                    // Show success status
                    statusEl.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Face captured successfully!
                    `;
                    statusEl.classList.remove('bg-primary-900/30', 'text-primary-300');
                    statusEl.classList.add('bg-green-900/30', 'text-green-300');

                    // Add success class to video container
                    videoContainer.classList.remove('pulse-animation', 'border-yellow-500');
                    videoContainer.classList.add('border-green-500');

                    // Show step 3 with slight delay for visual effect
                    setTimeout(() => {
                        // Update step indicators
                        const step2Circle = step2.querySelector('div:first-child');
                        step2Circle.classList.remove('bg-primary-600', 'border-primary-500');
                        step2Circle.classList.add('bg-green-600', 'border-green-500');

                        const step3Circle = step3.querySelector('div:first-child');
                        step3Circle.classList.remove('bg-gray-700', 'text-gray-300', 'border-gray-600');
                        step3Circle.classList.add('bg-primary-600', 'text-white', 'border-primary-500', 'shadow-lg');
                        step3.querySelector('div:last-child').classList.remove('text-gray-400');
                        step3.querySelector('div:last-child').classList.add('text-white', 'font-medium');

                        // Show step 3 content
                        step2Content.classList.add('hidden');
                        step3Content.classList.remove('hidden');
                    }, 1000);
                } else {
                    // Show error status
                    statusEl.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Failed to capture face. Please try again.
                    `;
                    statusEl.classList.remove('bg-primary-900/30', 'text-primary-300');
                    statusEl.classList.add('bg-red-900/30', 'text-red-300');
                    captureBtn.disabled = false;
                    videoContainer.classList.remove('pulse-animation', 'border-yellow-500');
                    videoContainer.classList.add('border-red-500');
                }
            }, 1500);
        });

        retryBtn.addEventListener('click', function() {
            // Reset and retry capture
            const canvas = document.getElementById('face-canvas');
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

            // Reset status
            const statusEl = document.getElementById('face-status');
            statusEl.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Camera ready. Position your face in the center.
            `;
            statusEl.classList.remove('bg-red-900/30', 'text-red-300');
            statusEl.classList.add('bg-green-900/30', 'text-green-300');

            // Reset video container
            const videoContainer = document.getElementById('video-container');
            videoContainer.classList.remove('pulse-animation', 'border-red-500', 'border-yellow-500', 'border-green-500');
            videoContainer.classList.add('border-primary-500');

            // Enable capture button
            captureBtn.disabled = false;
        });

        backToCaptureBtn.addEventListener('click', function() {
            // Go back to step 2
            const step3Circle = step3.querySelector('div:first-child');
            step3Circle.classList.remove('bg-primary-600', 'text-white', 'border-primary-500', 'shadow-lg');
            step3Circle.classList.add('bg-gray-700', 'text-gray-300', 'border-gray-600');
            step3.querySelector('div:last-child').classList.remove('text-white', 'font-medium');
            step3.querySelector('div:last-child').classList.add('text-gray-400');

            const step2Circle = step2.querySelector('div:first-child');
            step2Circle.classList.remove('bg-green-600', 'border-green-500');
            step2Circle.classList.add('bg-primary-600', 'text-white', 'border-primary-500', 'shadow-lg');

            step3Content.classList.add('hidden');
            step2Content.classList.remove('hidden');
        });

        registerBtn.addEventListener('click', async function() {
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Registering...';

            try {
                // Create loading overlay
                const loadingOverlay = document.createElement('div');
                loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50';
                loadingOverlay.innerHTML = `
                    <div class="bg-gray-800 p-6 rounded-xl shadow-xl max-w-sm w-full border border-gray-700">
                        <div class="flex items-center justify-center mb-4">
                            <svg class="animate-spin h-12 w-12 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <p class="text-center text-white font-medium">Registering your face data...</p>
                        <p class="text-center text-gray-400 text-sm mt-2">This may take a few moments</p>
                    </div>
                `;
                document.body.appendChild(loadingOverlay);

                // Send data to server
                const response = await fetch('<?php echo e(route("face.register.post")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        face_descriptor: JSON.stringify(Array.from(capturedDescriptor)),
                        face_image: capturedImage
                    })
                });

                const result = await response.json();

                // Remove loading overlay
                document.body.removeChild(loadingOverlay);

                if (result.success) {
                    // Show success animation
                    const successOverlay = document.createElement('div');
                    successOverlay.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50';
                    successOverlay.innerHTML = `
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl max-w-sm w-full text-center border border-gray-700">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-900/50 mb-4 border-2 border-green-500">
                                <svg class="h-10 w-10 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-green-400 font-bold text-xl">Registration Successful!</p>
                        </div>
                    `;
                    document.body.appendChild(successOverlay);

                    // Remove success overlay after 1.5 seconds
                    setTimeout(() => {
                        document.body.removeChild(successOverlay);

                        // Update step indicators
                        const step3Circle = step3.querySelector('div:first-child');
                        step3Circle.classList.remove('bg-primary-600', 'border-primary-500');
                        step3Circle.classList.add('bg-green-600', 'border-green-500');

                        // Show registration complete
                        step3Content.classList.add('hidden');
                        registrationComplete.classList.remove('hidden');

                        // Stop video
                        faceRecognition.stopVideo();
                    }, 1500);
                } else {
                    // Show error message
                    const errorOverlay = document.createElement('div');
                    errorOverlay.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50';
                    errorOverlay.innerHTML = `
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl max-w-sm w-full border border-gray-700">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="h-12 w-12 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-center text-red-400 font-medium mb-2">Registration Failed</p>
                            <p class="text-center text-gray-300">${result.message || 'An error occurred during registration.'}</p>
                            <div class="mt-4 text-center">
                                <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors" onclick="this.parentNode.parentNode.parentNode.remove()">Close</button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(errorOverlay);

                    registerBtn.disabled = false;
                    registerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> Confirm & Register';
                }
            } catch (error) {
                console.error('Error registering face:', error);

                // Show error message
                const errorOverlay = document.createElement('div');
                errorOverlay.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50';
                errorOverlay.innerHTML = `
                    <div class="bg-gray-800 p-6 rounded-xl shadow-xl max-w-sm w-full border border-gray-700">
                        <div class="flex items-center justify-center mb-4">
                            <svg class="h-12 w-12 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-center text-red-400 font-medium mb-2">Registration Failed</p>
                        <p class="text-center text-gray-300">An error occurred during registration. Please try again.</p>
                        <div class="mt-4 text-center">
                            <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors" onclick="this.parentNode.parentNode.parentNode.remove()">Close</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(errorOverlay);

                registerBtn.disabled = false;
                registerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> Confirm & Register';
            }
        });

        // Check if user already has registered face
        <?php if($hasFaceRegistered): ?>
            registrationComplete.classList.remove('hidden');
            step1Content.classList.add('hidden');

            // Update step indicators
            const step1Circle = step1.querySelector('div:first-child');
            const step2Circle = step2.querySelector('div:first-child');
            const step3Circle = step3.querySelector('div:first-child');

            step1Circle.classList.remove('bg-primary-600', 'text-white', 'border-primary-500');
            step1Circle.classList.add('bg-green-600', 'border-green-500');

            step2Circle.classList.remove('bg-gray-700', 'text-gray-300', 'border-gray-600');
            step2Circle.classList.add('bg-green-600', 'border-green-500');

            step3Circle.classList.remove('bg-gray-700', 'text-gray-300', 'border-gray-600');
            step3Circle.classList.add('bg-green-600', 'border-green-500');
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/face-recognition/student-register.blade.php ENDPATH**/ ?>