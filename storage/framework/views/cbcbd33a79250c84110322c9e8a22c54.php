<?php $__env->startSection('title', 'Create New Category'); ?>

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

    /* Input focus effect */
    .input-focus-effect {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-focus-effect:focus-within {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    }

    .input-focus-effect:focus-within::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -5px;
        height: 3px;
        background: linear-gradient(to right, var(--admin-primary), var(--admin-secondary));
        border-radius: 3px;
        opacity: 0.7;
    }

    /* Custom radio buttons */
    .radio-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .radio-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(245, 158, 11, 0.2), rgba(236, 72, 153, 0.2));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .radio-card:hover::before {
        opacity: 1;
    }

    .form-section {
        transition: all 0.3s ease;
    }

    .form-section:hover {
        transform: translateY(-1px);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-folder-plus mr-3 text-yellow-300"></i>
                Create New Category
            </h1>
            <p class="text-yellow-100 opacity-90">Add a new category to organize your courses and improve navigation</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.categories')); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Back to Categories</span>
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl shadow-xl relative overflow-hidden max-w-4xl mx-auto admin-card-hover">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative p-6">
        <!-- Form Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Category Details</h2>
            </div>
            <p class="text-gray-400 mt-2 ml-12">Fill in the details below to create a new category for organizing courses</p>
        </div>

        <!-- Form Content -->
        <form action="<?php echo e(route('admin.storeCategory')); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>

            <!-- Category Name Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-signature text-yellow-400 mr-2"></i>
                    Basic Information
                </h3>

                <div class="input-focus-effect">
                    <label for="name" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-tag text-yellow-400 mr-2"></i>
                        Category Name <span class="text-red-400 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                            class="w-full p-4 pl-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300 hover:border-yellow-500/30"
                            placeholder="Enter a clear and descriptive category name" />
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Choose a clear and concise name that represents the category content</p>
                </div>
            </div>

            <!-- Category Description Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-align-left text-green-400 mr-2"></i>
                    Description
                </h3>

                <div class="input-focus-effect">
                    <label for="description" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-file-alt text-green-400 mr-2"></i>
                        Category Description
                    </label>
                    <div class="relative">
                        <textarea name="description" id="description" rows="4"
                            class="w-full p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 hover:border-green-500/30 resize-none"
                            placeholder="Provide a brief description of what this category includes and what types of courses it will contain..."><?php echo e(old('description')); ?></textarea>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Help users understand what types of courses belong to this category</p>
                </div>
            </div>

            <!-- Category Icon Section -->
            <div class="form-section bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-icons text-purple-400 mr-2"></i>
                    Visual Appearance
                </h3>

                <div class="mb-6">
                    <label for="icon" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-star text-purple-400 mr-2"></i>
                        Category Icon
                    </label>
                    <div class="grid grid-cols-4 md:grid-cols-8 gap-3 p-4 bg-gray-900/70 rounded-xl border border-gray-700/50">
                        <?php $__currentLoopData = ['book', 'code', 'laptop', 'calculator', 'flask', 'language', 'music', 'palette', 'chart-pie', 'brain', 'atom', 'globe', 'camera', 'video', 'microphone', 'graduation-cap']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <input type="radio" name="icon" id="icon-<?php echo e($icon); ?>" value="<?php echo e($icon); ?>" class="hidden peer" <?php echo e(old('icon') == $icon ? 'checked' : ''); ?>>
                            <label for="icon-<?php echo e($icon); ?>" class="radio-card flex flex-col items-center justify-center p-3 rounded-lg cursor-pointer bg-gray-800 hover:bg-gray-700 peer-checked:bg-gradient-to-br peer-checked:from-yellow-900/80 peer-checked:to-pink-900/80 peer-checked:text-yellow-300 peer-checked:border-yellow-500/50 peer-checked:shadow-lg peer-checked:shadow-yellow-500/20 transition-all duration-300 border border-gray-700 hover:border-gray-600">
                                <i class="fas fa-<?php echo e($icon); ?> text-xl mb-1"></i>
                                <span class="text-xs capitalize"><?php echo e($icon); ?></span>
                            </label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Select an icon that best represents this category</p>
                </div>

                <div>
                    <label for="color" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-palette text-orange-400 mr-2"></i>
                        Category Color
                    </label>
                    <div class="grid grid-cols-5 md:grid-cols-10 gap-3 p-4 bg-gray-900/70 rounded-xl border border-gray-700/50">
                        <?php $__currentLoopData = ['blue', 'green', 'red', 'yellow', 'purple', 'pink', 'indigo', 'teal', 'orange', 'cyan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <input type="radio" name="color" id="color-<?php echo e($color); ?>" value="<?php echo e($color); ?>" class="hidden peer" <?php echo e(old('color') == $color ? 'checked' : ''); ?>>
                            <label for="color-<?php echo e($color); ?>" class="block w-full h-12 rounded-lg cursor-pointer bg-gradient-to-br from-<?php echo e($color); ?>-500 to-<?php echo e($color); ?>-600 peer-checked:ring-2 peer-checked:ring-<?php echo e($color); ?>-400 peer-checked:shadow-lg peer-checked:shadow-<?php echo e($color); ?>-500/20 hover:shadow-md hover:scale-105 transition-all duration-300 border-2 border-transparent peer-checked:border-white/20"></label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Choose a color theme that will be used throughout the category display</p>
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
                <a href="<?php echo e(route('admin.categories')); ?>" class="group px-6 py-3 bg-gray-800/80 hover:bg-gray-700/80 text-gray-300 hover:text-white border border-gray-600/50 hover:border-gray-500/50 font-medium rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Cancel</span>
                </a>
                <button type="submit" class="group px-6 py-3 bg-gradient-to-r from-yellow-600 to-pink-600 hover:from-yellow-500 hover:to-pink-500 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-yellow-500/20">
                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    <span>Create Category</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation enhancement
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const nameInput = document.getElementById('name');

        form.addEventListener('submit', function(e) {
            // Add loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Creating Category...</span>';
            submitButton.disabled = true;

            // Re-enable if there are validation errors (will be handled by page reload)
            setTimeout(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-save mr-2"></i><span>Create Category</span>';
            }, 5000);
        });

        // Real-time name validation
        nameInput.addEventListener('input', function() {
            const value = this.value.trim();
            if (value.length > 0 && value.length < 3) {
                this.style.borderColor = '#ef4444';
                this.style.boxShadow = '0 0 0 2px rgba(239, 68, 68, 0.2)';
            } else {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            }
        });

        // Add smooth scroll to error section if errors exist
        const errorSection = document.querySelector('.bg-gradient-to-r.from-red-900');
        if (errorSection) {
            errorSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Icon selection feedback
        const iconInputs = document.querySelectorAll('input[name="icon"]');
        iconInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    // Add a subtle animation to show selection
                    const label = this.nextElementSibling;
                    label.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        label.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        });

        // Color selection feedback
        const colorInputs = document.querySelectorAll('input[name="color"]');
        colorInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    // Add a subtle animation to show selection
                    const label = this.nextElementSibling;
                    label.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        label.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/createCategory.blade.php ENDPATH**/ ?>