@include('components.header')

<div class="bg-gray-50 min-h-screen py-12">
    <div class="face-registration-container">
        <div class="face-registration-header">
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
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
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

                <div class="mt-6 flex justify-end">
                    <button id="start-camera-btn" class="face-button face-button-primary">
                        Start Camera
                    </button>
                </div>
            </div>

            <!-- Step 2: Capture -->
            <div id="step2-content" class="step-content hidden">
                <div class="face-recognition-container">
                    <div class="face-video-container">
                        <video id="face-video" class="face-video" autoplay muted playsinline></video>
                        <canvas id="face-canvas" class="face-canvas"></canvas>
                    </div>

                    <div id="face-status" class="face-status status-info">
                        Camera starting...
                    </div>

                    <div class="face-controls">
                        <button id="capture-btn" class="face-button face-button-primary" disabled>
                            Capture Face
                        </button>
                        <button id="retry-btn" class="face-button face-button-secondary">
                            Retry
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: Confirm -->
            <div id="step3-content" class="step-content hidden">
                <div class="text-center mb-6">
                    <div class="inline-block w-32 h-32 rounded-full overflow-hidden border-4 border-blue-500 mb-4">
                        <img id="captured-face" class="w-full h-full object-cover" src="" alt="Captured face">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Face Captured Successfully</h3>
                </div>

                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Your face has been captured. Please confirm to complete the registration.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button id="back-to-capture-btn" class="face-button face-button-secondary">
                        Retake Photo
                    </button>
                    <button id="register-btn" class="face-button face-button-success">
                        Confirm & Register
                    </button>
                </div>
            </div>

            <!-- Registration Complete -->
            <div id="registration-complete" class="step-content hidden">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                        <svg class="h-10 w-10 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Registration Complete!</h3>
                    <p class="text-gray-600 mb-6">Your face has been successfully registered for secure exams.</p>
                    <a href="{{ route('student.dashboard') }}" class="face-button face-button-primary inline-block">
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
            }
        });
        
        captureBtn.addEventListener('click', async function() {
            // Capture face
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
                
                // Show step 3
                step2.classList.remove('active');
                step3.classList.add('active');
                step2Content.classList.add('hidden');
                step3Content.classList.remove('hidden');
            }
        });
        
        retryBtn.addEventListener('click', function() {
            // Reset and retry capture
            const canvas = document.getElementById('face-canvas');
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
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
            registerBtn.textContent = 'Registering...';
            
            try {
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
                
                if (result.success) {
                    // Show registration complete
                    step3.classList.remove('active');
                    step3.classList.add('completed');
                    step3Content.classList.add('hidden');
                    registrationComplete.classList.remove('hidden');
                    
                    // Stop video
                    faceRecognition.stopVideo();
                } else {
                    alert('Registration failed: ' + result.message);
                    registerBtn.disabled = false;
                    registerBtn.textContent = 'Confirm & Register';
                }
            } catch (error) {
                console.error('Error registering face:', error);
                alert('An error occurred during registration. Please try again.');
                registerBtn.disabled = false;
                registerBtn.textContent = 'Confirm & Register';
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
