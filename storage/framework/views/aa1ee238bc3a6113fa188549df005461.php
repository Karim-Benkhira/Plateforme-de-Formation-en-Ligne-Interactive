<?php $__env->startSection('title', 'Create New Course'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner">
    <div class="flex items-center">
        <a href="<?php echo e(route('teacher.courses')); ?>" class="mr-4 text-white hover:text-blue-100 transition-colors">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white">Create New Course</h1>
            <p class="text-blue-100">Start with basic information, then add your videos</p>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto">
    <!-- Process Steps -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-green-900/50 to-blue-900/50 p-6 rounded-lg border border-green-700">
            <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-route text-green-400 mr-3"></i>
                Course Creation Process (Like Udemy)
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center p-4 bg-green-800/30 rounded-lg border border-green-600">
                    <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center mr-3 font-bold">1</div>
                    <div>
                        <h3 class="text-white font-medium">Basic Info</h3>
                        <p class="text-green-100 text-sm">Title, description, category</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-blue-800/30 rounded-lg border border-blue-600">
                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center mr-3 font-bold">2</div>
                    <div>
                        <h3 class="text-white font-medium">Add Content</h3>
                        <p class="text-blue-100 text-sm">Sections & multiple videos</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-purple-800/30 rounded-lg border border-purple-600">
                    <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center mr-3 font-bold">3</div>
                    <div>
                        <h3 class="text-white font-medium">Publish</h3>
                        <p class="text-purple-100 text-sm">Review & make live</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-edit mr-2"></i> Course Basic Information
        </div>
        <div class="section-content bg-gray-900">
            <form action="<?php echo e(route('teacher.courses.store')); ?>" method="POST" enctype="multipart/form-data" id="course-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="creator_id" value="<?php echo e(Auth::id()); ?>">
            <input type="hidden" name="score" value="100">
            <input type="hidden" name="content_type" value="video">
            <input type="hidden" name="is_published" value="0">

            <?php if($errors->any()): ?>
            <div class="bg-red-900/50 border border-red-700 text-red-300 p-4 rounded-lg mb-6">
                <div class="flex items-start mb-2">
                    <i class="fas fa-exclamation-triangle text-red-400 mt-1 mr-3"></i>
                    <h4 class="font-semibold">Please fix the following errors:</h4>
                </div>
                <ul class="list-disc pl-10 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Course Basic Information -->
            <div class="mb-8">
                <div class="form-section-title mb-6">
                    <i class="fas fa-info-circle mr-2 text-blue-400"></i>Basic Information
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="mb-6">
                            <label for="title" class="block text-white text-lg font-medium mb-2">Course Title</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400">
                                    <i class="fas fa-heading"></i>
                                </span>
                                <input type="text" name="title" id="title"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                    placeholder="Enter a descriptive title for your course" required>
                            </div>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="form-error mt-2"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="mb-6">
                            <label for="description" class="block text-white text-lg font-medium mb-2">Description</label>
                            <div class="relative">
                                <span class="absolute top-3 left-3 text-blue-400">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                    placeholder="Provide a detailed description of what students will learn" required></textarea>
                            </div>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="form-error mt-2"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <div class="mb-6">
                            <label for="category_id" class="block text-white text-lg font-medium mb-2">Category</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400">
                                    <i class="fas fa-folder"></i>
                                </span>
                                <select name="category_id" id="category_id"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 appearance-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                    required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="form-error mt-2"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <div class="mb-6">
                            <label for="level" class="block text-white text-lg font-medium mb-2">Difficulty</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400">
                                    <i class="fas fa-signal"></i>
                                </span>
                                <select name="level" id="level"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 appearance-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="form-error mt-2"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 mt-6">
                    <div class="form-section-title mb-4">
                        <i class="fas fa-image mr-2 text-blue-400"></i>Course Image
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700">
                        <div class="flex flex-col md:flex-row items-start md:items-center">
                            <div class="w-full md:w-1/2 mb-6 md:mb-0">
                                <div class="relative">
                                    <input type="file" name="image" id="image" class="hidden" accept="image/*" aria-label="Course image" aria-describedby="image-requirements">
                                    <label for="image" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg cursor-pointer hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg hover:shadow-blue-500/20" role="button" tabindex="0">
                                        <i class="fas fa-cloud-upload-alt text-xl mr-2" aria-hidden="true"></i>
                                        <span class="font-medium">Choose File</span>
                                    </label>
                                    <div id="file-name" class="mt-3 text-gray-300 flex items-center">
                                        <i class="fas fa-file-image text-blue-400 mr-2"></i>
                                        <span>No file chosen</span>
                                    </div>
                                </div>
                                <div id="image-requirements" class="mt-4 bg-gray-900/50 p-3 rounded-lg border border-gray-700">
                                    <p class="text-sm text-gray-300 flex items-start">
                                        <i class="fas fa-info-circle text-blue-400 mr-2 mt-1" aria-hidden="true"></i>
                                        <span>
                                            <strong class="block text-white mb-1">Image Requirements:</strong>
                                            Recommended size: 1280x720 pixels (16:9 ratio). Maximum file size: 2MB.
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 md:pl-6">
                                <div class="w-full h-48 bg-gray-900 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-700 hover:border-blue-500 transition-colors overflow-hidden">
                                    <img id="image-preview" src="#" alt="Preview" class="max-w-full max-h-full rounded-lg hidden object-cover">
                                    <div id="image-placeholder" class="text-gray-500 flex flex-col items-center p-4">
                                        <i class="fas fa-image text-5xl mb-3 text-gray-600"></i>
                                        <p class="text-sm text-center text-gray-400">Image Preview</p>
                                        <p class="text-xs text-center text-gray-500 mt-2">Your course thumbnail will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="form-error mt-3"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Next Steps Info -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-900/50 to-purple-900/50 p-6 rounded-lg border border-blue-700">
                    <div class="flex items-start">
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">What happens next?</h3>
                            <p class="text-blue-100 mb-4">After creating your course, you'll be able to:</p>
                            <ul class="space-y-2 text-blue-100">
                                <li class="flex items-center">
                                    <i class="fas fa-plus-circle text-green-400 mr-2"></i>
                                    Add multiple sections to organize your content
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-video text-green-400 mr-2"></i>
                                    Upload multiple videos per section (like Udemy)
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-link text-green-400 mr-2"></i>
                                    Add YouTube/Vimeo videos or upload local files
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-edit text-green-400 mr-2"></i>
                                    Organize and reorder your content easily
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-800 rounded-lg p-8 border-2 border-gray-700 mb-6 shadow-lg">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-2xl font-semibold text-white mb-2">Ready to create your course?</h3>
                        <p class="text-gray-300 leading-relaxed">
                            Start with basic information, then add your videos and content in the next step.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="<?php echo e(route('teacher.courses')); ?>"
                            class="px-8 py-4 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-all flex items-center justify-center shadow-lg hover:shadow-gray-700/30 transform hover:-translate-y-1">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span class="font-medium">Cancel</span>
                        </a>
                        <button type="submit" id="submit-button"
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition-all flex items-center justify-center font-medium shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Create Course & Add Videos</span>
                            <span class="loading-spinner ml-2 hidden">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    body {
        background-color: #111827;
    }

    /* Form Styles */
    .form-label {
        @apply block text-sm font-medium text-gray-300 mb-2;
    }

    .form-input {
        @apply w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-white transition-colors;
    }

    .form-input:hover {
        @apply border-gray-600;
    }

    .form-input:focus {
        @apply border-primary-500 bg-gray-900;
    }

    .form-select {
        @apply w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-white appearance-none transition-colors;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    .form-select:hover {
        @apply border-gray-600;
    }

    .form-select:focus {
        @apply border-primary-500 bg-gray-900;
    }

    .form-error {
        @apply text-red-400 text-xs mt-1 flex items-center;
    }

    .form-error:before {
        content: "⚠️";
        @apply mr-1;
    }

    .form-section-title {
        @apply text-xl font-semibold text-white mb-4 pb-2 border-b border-gray-700 flex items-center;
    }

    /* File Input Styling */
    .file-input {
        @apply absolute inset-0 w-full h-full opacity-0 cursor-pointer;
    }

    .file-label {
        @apply flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-md cursor-pointer hover:bg-primary-700 transition-colors shadow-md;
    }

    .file-name {
        @apply text-gray-400 transition-colors;
    }

    /* Content Type Options */
    .content-type-option {
        @apply relative;
    }

    .content-type-label {
        @apply flex flex-col items-center justify-center p-4 bg-gray-800 border border-gray-700 rounded-lg cursor-pointer transition-all text-gray-300 hover:bg-gray-700 shadow-md hover:shadow-lg;
    }

    input[name="content_type"]:checked + .content-type-label {
        @apply bg-primary-900/50 border-primary-500 text-primary-300 shadow-lg;
    }

    /* Toggle Switch */
    .toggle-switch {
        @apply relative inline-block w-14 h-7;
    }

    .toggle-input {
        @apply opacity-0 w-0 h-0;
    }

    .toggle-label {
        @apply absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-700 rounded-full transition-all duration-300 ease-in-out;
    }

    .toggle-label:before {
        @apply absolute content-[''] h-5 w-5 left-1 bottom-1 bg-white rounded-full transition-all duration-300 ease-in-out shadow-md;
    }

    .toggle-input:checked + .toggle-label {
        @apply bg-blue-600;
    }

    .toggle-input:checked + .toggle-label:before {
        @apply transform translate-x-7 bg-white scale-110;
    }

    .toggle-input:focus + .toggle-label {
        @apply ring-2 ring-blue-400;
    }

    .toggle-label:hover:before {
        @apply shadow-lg;
    }

    /* Custom Section Card */
    .section-card {
        @apply bg-gray-900 rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-800;
    }

    .section-header {
        @apply bg-gradient-to-r from-primary-600 to-blue-600 px-6 py-4 flex items-center text-white font-bold text-lg shadow-md;
    }

    .section-content {
        @apply p-6;
    }

    /* Form Grid Layout */
    .form-grid {
        @apply grid grid-cols-1 md:grid-cols-2 gap-6;
    }

    /* File Upload Area */
    .file-upload-area {
        @apply border-2 border-dashed border-gray-700 rounded-lg p-4 text-center cursor-pointer hover:border-primary-500 transition-colors;
    }

    .file-upload-icon {
        @apply text-3xl text-gray-500 mb-2;
    }

    /* Welcome Banner */
    .welcome-banner {
        @apply bg-gradient-to-r from-primary-600 to-blue-600 rounded-xl shadow-lg p-6 mb-8;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }

    .content-section {
        animation: fadeIn 0.3s ease-out;
    }

    /* Improved Buttons */
    button[type="submit"], a.px-6 {
        @apply shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview with animation
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');
        const fileName = document.getElementById('file-name');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Validate file size
                const fileSize = this.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 2) {
                    showError('Image file size must be less than 2MB');
                    this.value = ''; // Clear the input
                    return;
                }

                // Validate file type
                const fileType = this.files[0].type;
                if (!fileType.match('image.*')) {
                    showError('Please select an image file');
                    this.value = ''; // Clear the input
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Fade out placeholder
                    imagePlaceholder.style.opacity = '0';
                    setTimeout(() => {
                        // Set new image and fade it in
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        imagePlaceholder.classList.add('hidden');
                        imagePreview.style.opacity = '0';
                        setTimeout(() => {
                            imagePreview.style.opacity = '1';
                        }, 50);

                        // Show filename with animation
                        fileName.textContent = imageInput.files[0].name;
                        fileName.classList.add('text-primary-400');
                        setTimeout(() => {
                            fileName.classList.remove('text-primary-400');
                        }, 1500);
                    }, 200);
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.classList.add('hidden');
                imagePlaceholder.classList.remove('hidden');
                fileName.textContent = 'No file chosen';
            }
        });

        // Enhanced file input handling with validation
        function setupFileInput(inputId, fileNameId, maxSize, fileType) {
            const input = document.getElementById(inputId);
            const fileNameElement = document.getElementById(fileNameId);

            if (input && fileNameElement) {
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        // Validate file size
                        const fileSize = this.files[0].size / 1024 / 1024; // in MB
                        if (fileSize > maxSize) {
                            showError(`File size must be less than ${maxSize}MB`);
                            this.value = ''; // Clear the input
                            return;
                        }

                        // Validate file type if specified
                        if (fileType && !this.files[0].type.match(fileType)) {
                            showError(`Please select a valid ${fileType.replace('.*', '')} file`);
                            this.value = ''; // Clear the input
                            return;
                        }

                        // Animate filename change
                        fileNameElement.style.opacity = '0';
                        setTimeout(() => {
                            fileNameElement.textContent = this.files[0].name;
                            fileNameElement.classList.add('text-primary-400');
                            fileNameElement.style.opacity = '1';
                            setTimeout(() => {
                                fileNameElement.classList.remove('text-primary-400');
                            }, 1500);
                        }, 200);
                    } else {
                        fileNameElement.textContent = 'No file chosen';
                    }
                });
            }
        }

        // Setup file inputs with validation
        setupFileInput('pdf_file', 'pdf-file-name', 10, 'application/pdf');
        setupFileInput('video_file', 'video-file-name', 100, 'video.*');

        // YouTube preview functionality
        const youtubeInput = document.getElementById('youtube_link');
        const youtubePreview = document.getElementById('youtube-preview');

        if (youtubeInput && youtubePreview) {
            youtubeInput.addEventListener('input', debounce(function() {
                const url = youtubeInput.value.trim();
                if (url && isValidYouTubeUrl(url)) {
                    const videoId = extractYouTubeVideoId(url);
                    if (videoId) {
                        youtubePreview.innerHTML = `
                            <iframe
                                width="100%"
                                height="100%"
                                src="https://www.youtube.com/embed/${videoId}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="rounded-lg"
                            ></iframe>
                        `;
                    }
                } else {
                    youtubePreview.innerHTML = `<p class="text-gray-500">Enter a valid YouTube URL to see preview</p>`;
                }
            }, 800));
        }

        // Helper functions for YouTube
        function isValidYouTubeUrl(url) {
            const pattern = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/;
            return pattern.test(url);
        }

        function extractYouTubeVideoId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    func.apply(context, args);
                }, wait);
            };
        }

        // Improved content type switching with animation
        const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
        const contentSections = document.querySelectorAll('.content-section');

        function showSelectedContentSection() {
            const selectedValue = document.querySelector('input[name="content_type"]:checked').value;

            // Hide all sections with fade out
            contentSections.forEach(section => {
                if (!section.classList.contains('hidden')) {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(10px)';

                    setTimeout(() => {
                        section.classList.add('hidden');

                        // Show selected section with fade in
                        const selectedSection = document.getElementById(`${selectedValue}_content_section`);
                        selectedSection.classList.remove('hidden');
                        selectedSection.style.opacity = '0';
                        selectedSection.style.transform = 'translateY(10px)';

                        setTimeout(() => {
                            selectedSection.style.opacity = '1';
                            selectedSection.style.transform = 'translateY(0)';
                        }, 50);
                    }, 200);
                }
            });

            // If all sections are hidden, just show the selected one
            if (document.querySelectorAll('.content-section:not(.hidden)').length === 0) {
                const selectedSection = document.getElementById(`${selectedValue}_content_section`);
                selectedSection.classList.remove('hidden');
                selectedSection.style.opacity = '0';
                selectedSection.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    selectedSection.style.opacity = '1';
                    selectedSection.style.transform = 'translateY(0)';
                }, 50);
            }
        }

        contentTypeRadios.forEach(radio => {
            radio.addEventListener('change', showSelectedContentSection);
        });

        // Initialize with the default selected content type
        showSelectedContentSection();

        // Add transition styles
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        });

        // Add smooth transition to image preview
        if (imagePreview && imagePlaceholder) {
            imagePreview.style.transition = 'opacity 0.3s ease';
            imagePlaceholder.style.transition = 'opacity 0.3s ease';
        }

        // Add transition to file names
        document.querySelectorAll('.file-name').forEach(el => {
            el.style.transition = 'opacity 0.3s ease, color 0.3s ease';
        });

        // Function to update the hidden is_published field
        window.updatePublishValue = function(checkbox) {
            document.getElementById('is_published').value = checkbox.checked ? '1' : '0';
        };

        // Form submission handling
        const form = document.getElementById('course-form');
        const submitButton = document.getElementById('submit-button');
        const loadingSpinner = document.querySelector('.loading-spinner');

        if (form && submitButton) {
            form.addEventListener('submit', function(e) {
                // Basic form validation
                const title = document.getElementById('title').value.trim();
                const description = document.getElementById('description').value.trim();
                const category = document.getElementById('category_id').value;

                let isValid = true;
                let errorMessage = '';

                if (!title) {
                    isValid = false;
                    errorMessage = 'Course title is required';
                } else if (!description) {
                    isValid = false;
                    errorMessage = 'Course description is required';
                } else if (!category) {
                    isValid = false;
                    errorMessage = 'Please select a category';
                }

                // Content type specific validation
                const selectedContentType = document.querySelector('input[name="content_type"]:checked').value;

                if (selectedContentType === 'text') {
                    const content = document.getElementById('content').value.trim();
                    if (!content) {
                        isValid = false;
                        errorMessage = 'Please enter some text content for your course';
                    }
                } else if (selectedContentType === 'pdf') {
                    const pdfFile = document.getElementById('pdf_file').files[0];
                    if (!pdfFile) {
                        isValid = false;
                        errorMessage = 'Please upload a PDF file';
                    }
                } else if (selectedContentType === 'video') {
                    const videoFile = document.getElementById('video_file').files[0];
                    if (!videoFile) {
                        isValid = false;
                        errorMessage = 'Please upload a video file';
                    }
                } else if (selectedContentType === 'youtube') {
                    const youtubeLink = document.getElementById('youtube_link').value.trim();
                    if (!youtubeLink || !isValidYouTubeUrl(youtubeLink)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid YouTube URL';
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    showError(errorMessage);
                    return;
                }

                // Show loading state
                submitButton.disabled = true;
                submitButton.classList.add('opacity-75');
                loadingSpinner.classList.remove('hidden');
            });
        }

        // Error message display
        function showError(message) {
            // Create error element if it doesn't exist
            let errorContainer = document.getElementById('form-error-container');
            if (!errorContainer) {
                errorContainer = document.createElement('div');
                errorContainer.id = 'form-error-container';
                errorContainer.className = 'bg-red-900/50 border border-red-700 text-red-300 p-4 rounded-lg mb-6 flex items-start';

                const icon = document.createElement('i');
                icon.className = 'fas fa-exclamation-triangle text-red-400 mt-1 mr-3';

                const textContainer = document.createElement('div');
                const errorText = document.createElement('p');
                errorText.id = 'form-error-message';

                textContainer.appendChild(errorText);
                errorContainer.appendChild(icon);
                errorContainer.appendChild(textContainer);

                // Insert at the top of the form
                form.insertBefore(errorContainer, form.firstChild);
            }

            // Update error message
            document.getElementById('form-error-message').textContent = message;

            // Scroll to error
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Highlight error with animation
            errorContainer.style.animation = 'none';
            setTimeout(() => {
                errorContainer.style.animation = 'pulse 2s';
            }, 10);
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/createCourse.blade.php ENDPATH**/ ?>