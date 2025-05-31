<?php $__env->startSection('title', 'Course Builder - Create Amazing Courses'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .gradient-rose-purple {
        background: linear-gradient(135deg, #fb7185 0%, #c084fc 100%);
    }
    .gradient-purple-pink {
        background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
    }
    .stats-card {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
        border: 1px solid rgba(236, 72, 153, 0.2);
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

    <div class="flex items-center justify-between relative z-10">
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">✨ Course Builder</h1>
            <p class="text-pink-100 text-lg">Create professional courses with beautiful design and multiple sections</p>
        </div>
        <a href="<?php echo e(route('teacher.course-builder.create')); ?>"
           class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl transition-all flex items-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-3 text-lg"></i>
            Create New Course
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card rounded-2xl p-6 card-hover backdrop-blur-sm">
        <div class="flex items-center">
            <div class="p-4 rounded-2xl gradient-pink-blue text-white mr-4 shadow-lg">
                <i class="fas fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium">Total Courses</p>
                <p class="text-3xl font-bold text-white"><?php echo e($courses->total()); ?></p>
            </div>
        </div>
    </div>

    <div class="stats-card rounded-2xl p-6 card-hover backdrop-blur-sm">
        <div class="flex items-center">
            <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white mr-4 shadow-lg">
                <i class="fas fa-eye text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium">Published</p>
                <p class="text-3xl font-bold text-white"><?php echo e($courses->where('is_published', true)->count()); ?></p>
            </div>
        </div>
    </div>

    <div class="stats-card rounded-2xl p-6 card-hover backdrop-blur-sm">
        <div class="flex items-center">
            <div class="p-4 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white mr-4 shadow-lg">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium">Drafts</p>
                <p class="text-3xl font-bold text-white"><?php echo e($courses->where('is_published', false)->count()); ?></p>
            </div>
        </div>
    </div>

    <div class="stats-card rounded-2xl p-6 card-hover backdrop-blur-sm">
        <div class="flex items-center">
            <div class="p-4 rounded-2xl gradient-purple-pink text-white mr-4 shadow-lg">
                <i class="fas fa-play-circle text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium">Total Lessons</p>
                <p class="text-3xl font-bold text-white"><?php echo e($courses->sum('lessons_count')); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Courses Grid -->
<?php if($courses->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-pink-500/20 hover:border-pink-400/50 transition-all card-hover">
                <!-- Course Image -->
                <div class="aspect-video bg-gradient-to-br from-pink-500/20 to-purple-600/20 relative">
                    <img src="<?php echo e($course->thumbnail_url); ?>" alt="<?php echo e($course->title); ?>"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center gradient-pink-blue\'><i class=\'fas fa-graduation-cap text-4xl text-white\'></i></div>';"
                         loading="lazy">

                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium backdrop-blur-sm <?php echo e($course->is_published ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white'); ?>">
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
                           class="flex-1 gradient-pink-blue hover:opacity-90 text-white py-3 px-4 rounded-xl text-center transition-all font-medium shadow-lg">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        <button onclick="previewCourse(<?php echo e($course->id); ?>)"
                                class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-3 px-4 rounded-xl transition-all font-medium shadow-lg">
                            <i class="fas fa-eye mr-2"></i>
                            Preview
                        </button>
                        <button onclick="deleteCourse(<?php echo e($course->id); ?>)"
                                class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white py-3 px-4 rounded-xl transition-all shadow-lg">
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
    <div class="text-center py-20">
        <div class="mx-auto mb-8">
            <div class="w-32 h-32 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-graduation-cap text-6xl text-white"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4">✨ No Courses Yet</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto text-lg">
            Start creating amazing professional courses with our beautiful course builder.
            Add sections, lessons, and multimedia content easily.
        </p>
        <a href="<?php echo e(route('teacher.course-builder.create')); ?>"
           class="gradient-pink-blue hover:opacity-90 text-white px-10 py-4 rounded-xl transition-all inline-flex items-center font-medium shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-3 text-lg"></i>
            Create Your First Course
        </a>
    </div>
<?php endif; ?>

<!-- Info Section -->
<div class="mt-12 bg-gradient-to-r from-pink-900/20 via-purple-900/20 to-blue-900/20 border border-pink-500/30 rounded-2xl p-8 backdrop-blur-sm">
    <h3 class="text-2xl font-bold text-pink-300 mb-6 flex items-center">
        <i class="fas fa-sparkles mr-3 text-pink-400"></i>
        ✨ Course Builder Features
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-pink-100">
        <div class="flex items-start p-4 rounded-xl bg-pink-500/10 border border-pink-500/20">
            <div class="p-3 rounded-xl gradient-pink-blue mr-4 flex-shrink-0">
                <i class="fas fa-layer-group text-white text-xl"></i>
            </div>
            <div>
                <strong class="block mb-2 text-pink-200 text-lg">Organized Sections</strong>
                <p class="text-pink-100/80">Structure your content into logical sections like Udemy</p>
            </div>
        </div>
        <div class="flex items-start p-4 rounded-xl bg-purple-500/10 border border-purple-500/20">
            <div class="p-3 rounded-xl gradient-purple-pink mr-4 flex-shrink-0">
                <i class="fas fa-video text-white text-xl"></i>
            </div>
            <div>
                <strong class="block mb-2 text-purple-200 text-lg">Multiple Content Types</strong>
                <p class="text-purple-100/80">Add videos, PDFs, text content, and more</p>
            </div>
        </div>
        <div class="flex items-start p-4 rounded-xl bg-blue-500/10 border border-blue-500/20">
            <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 mr-4 flex-shrink-0">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <div>
                <strong class="block mb-2 text-blue-200 text-lg">Progress Tracking</strong>
                <p class="text-blue-100/80">Track student progress through lessons</p>
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