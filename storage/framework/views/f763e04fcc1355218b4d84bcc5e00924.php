<?php $__env->startSection('title', 'Photo Upload for Face Verification'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .photo-upload-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .upload-card {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(75, 85, 99, 0.3);
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .upload-area {
        border: 2px dashed #0ea5e9;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .upload-area::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(14, 165, 233, 0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .upload-area:hover::before {
        transform: translateX(100%);
    }

    .upload-area:hover {
        border-color: #38bdf8;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(14, 165, 233, 0.2);
    }

    .upload-area.dragover {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
        transform: scale(1.02);
    }

    .camera-container {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        border-radius: 16px;
        overflow: hidden;
        background: #111827;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .camera-video {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 16px;
    }

    .camera-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        border: 3px solid rgba(14, 165, 233, 0.8);
        border-radius: 50%;
        pointer-events: none;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 0.8; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 1; transform: translate(-50%, -50%) scale(1.05); }
    }

    .preview-image {
        max-width: 400px;
        max-height: 400px;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        border: 2px solid rgba(14, 165, 233, 0.3);
    }

    .tab-button {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .tab-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .tab-button:hover::before {
        transform: translateX(100%);
    }

    .tab-button.active {
        background: linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%);
        color: white;
        box-shadow: 0 10px 25px rgba(14, 165, 233, 0.4);
        transform: translateY(-2px);
    }

    .tab-button:not(.active) {
        background: rgba(75, 85, 99, 0.4);
        color: #d1d5db;
        border: 1px solid rgba(75, 85, 99, 0.3);
    }

    .tab-button:not(.active):hover {
        background: rgba(75, 85, 99, 0.6);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .btn-primary:hover::before {
        transform: translateX(100%);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(14, 165, 233, 0.4);
    }

    .btn-secondary {
        background: rgba(75, 85, 99, 0.6);
        border: 1px solid rgba(75, 85, 99, 0.5);
        color: #d1d5db;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: rgba(75, 85, 99, 0.8);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .hidden {
        display: none !important;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .icon-gradient {
        background: linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(17, 24, 39, 0.9);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(14, 165, 233, 0.3);
        border-top: 4px solid #0ea5e9;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .success-animation {
        animation: successPulse 0.6s ease-out;
    }

    @keyframes successPulse {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-8">
    <div class="container mx-auto px-4">
        <div class="photo-upload-container">
            <!-- Header -->
            <div class="text-center mb-12 fade-in">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary-500 to-secondary-600 rounded-full mb-6 shadow-lg">
                    <i class="fas fa-user-shield text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">
                    <span class="icon-gradient">Secure Identity</span> Verification
                </h1>
                <p class="text-gray-300 max-w-2xl mx-auto text-lg leading-relaxed">
                    Upload a clear photo of your face to enable secure exam verification. This ensures exam integrity and prevents unauthorized access to your assessments.
                </p>
                <div class="mt-6 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg max-w-md mx-auto">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-400 mr-3"></i>
                        <p class="text-yellow-300 font-medium">Photo upload is required to access the platform</p>
                    </div>
                </div>
            </div>

        <?php if($existingPhoto): ?>
            <!-- Existing Photo Display -->
            <div class="upload-card p-8 mb-8 fade-in">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mb-6">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Photo Successfully Uploaded</h3>
                    <p class="text-gray-300 mb-6">
                        Your identity verification photo was uploaded on <?php echo e($existingPhoto->created_at->format('M d, Y \a\t g:i A')); ?>

                    </p>

                    <div class="flex justify-center mb-8">
                        <div class="relative">
                            <img src="<?php echo e($existingPhoto->photo_url); ?>" alt="Your verification photo"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-lg">
                            <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="<?php echo e(route('student.dashboard')); ?>"
                           class="btn-primary px-6 py-3 rounded-lg inline-flex items-center">
                            <i class="fas fa-home mr-2"></i>
                            Go to Dashboard
                        </a>

                        <form action="<?php echo e(route('face-verification.photo.delete')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="btn-secondary px-6 py-3 rounded-lg inline-flex items-center"
                                    onclick="return confirm('Are you sure you want to delete your photo? You will need to upload a new one to access the platform.')">
                                <i class="fas fa-trash mr-2"></i>
                                Replace Photo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Upload Interface -->
            <div class="upload-card p-8 fade-in">
                <!-- Tab Navigation -->
                <div class="flex justify-center mb-8">
                    <div class="flex bg-gray-800/50 rounded-xl p-2 border border-gray-700">
                        <button id="upload-tab" class="tab-button active">
                            <i class="fas fa-cloud-upload-alt mr-2"></i>
                            Upload Photo
                        </button>
                        <button id="camera-tab" class="tab-button">
                            <i class="fas fa-camera mr-2"></i>
                            Take Photo
                        </button>
                    </div>
                </div>

                <!-- Upload Section -->
                <div id="upload-section">
                    <form action="<?php echo e(route('face-verification.photo-upload.store')); ?>" method="POST" enctype="multipart/form-data" id="upload-form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="upload_method" value="upload">

                        <div class="upload-area" id="upload-area">
                            <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden">
                            <div id="upload-content" class="relative z-10">
                                <div class="mb-6">
                                    <i class="fas fa-cloud-upload-alt text-6xl icon-gradient mb-4"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-3">
                                    Choose or Drag Your Photo
                                </h3>
                                <p class="text-gray-300 mb-6 text-lg">
                                    JPG, PNG up to 5MB • Clear face photo required
                                </p>
                                <button type="button" class="btn-primary px-8 py-4 rounded-lg inline-flex items-center text-lg font-semibold">
                                    <i class="fas fa-folder-open mr-3"></i>
                                    Browse Files
                                </button>
                                <p class="text-gray-400 text-sm mt-4">
                                    Or drag and drop your photo here
                                </p>
                            </div>

                            <div id="preview-content" class="hidden text-center">
                                <img id="preview-image" class="preview-image mx-auto mb-6" alt="Preview">
                                <div class="flex flex-col sm:flex-row justify-center gap-4">
                                    <button type="button" id="change-photo" class="btn-secondary px-6 py-3 rounded-lg inline-flex items-center">
                                        <i class="fas fa-exchange-alt mr-2"></i>
                                        Change Photo
                                    </button>
                                    <button type="submit" class="btn-primary px-8 py-3 rounded-lg inline-flex items-center">
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
                            <div class="inline-flex items-center px-4 py-2 bg-blue-500/20 border border-blue-500/30 rounded-lg text-blue-300">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Position your face within the circle and click capture</span>
                            </div>
                        </div>

                        <div class="camera-container mb-8">
                            <video id="camera-video" class="camera-video" autoplay muted playsinline></video>
                            <div class="camera-overlay"></div>
                            <canvas id="camera-canvas" class="hidden"></canvas>

                            <!-- Camera Error Message -->
                            <div id="camera-error" class="hidden absolute inset-0 flex items-center justify-center bg-gray-900/90 rounded-16">
                                <div class="text-center p-6">
                                    <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-4"></i>
                                    <h3 class="text-xl font-bold text-white mb-2">Camera Access Required</h3>
                                    <p class="text-gray-300 mb-4">Please allow camera access to take your photo</p>
                                    <button id="retry-camera" class="btn-primary px-6 py-3 rounded-lg">
                                        <i class="fas fa-redo mr-2"></i>
                                        Try Again
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="camera-controls" class="space-y-4">
                            <button id="start-camera" class="btn-primary px-8 py-4 rounded-lg text-lg font-semibold">
                                <i class="fas fa-video mr-3"></i>
                                Start Camera
                            </button>
                            <button id="capture-photo" class="btn-primary px-8 py-4 rounded-lg text-lg font-semibold hidden">
                                <i class="fas fa-camera mr-3"></i>
                                Capture Photo
                            </button>
                            <div class="text-sm text-gray-400 mt-2">
                                Make sure your face is clearly visible and well-lit
                            </div>
                        </div>

                        <div id="captured-photo-section" class="hidden mt-8">
                            <img id="captured-image" class="preview-image mx-auto mb-6" alt="Captured photo">
                            <form action="<?php echo e(route('face-verification.photo-upload.store')); ?>" method="POST" id="camera-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="upload_method" value="capture">
                                <input type="hidden" name="photo" id="captured-data">

                                <div class="flex flex-col sm:flex-row justify-center gap-4">
                                    <button type="button" id="retake-photo" class="btn-secondary px-6 py-3 rounded-lg inline-flex items-center">
                                        <i class="fas fa-redo mr-2"></i>
                                        Retake Photo
                                    </button>
                                    <button type="submit" class="btn-primary px-8 py-3 rounded-lg inline-flex items-center">
                                        <i class="fas fa-save mr-2"></i>
                                        Save Photo
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Guidelines -->
                <div class="mt-8 bg-blue-500/10 border border-blue-500/20 rounded-xl p-6">
                    <h4 class="font-bold text-blue-300 mb-4 text-lg">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Photo Guidelines for Best Results
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                <span class="text-gray-300">Face clearly visible and well-lit</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                <span class="text-gray-300">Look directly at the camera</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                <span class="text-gray-300">Remove sunglasses or face coverings</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                <span class="text-gray-300">Use a plain background if possible</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                <span class="text-gray-300">Recent photo representing current appearance</span>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                                <span class="text-gray-300">High quality image (not blurry)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-800 dark:text-green-200"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-red-800 dark:text-red-200"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 dark:text-red-200 mb-2">Please fix the following errors:</h4>
                        <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>• <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay hidden">
        <div class="text-center">
            <div class="loading-spinner mx-auto mb-4"></div>
            <h3 class="text-xl font-semibold text-white mb-2">Processing Your Photo</h3>
            <p class="text-gray-300">Please wait while we verify your image...</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const uploadTab = document.getElementById('upload-tab');
    const cameraTab = document.getElementById('camera-tab');
    const uploadSection = document.getElementById('upload-section');
    const cameraSection = document.getElementById('camera-section');

    uploadTab.addEventListener('click', function() {
        uploadTab.classList.add('active');
        cameraTab.classList.remove('active');
        uploadSection.classList.remove('hidden');
        cameraSection.classList.add('hidden');
        stopCamera();
    });

    cameraTab.addEventListener('click', function() {
        cameraTab.classList.add('active');
        uploadTab.classList.remove('active');
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/photo-upload.blade.php ENDPATH**/ ?>