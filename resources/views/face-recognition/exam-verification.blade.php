@include('components.header')

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 bg-blue-600 text-white">
                <h1 class="text-2xl font-bold">Secure Exam Verification</h1>
                <p class="mt-2">Your identity will be verified using facial recognition before and during the exam</p>
            </div>
            
            <div class="p-6">
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Important:</strong> Your face will be verified periodically during the exam. If verification fails multiple times, your exam session may be terminated.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="face-recognition-container">
                    <div class="face-video-container">
                        <video id="face-video" class="face-video" autoplay muted playsinline></video>
                        <canvas id="face-canvas" class="face-canvas"></canvas>
                    </div>

                    <div id="face-status" class="face-status status-info">
                        Please position your face in the frame
                    </div>

                    <div id="face-progress" class="face-progress">
                        <div id="face-progress-bar" class="face-progress-bar" style="width: 0%"></div>
                    </div>

                    <div class="face-controls">
                        <button id="start-verification-btn" class="face-button face-button-primary">
                            Start Verification
                        </button>
                        <button id="continue-exam-btn" class="face-button face-button-success hidden">
                            Continue to Exam
                        </button>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Exam Rules</h3>
                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                        <li>Ensure your face remains visible throughout the exam</li>
                        <li>Do not leave the exam screen until you have completed the exam</li>
                        <li>No additional persons should be visible in the frame</li>
                        <li>Maintain good lighting conditions</li>
                        <li>Periodic identity verification will occur automatically</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verification in Progress Modal -->
<div id="verification-modal" class="exam-verification-overlay hidden">
    <div class="exam-verification-modal">
        <div class="exam-verification-header">
            <h3>Identity Verification</h3>
        </div>
        <div class="exam-verification-body">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 mb-2">Verifying your identity...</p>
                <p class="text-sm text-gray-500">Please keep your face clearly visible</p>
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
            startVerificationBtn.textContent = 'Verifying...';
            
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
                    startVerificationBtn.textContent = 'Retry Verification';
                }
            } catch (error) {
                console.error('Error during verification:', error);
                
                // Hide verification modal
                verificationModal.classList.add('hidden');
                
                statusEl.textContent = 'An error occurred during verification. Please try again.';
                statusEl.className = 'face-status status-error';
                
                startVerificationBtn.disabled = false;
                startVerificationBtn.textContent = 'Retry Verification';
            }
        });
        
        continueExamBtn.addEventListener('click', function() {
            if (verificationComplete) {
                // Start continuous verification
                faceRecognition.startVerification(30, 3);
                
                // Redirect to exam
                window.location.href = '{{ route("student.quiz", ["id" => $quizId]) }}';
            }
        });
        
        // Handle exam termination event
        document.addEventListener('exam-terminated', function(e) {
            alert('Exam session terminated: ' + e.detail.reason);
            window.location.href = '{{ route("student.dashboard") }}';
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
                const response = await fetch('{{ route("face.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        face_descriptor: JSON.stringify(Array.from(descriptor))
                    })
                });
                
                const result = await response.json();
                
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

@include('components.footer')
