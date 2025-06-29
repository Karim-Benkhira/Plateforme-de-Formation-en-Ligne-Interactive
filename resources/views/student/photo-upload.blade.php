@extends('layouts.student')

@section('title', 'Photo Upload for Face Verification')

@push('styles')
<style>
    .upload-area {
        border: 2px dashed #3b82f6;
        border-radius: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .upload-area:hover {
        border-color: #60a5fa;
        background: rgba(59, 130, 246, 0.05);
        transform: translateY(-2px);
    }

    .upload-area.dragover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        transform: scale(1.02);
    }

    .camera-overlay {
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

    .tab-button {
        transition: all 0.3s ease;
    }

    .tab-button.active {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        transform: translateY(-1px);
    }

    .preview-image {
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        border: 2px solid rgba(59, 130, 246, 0.3);
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
                <i class="fas fa-camera text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-4">
                📸 Identity Verification
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto mb-6">
                Upload a clear photo of your face to enable secure exam verification and access the platform
            </p>

            <!-- Important Notice -->
            <div class="max-w-md mx-auto bg-amber-500/10 border border-amber-500/30 rounded-xl p-4 mb-8">
                <div class="flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-amber-400 mr-3"></i>
                    <p class="text-amber-200 font-medium">Photo upload is required to access the platform</p>
                </div>
            </div>
        </div>

        @if($existingPhoto)
            <!-- Existing Photo Display -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-gray-700/50 p-8 shadow-2xl">
                    <div class="text-center">
                        <!-- Success Icon -->
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mb-6 shadow-lg">
                            <i class="fas fa-check-circle text-white text-3xl"></i>
                        </div>

                        <!-- Success Message -->
                        <h3 class="text-2xl font-bold text-white mb-3">✅ Photo Successfully Uploaded</h3>
                        <p class="text-gray-300 mb-8">
                            Your identity verification photo was uploaded on
                            <span class="text-blue-400 font-medium">{{ $existingPhoto->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </p>

                        <!-- Photo Display -->
                        <div class="flex justify-center mb-8">
                            <div class="relative">
                                <img src="{{ $existingPhoto->photo_url }}" alt="Your verification photo"
                                     class="w-40 h-40 rounded-full object-cover border-4 border-green-500 shadow-xl">
                                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-white text-lg"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Status Card -->
                        <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 mb-8">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-shield-check text-green-400 mr-3"></i>
                                <span class="text-green-200 font-medium">Ready for secure exam verification</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('student.dashboard') }}"
                               class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center justify-center">
                                <i class="fas fa-home mr-2"></i>
                                Go to Dashboard
                            </a>

                            <form action="{{ route('face-verification.photo.delete') }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center justify-center"
                                        onclick="return confirm('Are you sure you want to delete your photo? You will need to upload a new one to access the platform.')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Replace Photo
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Upload Interface -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-gray-700/50 p-8 shadow-2xl">
                    <!-- Tab Navigation -->
                    <div class="flex justify-center mb-8">
                        <div class="flex bg-gray-900/50 rounded-xl p-2 border border-gray-700/50">
                            <button id="upload-tab" class="tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-200 active bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                                <i class="fas fa-cloud-upload-alt mr-2"></i>
                                Upload Photo
                            </button>
                            <button id="camera-tab" class="tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-200 text-gray-400 hover:text-white">
                                <i class="fas fa-camera mr-2"></i>
                                Take Photo
                            </button>
                        </div>
                    </div>

                    <!-- Upload Section -->
                    <div id="upload-section">
                        <form action="{{ route('face-verification.photo-upload.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                            @csrf
                            <input type="hidden" name="upload_method" value="upload">

                            <div class="upload-area bg-gray-900/30 border-2 border-dashed border-blue-500/50 rounded-2xl p-12 text-center hover:border-blue-400/70 transition-all duration-300" id="upload-area">
                                <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden">

                                <div id="upload-content">
                                    <!-- Upload Icon -->
                                    <div class="mb-6">
                                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-4">
                                            <i class="fas fa-cloud-upload-alt text-white text-3xl"></i>
                                        </div>
                                    </div>

                                    <!-- Upload Text -->
                                    <h3 class="text-2xl font-bold text-white mb-3">
                                        Choose or Drag Your Photo
                                    </h3>
                                    <p class="text-gray-300 mb-8 text-lg">
                                        JPG, PNG up to 5MB • Clear face photo required
                                    </p>

                                    <!-- Browse Button -->
                                    <button type="button" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center">
                                        <i class="fas fa-folder-open mr-3"></i>
                                        Browse Files
                                    </button>

                                    <p class="text-gray-400 text-sm mt-6">
                                        Or drag and drop your photo here
                                    </p>
                                </div>

                                <!-- Preview Content -->
                                <div id="preview-content" class="hidden">
                                    <img id="preview-image" class="preview-image mx-auto mb-6 max-w-sm rounded-xl shadow-lg" alt="Preview">
                                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                                        <button type="button" id="change-photo" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center">
                                            <i class="fas fa-exchange-alt mr-2"></i>
                                            Change Photo
                                        </button>
                                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center">
                                            <i class="fas fa-upload mr-2"></i>
                                            Upload Photo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Camera Section -->
                    <div id="camera-section" class="hidden">
                        <div class="text-center">
                            <!-- Camera Status -->
                            <div id="camera-status" class="mb-6">
                                <div class="inline-flex items-center px-6 py-3 bg-blue-500/20 border border-blue-500/30 rounded-xl text-blue-200">
                                    <i class="fas fa-info-circle mr-3"></i>
                                    <span>Position your face within the circle and click capture</span>
                                </div>
                            </div>

                            <!-- Camera Container -->
                            <div class="relative bg-gray-900 rounded-2xl overflow-hidden shadow-xl mb-8 max-w-lg mx-auto">
                                <video id="camera-video" class="w-full h-auto rounded-2xl" autoplay muted playsinline style="min-height: 300px;"></video>
                                <div class="camera-overlay"></div>
                                <canvas id="camera-canvas" class="hidden"></canvas>

                                <!-- Camera Error Message -->
                                <div id="camera-error" class="hidden absolute inset-0 flex items-center justify-center bg-gray-900/90 rounded-2xl">
                                    <div class="text-center p-8">
                                        <i class="fas fa-exclamation-triangle text-yellow-400 text-5xl mb-6"></i>
                                        <h3 class="text-xl font-bold text-white mb-3">Camera Access Required</h3>
                                        <p class="text-gray-300 mb-6">Please allow camera access to take your photo</p>
                                        <button id="retry-camera" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                            <i class="fas fa-redo mr-2"></i>
                                            Try Again
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Camera Controls -->
                            <div id="camera-controls" class="space-y-4">
                                <button id="start-camera" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-video mr-3"></i>
                                    Start Camera
                                </button>
                                <button id="capture-photo" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hidden">
                                    <i class="fas fa-camera mr-3"></i>
                                    Capture Photo
                                </button>

                                <!-- Guidelines -->
                                <div class="bg-amber-500/10 border border-amber-500/30 rounded-xl p-4 mt-6">
                                    <p class="text-amber-200 text-sm">
                                        <i class="fas fa-lightbulb mr-2"></i>
                                        Make sure your face is clearly visible and well-lit
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Captured Photo Section -->
                        <div id="captured-photo-section" class="hidden mt-8">
                            <div class="text-center">
                                <img id="captured-image" class="preview-image mx-auto mb-6 max-w-sm rounded-xl shadow-lg" alt="Captured photo">
                                <form action="{{ route('face-verification.photo-upload.store') }}" method="POST" id="camera-form">
                                    @csrf
                                    <input type="hidden" name="upload_method" value="capture">
                                    <input type="hidden" name="photo" id="captured-data">

                                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                                        <button type="button" id="retake-photo" class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center">
                                            <i class="fas fa-redo mr-2"></i>
                                            Retake Photo
                                        </button>
                                        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-flex items-center">
                                            <i class="fas fa-save mr-2"></i>
                                            Save Photo
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Guidelines Section -->
                    <div class="mt-8 bg-blue-500/10 border border-blue-500/30 rounded-2xl p-8">
                        <h4 class="font-bold text-blue-200 mb-6 text-xl flex items-center">
                            <i class="fas fa-lightbulb mr-3 text-yellow-400"></i>
                            Photo Guidelines for Best Results
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-lg"></i>
                                    <span class="text-gray-300">Face clearly visible and well-lit</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-lg"></i>
                                    <span class="text-gray-300">Look directly at the camera</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-lg"></i>
                                    <span class="text-gray-300">Remove sunglasses or face coverings</span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-lg"></i>
                                    <span class="text-gray-300">Use a plain background if possible</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-lg"></i>
                                    <span class="text-gray-300">Recent photo representing current appearance</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-1 text-lg"></i>
                                    <span class="text-gray-300">High quality image (not blurry)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
            <div class="mt-8 max-w-2xl mx-auto">
                <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 mr-3 text-xl"></i>
                        <p class="text-green-200 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="mt-8 max-w-2xl mx-auto">
                <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 text-xl"></i>
                        <p class="text-red-200 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mt-8 max-w-2xl mx-auto">
                <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-1 text-xl"></i>
                        <div>
                            <h4 class="font-semibold text-red-200 mb-3">Please fix the following errors:</h4>
                            <ul class="text-red-300 space-y-2">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-start">
                                        <i class="fas fa-times text-red-400 mr-2 mt-1 text-sm"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6">
                    <svg class="animate-spin h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">📸 Processing Your Photo</h3>
                <p class="text-gray-300">Please wait while we verify your image...</p>
                <div class="mt-4 w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const uploadTab = document.getElementById('upload-tab');
    const cameraTab = document.getElementById('camera-tab');
    const uploadSection = document.getElementById('upload-section');
    const cameraSection = document.getElementById('camera-section');

    uploadTab.addEventListener('click', function() {
        // Update tab styles
        uploadTab.className = 'tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-200 active bg-gradient-to-r from-blue-600 to-purple-600 text-white';
        cameraTab.className = 'tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-200 text-gray-400 hover:text-white';

        // Show/hide sections
        uploadSection.classList.remove('hidden');
        cameraSection.classList.add('hidden');
        stopCamera();
    });

    cameraTab.addEventListener('click', function() {
        // Update tab styles
        cameraTab.className = 'tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-200 active bg-gradient-to-r from-blue-600 to-purple-600 text-white';
        uploadTab.className = 'tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-200 text-gray-400 hover:text-white';

        // Show/hide sections
        cameraSection.classList.remove('hidden');
        uploadSection.classList.add('hidden');

        // Check if HTTPS is available for camera access
        if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
            showCameraError('Camera requires HTTPS connection. Please use HTTPS or localhost.');
            return;
        }
    });

    // File upload functionality
    const uploadArea = document.getElementById('upload-area');
    const photoInput = document.getElementById('photo-input');
    const uploadContent = document.getElementById('upload-content');
    const previewContent = document.getElementById('preview-content');
    const previewImage = document.getElementById('preview-image');
    const changePhotoBtn = document.getElementById('change-photo');

    // Click to upload
    uploadArea.addEventListener('click', function(e) {
        if (!previewContent.classList.contains('hidden')) return;
        photoInput.click();
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });

    // File input change
    photoInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    // Change photo button
    changePhotoBtn.addEventListener('click', function() {
        photoInput.click();
    });

    function handleFileSelect(file) {
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            uploadContent.classList.add('hidden');
            previewContent.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    // Camera functionality
    const startCameraBtn = document.getElementById('start-camera');
    const capturePhotoBtn = document.getElementById('capture-photo');
    const retakePhotoBtn = document.getElementById('retake-photo');
    const retryCameraBtn = document.getElementById('retry-camera');
    const cameraVideo = document.getElementById('camera-video');
    const cameraCanvas = document.getElementById('camera-canvas');
    const capturedImage = document.getElementById('captured-image');
    const capturedData = document.getElementById('captured-data');
    const capturedPhotoSection = document.getElementById('captured-photo-section');
    const cameraControls = document.getElementById('camera-controls');
    const cameraError = document.getElementById('camera-error');
    const cameraStatus = document.getElementById('camera-status');

    let stream = null;

    startCameraBtn.addEventListener('click', startCamera);
    capturePhotoBtn.addEventListener('click', capturePhoto);
    retakePhotoBtn.addEventListener('click', retakePhoto);
    retryCameraBtn.addEventListener('click', startCamera);

    function showCameraError(message) {
        cameraError.classList.remove('hidden');
        cameraError.querySelector('p').textContent = message;
        cameraVideo.classList.add('hidden');
        cameraControls.classList.add('hidden');
    }

    function hideCameraError() {
        cameraError.classList.add('hidden');
        cameraVideo.classList.remove('hidden');
        cameraControls.classList.remove('hidden');
    }

    async function startCamera() {
        try {
            hideCameraError();

            // Check if getUserMedia is supported
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Camera access is not supported in this browser');
            }

            // Update status
            cameraStatus.innerHTML = `
                <div class="inline-flex items-center px-4 py-2 bg-yellow-500/20 border border-yellow-500/30 rounded-lg text-yellow-300">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    <span>Starting camera...</span>
                </div>
            `;

            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 1280, min: 640 },
                    height: { ideal: 720, min: 480 },
                    facingMode: 'user'
                },
                audio: false
            });

            cameraVideo.srcObject = stream;

            // Wait for video to be ready
            cameraVideo.onloadedmetadata = function() {
                cameraVideo.play();
                startCameraBtn.classList.add('hidden');
                capturePhotoBtn.classList.remove('hidden');

                // Update status
                cameraStatus.innerHTML = `
                    <div class="inline-flex items-center px-4 py-2 bg-green-500/20 border border-green-500/30 rounded-lg text-green-300">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Camera ready - Position your face and click capture</span>
                    </div>
                `;
            };

        } catch (error) {
            console.error('Error accessing camera:', error);
            let errorMessage = 'Unable to access camera. ';

            if (error.name === 'NotAllowedError') {
                errorMessage += 'Please allow camera permissions and try again.';
            } else if (error.name === 'NotFoundError') {
                errorMessage += 'No camera found on this device.';
            } else if (error.name === 'NotSupportedError') {
                errorMessage += 'Camera is not supported in this browser.';
            } else {
                errorMessage += 'Please check your camera and try again.';
            }

            showCameraError(errorMessage);
        }
    }

    function capturePhoto() {
        try {
            const context = cameraCanvas.getContext('2d');
            cameraCanvas.width = cameraVideo.videoWidth;
            cameraCanvas.height = cameraVideo.videoHeight;

            // Draw the video frame to canvas
            context.drawImage(cameraVideo, 0, 0);

            // Convert to high-quality JPEG
            const dataURL = cameraCanvas.toDataURL('image/jpeg', 0.9);
            capturedImage.src = dataURL;
            capturedData.value = dataURL;

            // Hide camera and show captured photo
            cameraVideo.classList.add('hidden');
            cameraControls.classList.add('hidden');
            cameraStatus.classList.add('hidden');
            capturedPhotoSection.classList.remove('hidden');

            stopCamera();
        } catch (error) {
            console.error('Error capturing photo:', error);
            alert('Error capturing photo. Please try again.');
        }
    }

    function retakePhoto() {
        cameraVideo.classList.remove('hidden');
        cameraControls.classList.remove('hidden');
        cameraStatus.classList.remove('hidden');
        capturedPhotoSection.classList.add('hidden');
        startCamera();
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        startCameraBtn.classList.remove('hidden');
        capturePhotoBtn.classList.add('hidden');

        // Reset status
        cameraStatus.innerHTML = `
            <div class="inline-flex items-center px-4 py-2 bg-blue-500/20 border border-blue-500/30 rounded-lg text-blue-300">
                <i class="fas fa-info-circle mr-2"></i>
                <span>Position your face within the circle and click capture</span>
            </div>
        `;
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', stopCamera);

    // Loading overlay functions
    function showLoading() {
        document.getElementById('loading-overlay').classList.remove('hidden');
    }

    function hideLoading() {
        document.getElementById('loading-overlay').classList.add('hidden');
    }

    // Add loading states to forms
    document.getElementById('upload-form').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('photo-input');
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Please select a photo to upload.');
            return;
        }

        showLoading();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
        submitBtn.disabled = true;
    });

    document.getElementById('camera-form').addEventListener('submit', function(e) {
        const capturedData = document.getElementById('captured-data');
        if (!capturedData.value) {
            e.preventDefault();
            alert('Please capture a photo first.');
            return;
        }

        showLoading();
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        submitBtn.disabled = true;
    });

    // Add success animation to existing photo section
    const existingPhotoSection = document.querySelector('.upload-card');
    if (existingPhotoSection && existingPhotoSection.querySelector('.fa-check-circle')) {
        existingPhotoSection.classList.add('success-animation');
    }

    // Enhanced file validation
    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, JPEG, or PNG).');
            return false;
        }

        if (file.size > maxSize) {
            alert('File size must be less than 5MB. Please choose a smaller image.');
            return false;
        }

        return true;
    }

    // Update file selection handler to use enhanced validation
    const originalHandleFileSelect = handleFileSelect;
    handleFileSelect = function(file) {
        if (validateFile(file)) {
            originalHandleFileSelect(file);
        }
    };
});
</script>
@endpush
