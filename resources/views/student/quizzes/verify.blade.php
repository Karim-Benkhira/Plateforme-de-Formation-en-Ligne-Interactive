@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Face Verification Required') }}</h2>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('This quiz requires face verification to ensure exam integrity. Please allow camera access and position your face in the frame.') }}
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="text-center mb-3">
                                <video id="video" width="100%" height="auto" autoplay muted></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button id="captureBtn" class="btn btn-primary btn-lg">
                                    <i class="fas fa-camera me-2"></i>{{ __('Capture and Verify') }}
                                </button>
                            </div>
                            
                            <div id="loadingIndicator" class="text-center mt-3" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                                </div>
                                <p>{{ __('Verifying your identity...') }}</p>
                            </div>
                            
                            <div id="errorMessage" class="alert alert-danger mt-3" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('captureBtn');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const errorMessage = document.getElementById('errorMessage');
        
        // Load face-api models
        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
            faceapi.nets.faceRecognitionNet.loadFromUri('/models')
        ]).then(startVideo).catch(err => {
            errorMessage.textContent = 'Error loading face recognition models: ' + err.message;
            errorMessage.style.display = 'block';
        });
        
        function startVideo() {
            navigator.mediaDevices.getUserMedia({ video: {} })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    errorMessage.textContent = 'Error accessing camera: ' + err.message;
                    errorMessage.style.display = 'block';
                });
        }
        
        captureBtn.addEventListener('click', async () => {
            try {
                // Display loading indicator
                loadingIndicator.style.display = 'block';
                captureBtn.disabled = true;
                errorMessage.style.display = 'none';
                
                // Detect faces in the video
                const detections = await faceapi.detectSingleFace(
                    video, 
                    new faceapi.TinyFaceDetectorOptions()
                );
                
                if (!detections) {
                    throw new Error('No face detected. Please position your face clearly in the frame.');
                }
                
                // Capture the current frame from the video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                
                // Convert the canvas to a data URL (base64 image)
                const imageData = canvas.toDataURL('image/png');
                
                // Send the image to the server for verification
                const response = await fetch('{{ route("face-recognition.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image: imageData,
                        quiz_id: {{ $quiz->id }}
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Redirect to the quiz page
                    window.location.href = result.redirect;
                } else {
                    throw new Error(result.message || 'Verification failed. Please try again.');
                }
            } catch (error) {
                errorMessage.textContent = error.message;
                errorMessage.style.display = 'block';
                captureBtn.disabled = false;
                loadingIndicator.style.display = 'none';
            }
        });
    });
</script>
@endpush
