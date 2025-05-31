<?php $__env->startSection('title', 'Create New Course - Beautiful Design'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .form-card {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        border: 1px solid rgba(236, 72, 153, 0.2);
        backdrop-filter: blur(10px);
    }
    .input-focus {
        transition: all 0.3s ease;
    }
    .input-focus:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
        <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="flex items-center relative z-10">
        <a href="<?php echo e(route('teacher.course-builder.index')); ?>" class="mr-6 text-white hover:text-pink-100 transition-colors transform hover:scale-110">
            <i class="fas fa-arrow-left text-2xl"></i>
        </a>
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">✨ Create New Course</h1>
            <p class="text-pink-100 text-lg">Build amazing courses with beautiful design and multiple sections</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="form-card rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="gradient-pink-blue px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-sparkles mr-3 text-pink-200"></i>
                ✨ Course Basic Information
            </h2>
        </div>

        <!-- Form -->
        <div class="p-8">
            <form action="<?php echo e(route('teacher.course-builder.store')); ?>" method="POST" enctype="multipart/form-data" id="course-form">
                <?php echo csrf_field(); ?>

                <!-- Course Title -->
                <div class="mb-8">
                    <label for="title" class="block text-white text-lg font-medium mb-4">
                        <i class="fas fa-heading text-pink-400 mr-2"></i>
                        Course Title
                    </label>
                    <input type="text" name="title" id="title" required
                        class="w-full bg-gray-800/50 text-white border-2 border-pink-500/30 rounded-xl py-4 px-5 input-focus backdrop-blur-sm"
                        placeholder="e.g., Complete Web Development Bootcamp 2024"
                        value="<?php echo e(old('title')); ?>">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-400 text-sm mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Course Description -->
                <div class="mb-8">
                    <label for="description" class="block text-white text-lg font-medium mb-4">
                        <i class="fas fa-align-left text-purple-400 mr-2"></i>
                        Course Description
                    </label>
                    <textarea name="description" id="description" rows="5" required
                        class="w-full bg-gray-800/50 text-white border-2 border-purple-500/30 rounded-xl py-4 px-5 input-focus backdrop-blur-sm"
                        placeholder="Describe what students will learn in this course..."><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-400 text-sm mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Category and Level -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-white text-lg font-medium mb-4">
                            <i class="fas fa-folder text-blue-400 mr-2"></i>
                            Category
                        </label>
                        <select name="category_id" id="category_id" required
                            class="w-full bg-gray-800/50 text-white border-2 border-blue-500/30 rounded-xl py-4 px-5 input-focus backdrop-blur-sm">
                            <option value="">Select Category</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-400 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Level -->
                    <div>
                        <label for="level" class="block text-white text-lg font-medium mb-4">
                            <i class="fas fa-signal text-cyan-400 mr-2"></i>
                            Difficulty Level
                        </label>
                        <select name="level" id="level" required
                            class="w-full bg-gray-800/50 text-white border-2 border-cyan-500/30 rounded-xl py-4 px-5 input-focus backdrop-blur-sm">
                            <option value="">Select Level</option>
                            <option value="beginner" <?php echo e(old('level') == 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                            <option value="intermediate" <?php echo e(old('level') == 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                            <option value="advanced" <?php echo e(old('level') == 'advanced' ? 'selected' : ''); ?>>Advanced</option>
                        </select>
                        <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-400 text-sm mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Course Image -->
                <div class="mb-6">
                    <label class="block text-white text-lg font-medium mb-3">
                        <i class="fas fa-image text-blue-400 mr-2"></i>
                        Course Thumbnail
                    </label>
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700">
                        <div class="flex flex-col md:flex-row items-start md:items-center">
                            <div class="w-full md:w-1/2 mb-6 md:mb-0">
                                <input type="file" name="image" id="image" class="hidden" accept="image/*">
                                <label for="image" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg cursor-pointer hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg">
                                    <i class="fas fa-cloud-upload-alt text-xl mr-2"></i>
                                    <span class="font-medium">Choose Image</span>
                                </label>
                                <p class="text-gray-400 text-sm mt-2">Recommended: 1280x720 pixels</p>
                            </div>
                            <div class="w-full md:w-1/2 md:ml-6">
                                <div class="aspect-video bg-gray-700 rounded-lg flex items-center justify-center" id="image-preview-container">
                                    <div id="image-placeholder" class="text-center">
                                        <i class="fas fa-image text-4xl text-gray-500 mb-2"></i>
                                        <p class="text-gray-400">Image Preview</p>
                                    </div>
                                    <img id="image-preview" class="w-full h-full object-cover rounded-lg hidden" alt="Course thumbnail">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-400 text-sm mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Publishing Options -->
                <div class="mb-8">
                    <div class="bg-gray-800 rounded-lg p-6 border-2 border-gray-700">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-globe text-blue-400 mr-2"></i>
                            Publishing Options
                        </h3>
                        <div class="flex items-center">
                            <input type="checkbox" id="is_published" name="is_published" value="1"
                                class="w-5 h-5 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="is_published" class="ml-3 text-white font-medium">
                                Publish course immediately
                            </label>
                        </div>
                        <p class="text-gray-400 text-sm mt-2">
                            You can always publish later after adding sections and lessons
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="<?php echo e(route('teacher.course-builder.index')); ?>"
                        class="w-full sm:w-auto px-10 py-4 bg-gray-700/50 text-white rounded-xl hover:bg-gray-600/50 transition-all flex items-center justify-center backdrop-blur-sm border border-gray-600/50">
                        <i class="fas fa-arrow-left mr-3"></i>
                        Cancel
                    </a>

                    <button type="submit"
                        class="w-full sm:w-auto px-10 py-4 gradient-pink-blue hover:opacity-90 text-white rounded-xl transition-all flex items-center justify-center font-medium shadow-xl transform hover:scale-105">
                        <i class="fas fa-sparkles mr-3"></i>
                        Create Course & Add Content
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mt-8 bg-gradient-to-r from-pink-900/20 via-purple-900/20 to-blue-900/20 border border-pink-500/30 rounded-2xl p-8 backdrop-blur-sm">
        <h3 class="text-2xl font-bold text-pink-300 mb-6 flex items-center">
            <i class="fas fa-magic mr-3 text-pink-400"></i>
            ✨ What's Next?
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-pink-100">
            <div class="flex items-start p-4 rounded-xl bg-pink-500/10 border border-pink-500/20">
                <div class="p-3 rounded-xl gradient-pink-blue mr-4 flex-shrink-0">
                    <i class="fas fa-layer-group text-white text-lg"></i>
                </div>
                <div>
                    <strong class="block mb-2 text-pink-200">Add Sections</strong>
                    <p class="text-pink-100/80">Organize your content into logical sections</p>
                </div>
            </div>
            <div class="flex items-start p-4 rounded-xl bg-purple-500/10 border border-purple-500/20">
                <div class="p-3 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 mr-4 flex-shrink-0">
                    <i class="fas fa-play-circle text-white text-lg"></i>
                </div>
                <div>
                    <strong class="block mb-2 text-purple-200">Upload Lessons</strong>
                    <p class="text-purple-100/80">Add videos, PDFs, and text content</p>
                </div>
            </div>
            <div class="flex items-start p-4 rounded-xl bg-blue-500/10 border border-blue-500/20">
                <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 mr-4 flex-shrink-0">
                    <i class="fas fa-rocket text-white text-lg"></i>
                </div>
                <div>
                    <strong class="block mb-2 text-blue-200">Publish</strong>
                    <p class="text-blue-100/80">Make your course available to students</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image preview
document.getElementById('image').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('image-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/course-builder/create.blade.php ENDPATH**/ ?>