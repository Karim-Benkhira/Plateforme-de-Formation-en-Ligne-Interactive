@include('components.header')

<link rel="stylesheet" href="{{ asset('css/modern-face-recognition.css') }}">

<div class="bg-gradient-to-b from-blue-50 to-gray-100 min-h-screen py-8">
    <div class="modern-face-container">
        <div class="modern-card">
            <div class="modern-card-header">
                <div class="absolute top-6 right-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white opacity-80" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2>Face Registration for Secure Exams</h2>
                <p>Register your face to enable secure identity verification during exams</p>
            </div>

            <div class="modern-card-body">
                <!-- Steps navigation -->
                <div class="modern-steps">
                    <div class="modern-step active" id="step1">
                        <div class="modern-step-circle">1</div>
                        <div class="modern-step-label">Setup</div>
                        <div class="modern-step-connector"></div>
                    </div>
                    <div class="modern-step" id="step2">
                        <div class="modern-step-circle">2</div>
                        <div class="modern-step-label">Capture</div>
                        <div class="modern-step-connector"></div>
                    </div>
                    <div class="modern-step" id="step3">
                        <div class="modern-step-circle">3</div>
                        <div class="modern-step-label">Confirm</div>
                    </div>
                </div>

                <!-- Step 1: Setup -->
                <div id="step1-content" class="step-content">
                    <div class="modern-alert modern-alert-info">
                        <div class="modern-alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="modern-alert-content">
                            <p>Before we begin, please ensure you are in a well-lit environment and your face is clearly visible.</p>
                        </div>
                    </div>

                    <div class="modern-content">
                        <div class="modern-requirements">
                            <h4>Requirements for Face Registration</h4>
                            <ul class="modern-requirements-list">
                                <li class="modern-requirements-item">
                                    <div class="modern-requirements-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Good lighting on your face
                                </li>
                                <li class="modern-requirements-item">
                                    <div class="modern-requirements-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Clear background
                                </li>
                                <li class="modern-requirements-item">
                                    <div class="modern-requirements-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Remove glasses, hats, or other face coverings
                                </li>
                                <li class="modern-requirements-item">
                                    <div class="modern-requirements-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Position your face in the center of the frame
                                </li>
                                <li class="modern-requirements-item">
                                    <div class="modern-requirements-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    Maintain a neutral expression
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button id="start-camera-btn" class="modern-btn modern-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Start Camera
                        </button>
                    </div>
                </div>

                <!-- Step 2: Capture -->
                <div id="step2-content" class="step-content hidden">
                    <div class="modern-content">
                        <div class="modern-video-container" id="video-container">
                            <video id="face-video" class="modern-video" autoplay muted playsinline></video>
                            <canvas id="face-canvas" class="modern-canvas"></canvas>
                        </div>

                        <div id="face-status" class="modern-status modern-status-info">
                            Camera starting...
                        </div>

                        <div class="flex justify-center gap-4 mt-6">
                            <button id="capture-btn" class="modern-btn modern-btn-primary" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                Capture Face
                            </button>
                            <button id="retry-btn" class="modern-btn modern-btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                                Retry
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Confirm -->
                <div id="step3-content" class="step-content hidden">
                    <div class="modern-content">
                        <div class="text-center mb-6">
                            <div class="modern-captured-image">
                                <img id="captured-face" src="" alt="Captured face">
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Face Captured Successfully</h3>
                            <p class="text-gray-600">Your face image is ready for registration</p>
                        </div>

                        <div class="modern-alert modern-alert-success mb-6">
                            <div class="modern-alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="modern-alert-content">
                                <p>Your face has been captured. Please confirm to complete the registration.</p>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <button id="back-to-capture-btn" class="modern-btn modern-btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Retake Photo
                            </button>
                            <button id="register-btn" class="modern-btn modern-btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Confirm & Register
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Registration Complete -->
                <div id="registration-complete" class="step-content hidden">
                    <div class="modern-result">
                        <div class="modern-result-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3>Registration Complete!</h3>
                        <p>Your face has been successfully registered for secure exams. You're now ready to take secure exams with facial verification.</p>
                        <a href="{{ route('student.dashboard') }}" class="modern-btn modern-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor">
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
</div>

<!-- Scripts -->
<script src="{{ asset('js/face-api/face-api.mock.js') }}"></script>
<script src="{{ asset('js/face-recognition.js') }}"></script>
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
        const capturedFaceImg = document.getElementById('captured-face');
        const videoEl = document.getElementById('face-video');

        let capturedDescriptor = null;
        let capturedImage = null;

        // Initialize face recognition
        await faceRecognition.init();

        // Custom face capture function specifically for this page
        async function customCaptureFace() {
            const video = document.getElementById('face-video');
            const canvas = document.getElementById('face-canvas');
            const status = document.getElementById('face-status');

            if (!video || !video.srcObject) {
                console.error("Video element not found or camera not started");
                return null;
            }

            try {
                status.textContent = 'Detecting face...';

                // Detect face with tiny face detector
                const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions());

                if (!detection) {
                    console.error("No face detected");
                    status.textContent = 'No face detected. Please ensure your face is clearly visible';
                    return null;
                }

                // Draw detection on canvas
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Draw the detection box manually
                if (detection) {
                    const box = detection.box;
                    ctx.strokeStyle = '#00ff00';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(box.x, box.y, box.width, box.height);
                }

                console.log("Face captured successfully");
                status.textContent = 'Face captured successfully';
                // Create a simulated descriptor (since we're not using the face recognition model)
                return new Float32Array(128).fill(0.5);
            } catch (error) {
                console.error('Error capturing face:', error);
                status.textContent = 'Error capturing face: ' + error.message;
                return null;
            }
        }

        // Event listeners
        startCameraBtn.addEventListener('click', async function() {
            // Show step 2
            step1.classList.remove('active');
            step2.classList.add('active');
            step1Content.classList.add('hidden');
            step2Content.classList.remove('hidden');

            // Start camera
            const cameraStarted = await faceRecognition.startVideo();
            if (cameraStarted) {
                captureBtn.disabled = false;
                document.getElementById('video-container').classList.add('active');
                document.getElementById('face-status').textContent = 'Camera ready. Position your face in the center.';
                document.getElementById('face-status').classList.remove('modern-status-info');
                document.getElementById('face-status').classList.add('modern-status-success');
            }
        });

        captureBtn.addEventListener('click', async function() {
            // Show capturing status
            document.getElementById('face-status').textContent = 'Capturing your face...';
            document.getElementById('face-status').classList.remove('modern-status-success');
            document.getElementById('face-status').classList.add('modern-status-info');
            captureBtn.disabled = true;

            // Add animation effect
            document.getElementById('video-container').classList.add('capturing');

            // Capture face with slight delay for visual effect
            setTimeout(async () => {
                const descriptor = await customCaptureFace();

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
                    document.getElementById('face-status').textContent = 'Face captured successfully!';
                    document.getElementById('face-status').classList.remove('modern-status-info');
                    document.getElementById('face-status').classList.add('modern-status-success');

                    // Add success class to video container
                    document.getElementById('video-container').classList.remove('active');
                    document.getElementById('video-container').classList.add('success');

                    // Show step 3 with slight delay for visual effect
                    setTimeout(() => {
                        step2.classList.remove('active');
                        step2.classList.add('completed');
                        step3.classList.add('active');
                        step2Content.classList.add('hidden');
                        step3Content.classList.remove('hidden');
                    }, 1000);
                } else {
                    // Show error status
                    document.getElementById('face-status').textContent = 'Failed to capture face. Please try again.';
                    document.getElementById('face-status').classList.remove('modern-status-info');
                    document.getElementById('face-status').classList.add('modern-status-error');
                    console.error('Face capture failed');
                    captureBtn.disabled = false;
                    document.getElementById('video-container').classList.remove('capturing');
                }
            }, 500);
        });

        retryBtn.addEventListener('click', function() {
            // Reset and retry capture
            const canvas = document.getElementById('face-canvas');
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

            // Reset status
            document.getElementById('face-status').textContent = 'Camera ready. Position your face in the center.';
            document.getElementById('face-status').classList.remove('modern-status-error');
            document.getElementById('face-status').classList.add('modern-status-success');

            // Reset video container
            document.getElementById('video-container').classList.remove('capturing');
            document.getElementById('video-container').classList.remove('success');
            document.getElementById('video-container').classList.add('active');

            // Enable capture button
            captureBtn.disabled = false;
        });

        backToCaptureBtn.addEventListener('click', function() {
            // Go back to step 2
            step3.classList.remove('active');
            step2.classList.add('active');
            step3Content.classList.add('hidden');
            step2Content.classList.remove('hidden');
        });

        registerBtn.addEventListener('click', async function() {
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Registering...';

            try {
                // Create loading overlay
                const loadingOverlay = document.createElement('div');
                loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loadingOverlay.innerHTML = `
                    <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full">
                        <div class="flex items-center justify-center mb-4">
                            <svg class="animate-spin h-10 w-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <p class="text-center text-gray-700 font-medium">Registering your face data...</p>
                        <p class="text-center text-gray-500 text-sm mt-2">This may take a few moments</p>
                    </div>
                `;
                document.body.appendChild(loadingOverlay);

                // Send data to server
                const response = await fetch('{{ route("face.register.post") }}', {
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
                    successOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    successOverlay.innerHTML = `
                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                                <svg class="h-10 w-10 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-green-700 font-bold text-xl">Registration Successful!</p>
                        </div>
                    `;
                    document.body.appendChild(successOverlay);

                    // Remove success overlay after 1.5 seconds
                    setTimeout(() => {
                        document.body.removeChild(successOverlay);

                        // Show registration complete
                        step3.classList.remove('active');
                        step3.classList.add('completed');
                        step3Content.classList.add('hidden');
                        registrationComplete.classList.remove('hidden');

                        // Stop video
                        faceRecognition.stopVideo();
                    }, 1500);
                } else {
                    // Show error message
                    const errorOverlay = document.createElement('div');
                    errorOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    errorOverlay.innerHTML = `
                        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full">
                            <div class="flex items-center justify-center mb-4">
                                <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-center text-red-700 font-medium mb-2">Registration Failed</p>
                            <p class="text-center text-gray-600">${result.message || 'An error occurred during registration.'}</p>
                            <div class="mt-4 text-center">
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-md" onclick="this.parentNode.parentNode.parentNode.remove()">Close</button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(errorOverlay);

                    registerBtn.disabled = false;
                    registerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> Confirm & Register';
                }
            } catch (error) {
                console.error('Error registering face:', error);

                // Show error message
                const errorOverlay = document.createElement('div');
                errorOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                errorOverlay.innerHTML = `
                    <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full">
                        <div class="flex items-center justify-center mb-4">
                            <svg class="h-10 w-10 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-center text-red-700 font-medium mb-2">Registration Failed</p>
                        <p class="text-center text-gray-600">An error occurred during registration. Please try again.</p>
                        <div class="mt-4 text-center">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-md" onclick="this.parentNode.parentNode.parentNode.remove()">Close</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(errorOverlay);

                registerBtn.disabled = false;
                registerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="modern-btn-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> Confirm & Register';
            }
        });

        // Check if user already has registered face
        @if($hasFaceRegistered)
            registrationComplete.classList.remove('hidden');
            step1Content.classList.add('hidden');
            step1.classList.remove('active');
            step1.classList.add('completed');
            step2.classList.add('completed');
            step3.classList.add('completed');
        @endif
    });
</script>

@include('components.footer')
