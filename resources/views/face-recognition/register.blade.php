@include('components.header')

<div class="bg-gradient-to-b from-blue-50 to-gray-50 min-h-screen py-12">
    <div class="face-registration-container">
        <div class="face-registration-header">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
            </div>
            <h2>Face Registration for Secure Exams</h2>
            <p class="text-gray-600">Register your face to enable secure identity verification during exams</p>
        </div>

        <div class="face-registration-steps">
            <div class="face-registration-step active" id="step1">
                <div class="face-step-number">1</div>
                <div class="face-step-label">Setup</div>
            </div>
            <div class="face-registration-step" id="step2">
                <div class="face-step-number">2</div>
                <div class="face-step-label">Capture</div>
            </div>
            <div class="face-registration-step" id="step3">
                <div class="face-step-number">3</div>
                <div class="face-step-label">Confirm</div>
            </div>
        </div>

        <div class="mt-8">
            <!-- Step 1: Setup -->
            <div id="step1-content" class="step-content">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-5 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-blue-700 font-medium">
                                Before we begin, please ensure you are in a well-lit environment and your face is clearly visible.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="face-instructions">
                    <h3>Requirements for Face Registration</h3>
                    <ul>
                        <li>Good lighting on your face</li>
                        <li>Clear background</li>
                        <li>Remove glasses, hats, or other face coverings</li>
                        <li>Position your face in the center of the frame</li>
                        <li>Maintain a neutral expression</li>
                    </ul>
                </div>

                <div class="mt-8 flex justify-center">
                    <button id="start-camera-btn" class="face-button face-button-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        Start Camera
                    </button>
                </div>
            </div>

            <!-- Step 2: Capture -->
            <div id="step2-content" class="step-content hidden">
                <div class="face-recognition-container">
                    <div class="face-video-container" id="video-container">
                        <video id="face-video" class="face-video" autoplay muted playsinline></video>
                        <canvas id="face-canvas" class="face-canvas"></canvas>
                    </div>

                    <div id="face-status" class="face-status status-info">
                        Camera starting...
                    </div>

                    <div class="face-controls">
                        <button id="capture-btn" class="face-button face-button-primary" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Capture Face
                        </button>
                        <button id="retry-btn" class="face-button face-button-secondary">
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
                <div class="text-center mb-8">
                    <div class="inline-block w-40 h-40 rounded-full overflow-hidden border-4 border-blue-500 mb-6 shadow-lg">
                        <img id="captured-face" class="w-full h-full object-cover" src="" alt="Captured face">
                    </div>
                    <h3 class="text-2xl font-bold text-blue-700 mb-2">Face Captured Successfully</h3>
                    <p class="text-gray-600">Your face image is ready for registration</p>
                </div>

                <div class="bg-green-50 border-l-4 border-green-500 p-5 mb-8 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-green-700 font-medium">
                                Your face has been captured. Please confirm to complete the registration.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button id="back-to-capture-btn" class="face-button face-button-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retake Photo
                    </button>
                    <button id="register-btn" class="face-button face-button-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Confirm & Register
                    </button>
                </div>
            </div>

            <!-- Registration Complete -->
            <div id="registration-complete" class="step-content hidden">
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100 mb-8 shadow-md">
                        <svg class="h-14 w-14 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-green-700 mb-4">Registration Complete!</h3>
                    <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Your face has been successfully registered for secure exams. You're now ready to take secure exams with facial verification.</p>
                    <a href="{{ route('student.dashboard') }}" class="face-button face-button-primary inline-flex items-center">
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

<!-- Scripts -->
<script src="{{ asset('js/face-api/face-api.min.js') }}"></script>
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

        let capturedDescriptor = null;
        let capturedImage = null;

        // Initialize face recognition
        await faceRecognition.init();

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
                document.getElementById('face-status').classList.remove('status-info');
                document.getElementById('face-status').classList.add('status-success');
            }
        });

        captureBtn.addEventListener('click', async function() {
            // Show capturing status
            document.getElementById('face-status').textContent = 'Capturing your face...';
            document.getElementById('face-status').classList.remove('status-success');
            document.getElementById('face-status').classList.add('status-info');
            captureBtn.disabled = true;

            // Add animation effect
            document.getElementById('video-container').classList.add('capturing');

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
                    document.getElementById('face-status').textContent = 'Face captured successfully!';
                    document.getElementById('face-status').classList.remove('status-info');
                    document.getElementById('face-status').classList.add('status-success');

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
                    document.getElementById('face-status').classList.remove('status-info');
                    document.getElementById('face-status').classList.add('status-error');
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
            document.getElementById('face-status').classList.remove('status-error');
            document.getElementById('face-status').classList.add('status-success');

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
                    registerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> Confirm & Register';
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
                registerBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> Confirm & Register';
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
