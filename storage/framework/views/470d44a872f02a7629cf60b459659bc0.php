<?php $__env->startSection('title', 'Course Builder - Udemy Style'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Course Builder</h1>
            <p class="text-blue-100">Create professional courses like Udemy with multiple sections and lessons</p>
        </div>
        <a href="<?php echo e(route('teacher.course-builder.create')); ?>"
           class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg transition-all flex items-center font-medium">
            <i class="fas fa-plus mr-2"></i>
            Create New Course
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gray-900 rounded-lg p-6 border border-gray-800">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Courses</p>
                <p class="text-2xl font-bold text-white"><?php echo e($courses->total()); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 rounded-lg p-6 border border-gray-800">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-eye text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Published</p>
                <p class="text-2xl font-bold text-white"><?php echo e($courses->where('is_published', true)->count()); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 rounded-lg p-6 border border-gray-800">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-edit text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Drafts</p>
                <p class="text-2xl font-bold text-white"><?php echo e($courses->where('is_published', false)->count()); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 rounded-lg p-6 border border-gray-800">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-play-circle text-white text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Lessons</p>
                <p class="text-2xl font-bold text-white"><?php echo e($courses->sum('lessons_count')); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Courses Grid -->
<?php if($courses->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-800 hover:border-blue-500 transition-all">
                <!-- Course Image -->
                <div class="aspect-video bg-gray-800 relative">
                    <img src="<?php echo e($course->thumbnail_url); ?>" alt="<?php echo e($course->title); ?>"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><i class=\'fas fa-graduation-cap text-4xl text-gray-600\'></i></div>';"
                         loading="lazy">

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($course->is_published ? 'bg-green-500 text-white' : 'bg-yellow-500 text-black'); ?>">
                            <?php echo e($course->status_label); ?>

                        </span>
                    </div>
                </div>

                <!-- Course Info -->
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2"><?php echo e($course->title); ?></h3>
                        <p class="text-gray-400 text-sm line-clamp-2"><?php echo e($course->description); ?></p>
                    </div>

                    <!-- Course Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                        <div>
                            <p class="text-xl font-bold text-blue-400"><?php echo e($course->sections_count); ?></p>
                            <p class="text-xs text-gray-500">Sections</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-green-400"><?php echo e($course->lessons_count); ?></p>
                            <p class="text-xs text-gray-500">Lessons</p>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-purple-400"><?php echo e($course->difficulty_label); ?></p>
                            <p class="text-xs text-gray-500">Level</p>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                            <i class="fas fa-folder mr-1"></i>
                            <?php echo e($course->category->name); ?>

                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('teacher.course-builder.edit', $course->id)); ?>"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center transition-all">
                            <i class="fas fa-edit mr-1"></i>
                            Edit
                        </a>
                        <button onclick="previewCourse(<?php echo e($course->id); ?>)"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-all">
                            <i class="fas fa-eye mr-1"></i>
                            Preview
                        </button>
                        <button onclick="deleteCourse(<?php echo e($course->id); ?>)"
                                class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg transition-all">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-3 bg-gray-800 border-t border-gray-700">
                    <div class="flex items-center justify-between text-sm text-gray-400">
                        <span>Created <?php echo e($course->created_at->diffForHumans()); ?></span>
                        <span>Updated <?php echo e($course->updated_at->diffForHumans()); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        <?php echo e($courses->links()); ?>

    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="mx-auto h-24 w-24 text-gray-600 mb-6">
            <i class="fas fa-graduation-cap text-6xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-400 mb-4">No Courses Yet</h3>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            Start creating professional courses with our Udemy-style course builder.
            Add sections, lessons, and multimedia content easily.
        </p>
        <a href="<?php echo e(route('teacher.course-builder.create')); ?>"
           class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-all inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Create Your First Course
        </a>
    </div>
<?php endif; ?>

<!-- Info Section -->
<div class="mt-12 bg-gradient-to-r from-blue-900/20 to-purple-900/20 border border-blue-500/30 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-blue-300 mb-4 flex items-center">
        <i class="fas fa-lightbulb mr-2"></i>
        Course Builder Features
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-blue-200">
        <div class="flex items-start">
            <i class="fas fa-layer-group text-blue-400 mr-3 mt-1"></i>
            <div>
                <strong class="block mb-1">Organized Sections</strong>
                <p>Structure your content into logical sections like Udemy</p>
            </div>
        </div>
        <div class="flex items-start">
            <i class="fas fa-video text-blue-400 mr-3 mt-1"></i>
            <div>
                <strong class="block mb-1">Multiple Content Types</strong>
                <p>Add videos, PDFs, text content, and more</p>
            </div>
        </div>
        <div class="flex items-start">
            <i class="fas fa-chart-line text-blue-400 mr-3 mt-1"></i>
            <div>
                <strong class="block mb-1">Progress Tracking</strong>
                <p>Track student progress through lessons</p>
            </div>
        </div>
    </div>
</div>

<script>
function previewCourse(courseId) {
    // Open course preview in new tab
    window.open(`/courses/${courseId}`, '_blank');
}

function deleteCourse(courseId) {
    if (confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        fetch(`/teacher/course-builder/${courseId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting course');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting course');
        });
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/course-builder/index.blade.php ENDPATH**/ ?>