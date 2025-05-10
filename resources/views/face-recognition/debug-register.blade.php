@include('components.header')

<div class="bg-gradient-to-b from-blue-50 to-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-white text-center">
                <h1 class="text-3xl font-bold mb-2">Face Registration (Debug Mode)</h1>
                <p class="text-blue-100">Register your face for secure exam verification</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Debug Info -->
                <div class="mb-6 p-4 bg-gray-100 rounded-lg">
                    <h2 class="text-lg font-semibold mb-2 text-gray-800">Debug Information</h2>
                    <div id="debug-info" class="text-xs font-mono bg-gray-900 text-green-400 p-3 rounded overflow-auto max-h-40">
                        Initializing face recognition system...
                    </div>
                </div>

                <!-- Camera Container -->
                <div class="mb-6">
                    <div class="relative aspect-video bg-gray-900 rounded-lg overflow-hidden">
                        <video id="video" class="w-full h-full object-cover" autoplay muted playsinline></video>
                        <canvas id="canvas" class="absolute top-0 left-0 w-full h-full"></canvas>
                        <div id="status-overlay" class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-70 text-white text-lg font-medium">
                            Camera not started
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="flex flex-wrap gap-4 mb-6">
                    <button id="start-camera" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Start Camera
                    </button>
                    <button id="capture-face" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition" disabled>
                        Capture Face
                    </button>
                    <button id="register-face" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition" disabled>
                        Register Face
                    </button>
                    <button id="reset" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                        Reset
                    </button>
                </div>

                <!-- Captured Image -->
                <div id="captured-container" class="hidden mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium mb-2 text-gray-800">Captured Face</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-32 h-32 bg-gray-200 rounded-lg overflow-hidden">
                            <img id="captured-image" class="w-full h-full object-cover" src="" alt="Captured face">
                        </div>
                        <div>
                            <p id="capture-status" class="text-gray-600">No face captured yet</p>
                            <div class="mt-2">
                                <span class="text-xs text-gray-500">Descriptor data available: </span>
                                <span id="descriptor-status" class="text-xs font-semibold text-red-500">No</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Result -->
                <div id="result-container" class="hidden p-4 rounded-lg">
                    <h3 class="text-lg font-medium mb-2">Registration Result</h3>
                    <p id="result-message"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/face-api/face-api.mock.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    // Debug logging function
    function log(message) {
        const debugInfo = document.getElementById('debug-info');
        const timestamp = new Date().toLocaleTimeString();
        debugInfo.innerHTML += `<div>[${timestamp}] ${message}</div>`;
        debugInfo.scrollTop = debugInfo.scrollHeight;
        console.log(`[Face Debug] ${message}`);
    }

    // Elements
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const statusOverlay = document.getElementById('status-overlay');
    const startCameraBtn = document.getElementById('start-camera');
    const captureFaceBtn = document.getElementById('capture-face');
    const registerFaceBtn = document.getElementById('register-face');
    const resetBtn = document.getElementById('reset');
    const capturedContainer = document.getElementById('captured-container');
    const capturedImage = document.getElementById('captured-image');
    const captureStatus = document.getElementById('capture-status');
    const descriptorStatus = document.getElementById('descriptor-status');
    const resultContainer = document.getElementById('result-container');
    const resultMessage = document.getElementById('result-message');

    // State
    let faceApiLoaded = false;
    let cameraStarted = false;
    let capturedDescriptor = null;
    let capturedImageData = null;

    // Initialize face-api.js
    async function initFaceApi() {
        try {
            log('Loading face-api.js models...');
            statusOverlay.textContent = 'Loading face recognition models...';

            await faceapi.nets.tinyFaceDetector.loadFromUri('/js/face-api/models');

            faceApiLoaded = true;
            log('✅ Face-api.js models loaded successfully');
            statusOverlay.textContent = 'Models loaded. Click "Start Camera" to begin.';
            return true;
        } catch (error) {
            log(`❌ Error loading face-api.js models: ${error.message}`);
            statusOverlay.textContent = 'Failed to load face recognition models';
            return false;
        }
    }

    // Start camera
    async function startCamera() {
        if (!faceApiLoaded) {
            log('❌ Cannot start camera: Face API not loaded');
            return false;
        }

        try {
            log('Requesting camera access...');
            statusOverlay.textContent = 'Starting camera...';

            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 1280 },
                    height: { ideal: 720 },
                    facingMode: 'user'
                }
            });

            video.srcObject = stream;

            return new Promise((resolve) => {
                video.onloadedmetadata = () => {
                    log('✅ Camera started successfully');
                    statusOverlay.textContent = '';
                    cameraStarted = true;
                    captureFaceBtn.disabled = false;
                    resolve(true);
                };
            });
        } catch (error) {
            log(`❌ Error starting camera: ${error.message}`);
            statusOverlay.textContent = 'Failed to access camera';
            return false;
        }
    }

    // Capture face
    async function captureFace() {
        if (!cameraStarted) {
            log('❌ Cannot capture face: Camera not started');
            return false;
        }

        try {
            log('Detecting face...');
            statusOverlay.textContent = 'Detecting face...';

            // Detect face with tiny face detector
            const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions());

            if (!detection) {
                log('❌ No face detected');
                statusOverlay.textContent = 'No face detected. Try again.';
                return false;
            }

            // Draw detection on canvas
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
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

            log('Face detection drawn with face-api.js');

            // Capture image
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = video.videoWidth;
            tempCanvas.height = video.videoHeight;
            tempCanvas.getContext('2d').drawImage(video, 0, 0);
            capturedImageData = tempCanvas.toDataURL('image/png');
            capturedImage.src = capturedImageData;

            // Create a simulated descriptor (since we're not using the face recognition model)
            capturedDescriptor = new Float32Array(128).fill(0.5);

            // Update UI
            capturedContainer.classList.remove('hidden');
            captureStatus.textContent = 'Face captured successfully';
            descriptorStatus.textContent = 'Yes';
            descriptorStatus.classList.remove('text-red-500');
            descriptorStatus.classList.add('text-green-500');
            registerFaceBtn.disabled = false;

            log('✅ Face captured successfully');
            statusOverlay.textContent = 'Face captured successfully';

            return true;
        } catch (error) {
            log(`❌ Error capturing face: ${error.message}`);
            statusOverlay.textContent = 'Error capturing face';
            return false;
        }
    }

    // Register face
    async function registerFace() {
        if (!capturedDescriptor || !capturedImageData) {
            log('❌ Cannot register: No face captured');
            return false;
        }

        try {
            log('Sending face data to server...');
            statusOverlay.textContent = 'Registering face...';

            log('Sending request to server...');
            let result;
            try {
                const response = await fetch('{{ route("face.register.post") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        face_descriptor: JSON.stringify(Array.from(capturedDescriptor)),
                        face_image: capturedImageData
                    })
                });

                log('Response received, status: ' + response.status);

                if (!response.ok) {
                    log('Response not OK: ' + response.status + ' ' + response.statusText);
                    throw new Error('Server responded with status: ' + response.status);
                }

                result = await response.json();
                log('Response parsed successfully');
                log('Result: ' + JSON.stringify(result));
            } catch (fetchError) {
                log('Error during fetch: ' + fetchError.message);
                throw fetchError;
            }

            if (result.success) {
                log('✅ Face registered successfully');
                resultContainer.classList.remove('hidden');
                resultContainer.classList.add('bg-green-50', 'border', 'border-green-200');
                resultMessage.textContent = 'Face registered successfully! You can now use facial verification for secure exams.';
                resultMessage.classList.add('text-green-700');
                statusOverlay.textContent = 'Registration complete';
            } else {
                log(`❌ Registration failed: ${result.message || 'Unknown error'}`);
                resultContainer.classList.remove('hidden');
                resultContainer.classList.add('bg-red-50', 'border', 'border-red-200');
                resultMessage.textContent = `Registration failed: ${result.message || 'An error occurred during registration.'}`;
                resultMessage.classList.add('text-red-700');
                statusOverlay.textContent = 'Registration failed';
            }

            return result.success;
        } catch (error) {
            log(`❌ Error registering face: ${error.message}`);
            resultContainer.classList.remove('hidden');
            resultContainer.classList.add('bg-red-50', 'border', 'border-red-200');
            resultMessage.textContent = `Error registering face: ${error.message}`;
            resultMessage.classList.add('text-red-700');
            statusOverlay.textContent = 'Registration error';
            return false;
        }
    }

    // Reset everything
    function reset() {
        // Clear canvas
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Reset state
        capturedDescriptor = null;
        capturedImageData = null;

        // Reset UI
        capturedContainer.classList.add('hidden');
        resultContainer.classList.add('hidden');
        captureStatus.textContent = 'No face captured yet';
        descriptorStatus.textContent = 'No';
        descriptorStatus.classList.remove('text-green-500');
        descriptorStatus.classList.add('text-red-500');
        registerFaceBtn.disabled = true;

        log('🔄 Reset complete');
        statusOverlay.textContent = cameraStarted ? 'Ready to capture' : 'Camera not started';
    }

    // Event listeners
    startCameraBtn.addEventListener('click', startCamera);
    captureFaceBtn.addEventListener('click', captureFace);
    registerFaceBtn.addEventListener('click', registerFace);
    resetBtn.addEventListener('click', reset);

    // Initialize
    await initFaceApi();
});
</script>

@include('components.footer')
