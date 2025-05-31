<?php $__env->startSection('title', 'Create New Course - Udemy Style'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex items-center">
        <a href="<?php echo e(route('teacher.course-builder.index')); ?>" class="mr-4 text-white hover:text-blue-100 transition-colors">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white">Create New Course</h1>
            <p class="text-blue-100">Build your course like Udemy - with multiple sections and lessons</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-graduation-cap mr-3"></i>
                Course Basic Information
            </h2>
        </div>

        <!-- Form -->
        <div class="p-8">
            <form action="<?php echo e(route('teacher.course-builder.store')); ?>" method="POST" enctype="multipart/form-data" id="course-form">
                <?php echo csrf_field(); ?>
                
                <!-- Course Title -->
                <div class="mb-6">
                    <label for="title" class="block text-white text-lg font-medium mb-3">
                        <i class="fas fa-heading text-blue-400 mr-2"></i>
                        Course Title
                    </label>
                    <input type="text" name="title" id="title" required
                        class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
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
                <div class="mb-6">
                    <label for="description" class="block text-white text-lg font-medium mb-3">
                        <i class="fas fa-align-left text-blue-400 mr-2"></i>
                        Course Description
                    </label>
                    <textarea name="description" id="description" rows="5" required
                        class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-white text-lg font-medium mb-3">
                            <i class="fas fa-folder text-blue-400 mr-2"></i>
                            Category
                        </label>
                        <select name="category_id" id="category_id" required
                            class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors">
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
                        <label for="level" class="block text-white text-lg font-medium mb-3">
                            <i class="fas fa-signal text-blue-400 mr-2"></i>
                            Difficulty Level
                        </label>
                        <select name="level" id="level" required
                            class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors">
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
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="<?php echo e(route('teacher.course-builder.index')); ?>" 
                        class="w-full sm:w-auto px-8 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-all flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancel
                    </a>
                    
                    <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all flex items-center justify-center font-medium shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Create Course & Add Content
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mt-8 bg-blue-900/20 border border-blue-500/30 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-300 mb-3 flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            What's Next?
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-200">
            <div class="flex items-start">
                <i class="fas fa-layer-group text-blue-400 mr-2 mt-1"></i>
                <div>
                    <strong>Add Sections</strong>
                    <p>Organize your content into logical sections</p>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-play-circle text-blue-400 mr-2 mt-1"></i>
                <div>
                    <strong>Upload Lessons</strong>
                    <p>Add videos, PDFs, and text content</p>
                </div>
            </div>
            <div class="flex items-start">
                <i class="fas fa-rocket text-blue-400 mr-2 mt-1"></i>
                <div>
                    <strong>Publish</strong>
                    <p>Make your course available to students</p>
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