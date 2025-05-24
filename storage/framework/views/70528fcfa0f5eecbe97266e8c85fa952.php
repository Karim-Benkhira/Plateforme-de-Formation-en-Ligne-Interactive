<?php $__env->startSection('title', 'Create New Course'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        /* Admin Color Scheme - Yellow/Pink */
        --admin-primary: #f59e0b;
        --admin-primary-dark: #d97706;
        --admin-primary-light: #fbbf24;
        --admin-secondary: #ec4899;
        --admin-secondary-dark: #db2777;
        --admin-secondary-light: #f472b6;
        --admin-accent: #fbbf24;
        --admin-accent-dark: #f59e0b;
        --admin-bg-primary: #1f2937;
        --admin-bg-secondary: #111827;
        --admin-text-primary: #f9fafb;
        --admin-text-secondary: #d1d5db;
        --admin-border: #374151;
    }

    @keyframes admin-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
        }
    }

    .admin-glow {
        animation: admin-glow 2s ease-in-out infinite;
    }

    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .admin-gradient-bg {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
    }

    .admin-card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);
    }

    .form-section {
        transition: all 0.3s ease;
    }

    .form-section:hover {
        transform: translateY(-1px);
    }

    .input-focus-effect:focus-within {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-plus-circle mr-3 text-yellow-300"></i>
                Create New Course
            </h1>
            <p class="text-yellow-100 opacity-90">Add a new course to your learning platform and start educating students</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.courses')); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Back to Courses</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Form Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl shadow-xl relative overflow-hidden admin-card-hover">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative p-6">
        <div class="flex items-center mb-6">
            <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Course Information</h2>
        </div>

        <form method="POST" action="<?php echo e(route('admin.storeCourse')); ?>" enctype="multipart/form-data" class="space-y-8">
            <?php echo csrf_field(); ?>

            <!-- Basic Information Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                    Basic Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="input-focus-effect">
                        <label for="title" class="block text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-book text-yellow-400 mr-2"></i>
                            Course Title <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="title" id="title" required
                                class="w-full p-3 pl-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300 hover:border-yellow-500/30"
                                placeholder="Enter an engaging course title" />
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Choose a clear and descriptive title for your course</p>
                    </div>

                    <div class="input-focus-effect">
                        <label for="category" class="block text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-tag text-purple-400 mr-2"></i>
                            Category <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="category" id="category" required
                                class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 hover:border-purple-500/30 appearance-none">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Select the most appropriate category</p>
                    </div>
                </div>
            </div>

            <!-- Course Description Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-align-left text-green-400 mr-2"></i>
                    Course Description
                </h3>

                <div class="input-focus-effect">
                    <label for="description" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-file-alt text-green-400 mr-2"></i>
                        Description <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <textarea name="description" id="description" rows="5" required
                            class="w-full p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 hover:border-green-500/30 resize-none"
                            placeholder="Provide a comprehensive description of your course. Include what students will learn, prerequisites, and course objectives..."></textarea>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Write a detailed description to help students understand what they'll learn</p>
                </div>
            </div>

            <!-- Course Settings Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-cogs text-orange-400 mr-2"></i>
                    Course Settings
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="input-focus-effect">
                        <label for="score" class="block text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                            Passing Score <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="score" id="score" required min="0" max="100"
                                class="w-full p-3 pl-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300 hover:border-yellow-500/30"
                                placeholder="Enter passing score (0-100)" />
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                <span class="text-sm">%</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Minimum score required to pass this course</p>
                    </div>

                    <div class="input-focus-effect">
                        <label for="level" class="block text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-signal text-blue-400 mr-2"></i>
                            Difficulty Level
                        </label>
                        <div class="relative">
                            <select name="level" id="level"
                                class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 hover:border-blue-500/30 appearance-none">
                                <option value="beginner">🟢 Beginner</option>
                                <option value="intermediate">🟡 Intermediate</option>
                                <option value="advanced">🔴 Advanced</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Choose the appropriate difficulty level for your target audience</p>
                    </div>
                </div>
            </div>

            <!-- Course Image Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-image text-pink-400 mr-2"></i>
                    Course Image
                </h3>

                <div class="input-focus-effect">
                    <label for="image" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-camera text-pink-400 mr-2"></i>
                        Upload Course Thumbnail
                    </label>
                    <div class="relative">
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="group flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer bg-gray-900/50 border-gray-600 hover:bg-gray-800/50 hover:border-pink-500/50 transition-all duration-300">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div class="w-12 h-12 rounded-full bg-pink-900/50 flex items-center justify-center mb-3 group-hover:bg-pink-800/50 transition-colors duration-300">
                                        <i class="fas fa-cloud-upload-alt text-pink-400 text-xl"></i>
                                    </div>
                                    <p class="mb-2 text-sm text-gray-300 group-hover:text-white transition-colors duration-300">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-400">PNG, JPG or JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" />
                            </label>
                        </div>
                        <div id="image-preview" class="hidden mt-4">
                            <div class="flex items-center p-4 bg-gray-900/50 rounded-lg border border-gray-700/50">
                                <img id="preview-image" src="#" alt="Preview" class="h-20 w-20 object-cover rounded-lg mr-4 border border-gray-600">
                                <div class="flex-1">
                                    <p class="text-white font-medium">Image uploaded successfully</p>
                                    <p class="text-gray-400 text-sm">Ready to use as course thumbnail</p>
                                </div>
                                <button type="button" id="remove-image" class="text-red-400 hover:text-red-300 transition-colors duration-200 p-2">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Upload an attractive image that represents your course content</p>
                </div>
            </div>

            <!-- Course Content Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-play-circle text-cyan-400 mr-2"></i>
                    Course Content
                </h3>

                <div class="input-focus-effect mb-6">
                    <label for="content_type" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-file-alt text-cyan-400 mr-2"></i>
                        Content Type
                    </label>
                    <div class="relative">
                        <select name="content_type" id="content_type" onchange="toggleContentInputs()"
                            class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500/50 transition-all duration-300 hover:border-cyan-500/30 appearance-none">
                            <option value="">Select Content Type</option>
                            <option value="pdf">📄 PDF Document</option>
                            <option value="youtube">🎥 YouTube Video</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Choose how you want to deliver your course content</p>
                </div>

                <div id="pdf_input" class="hidden">
                    <div class="input-focus-effect">
                        <label for="pdf_file" class="block text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-file-pdf text-red-400 mr-2"></i>
                            Upload PDF Document
                        </label>
                        <div class="relative">
                            <div class="flex items-center justify-center w-full">
                                <label for="pdf_file" class="group flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer bg-gray-900/50 border-gray-600 hover:bg-gray-800/50 hover:border-red-500/50 transition-all duration-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div class="w-12 h-12 rounded-full bg-red-900/50 flex items-center justify-center mb-3 group-hover:bg-red-800/50 transition-colors duration-300">
                                            <i class="fas fa-file-pdf text-red-400 text-xl"></i>
                                        </div>
                                        <p class="mb-2 text-sm text-gray-300 group-hover:text-white transition-colors duration-300">
                                            <span class="font-semibold">Click to upload</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-gray-400">PDF files only (MAX. 10MB)</p>
                                    </div>
                                    <input id="pdf_file" name="pdf_file" type="file" class="hidden" accept="application/pdf" />
                                </label>
                            </div>
                            <div id="pdf-preview" class="hidden mt-4">
                                <div class="flex items-center p-4 bg-gray-900/50 rounded-lg border border-gray-700/50">
                                    <div class="w-12 h-12 rounded-lg bg-red-900/50 flex items-center justify-center mr-4">
                                        <i class="fas fa-file-pdf text-red-400 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-white font-medium">PDF uploaded successfully</p>
                                        <span id="pdf-name" class="text-gray-400 text-sm"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Upload your course material as a PDF document</p>
                    </div>
                </div>

                <div id="youtube_input" class="hidden">
                    <div class="input-focus-effect">
                        <label for="youtube_link" class="block text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fab fa-youtube text-red-500 mr-2"></i>
                            YouTube Video Link
                        </label>
                        <div class="relative">
                            <input type="text" name="youtube_link" id="youtube_link"
                                class="w-full p-3 pl-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-red-500/50 transition-all duration-300 hover:border-red-500/30"
                                placeholder="Enter YouTube video URL (e.g., https://www.youtube.com/watch?v=...)" />
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                <i class="fab fa-youtube text-red-500"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Paste the full YouTube video URL for your course content</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="bg-gradient-to-r from-red-900/80 to-red-800/80 border border-red-700/50 text-red-300 p-6 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-800/80 p-2 rounded-lg mr-4 shadow-inner">
                            <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-white">Validation Errors</h3>
                            <p class="text-red-200 text-sm">Please fix the following issues before proceeding:</p>
                        </div>
                    </div>
                    <ul class="space-y-2 ml-14">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center">
                                <i class="fas fa-times-circle text-red-400 mr-2 text-sm"></i>
                                <span><?php echo e($error); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-700/50">
                <a href="<?php echo e(route('admin.courses')); ?>" class="group px-6 py-3 bg-gray-800/80 hover:bg-gray-700/80 text-gray-300 hover:text-white border border-gray-600/50 hover:border-gray-500/50 font-medium rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Cancel</span>
                </a>
                <button type="submit" class="group px-6 py-3 bg-gradient-to-r from-yellow-600 to-pink-600 hover:from-yellow-500 hover:to-pink-500 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-yellow-500/20">
                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    <span>Create Course</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleContentInputs() {
        const contentType = document.getElementById('content_type').value;
        const pdfInput = document.getElementById('pdf_input');
        const youtubeInput = document.getElementById('youtube_input');

        // Hide all inputs with smooth transition
        pdfInput.classList.add('hidden');
        youtubeInput.classList.add('hidden');

        // Show selected input with animation
        setTimeout(() => {
            if (contentType === 'pdf') {
                pdfInput.classList.remove('hidden');
                pdfInput.style.opacity = '0';
                pdfInput.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    pdfInput.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    pdfInput.style.opacity = '1';
                    pdfInput.style.transform = 'translateY(0)';
                }, 10);
            } else if (contentType === 'youtube') {
                youtubeInput.classList.remove('hidden');
                youtubeInput.style.opacity = '0';
                youtubeInput.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    youtubeInput.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    youtubeInput.style.opacity = '1';
                    youtubeInput.style.transform = 'translateY(0)';
                }, 10);
            }
        }, 100);
    }

    // Enhanced functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview functionality
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-image');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');

                    // Add animation
                    previewContainer.style.opacity = '0';
                    previewContainer.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        previewContainer.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        previewContainer.style.opacity = '1';
                        previewContainer.style.transform = 'translateY(0)';
                    }, 10);
                }
                reader.readAsDataURL(file);
            }
        });

        removeButton.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.style.opacity = '0';
            previewContainer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                previewContainer.classList.add('hidden');
            }, 300);
        });

        // PDF file functionality
        const pdfInput = document.getElementById('pdf_file');
        const pdfPreview = document.getElementById('pdf-preview');
        const pdfName = document.getElementById('pdf-name');

        pdfInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('PDF file size must be less than 10MB');
                    this.value = '';
                    return;
                }

                pdfName.textContent = file.name;
                pdfPreview.classList.remove('hidden');

                // Add animation
                pdfPreview.style.opacity = '0';
                pdfPreview.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    pdfPreview.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    pdfPreview.style.opacity = '1';
                    pdfPreview.style.transform = 'translateY(0)';
                }, 10);
            } else {
                pdfPreview.style.opacity = '0';
                setTimeout(() => {
                    pdfPreview.classList.add('hidden');
                }, 300);
            }
        });

        // Form validation enhancement
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function(e) {
            // Add loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Creating Course...</span>';
            submitButton.disabled = true;

            // Re-enable if there are validation errors (will be handled by page reload)
            setTimeout(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save mr-2"></i><span>Create Course</span>';
            }, 5000);
        });

        // YouTube URL validation
        const youtubeInput = document.getElementById('youtube_link');
        youtubeInput.addEventListener('blur', function() {
            const url = this.value;
            if (url && !isValidYouTubeUrl(url)) {
                this.style.borderColor = '#ef4444';
                this.style.boxShadow = '0 0 0 2px rgba(239, 68, 68, 0.2)';

                // Show error message
                let errorMsg = this.parentElement.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className = 'error-message text-red-400 text-xs mt-1';
                    errorMsg.textContent = 'Please enter a valid YouTube URL';
                    this.parentElement.appendChild(errorMsg);
                }
            } else {
                this.style.borderColor = '';
                this.style.boxShadow = '';

                // Remove error message
                const errorMsg = this.parentElement.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });

        function isValidYouTubeUrl(url) {
            const regex = /^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+/;
            return regex.test(url);
        }

        // Add smooth scroll to error section if errors exist
        const errorSection = document.querySelector('.bg-gradient-to-r.from-red-900');
        if (errorSection) {
            errorSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/createCourse.blade.php ENDPATH**/ ?>