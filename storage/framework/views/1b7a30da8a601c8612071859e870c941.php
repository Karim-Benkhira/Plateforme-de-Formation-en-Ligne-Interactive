<?php $__env->startSection('title', 'Manage Courses'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Course Management</h1>
            <p class="text-blue-100">Create and manage courses for your learning platform.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.createCourse')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Course
            </a>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="section-title flex items-center">
            <i class="fas fa-book text-blue-500 mr-2"></i>
            All Courses
        </h2>
        <div class="flex items-center space-x-2">
            <div class="relative">
                <input type="text" id="course-search" placeholder="Search courses..." class="bg-gray-700 text-gray-200 border border-gray-600 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="rounded-tl-lg">Course Name</th>
                    <th>Category</th>
                    <th>Score</th>
                    <th>Students</th>
                    <th>Created</th>
                    <th class="rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="course-row">
                    <td>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold mr-3">
                                <?php echo e(strtoupper(substr($course->title, 0, 1))); ?>

                            </div>
                            <a href="<?php echo e(route('admin.showCourse', $course->id)); ?>" class="hover:text-blue-400 font-medium transition-colors">
                                <?php echo e($course->title); ?>

                            </a>
                        </div>
                    </td>
                    <td>
                        <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded-md text-xs">
                            <?php echo e($course->category->name ?? 'Uncategorized'); ?>

                        </span>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>
                            <span><?php echo e($course->score); ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <i class="fas fa-users text-blue-400 mr-1"></i>
                            <span><?php echo e($course->users->count()); ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="text-gray-400"><?php echo e($course->created_at->format('M d, Y')); ?></span>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('admin.showGenerateAIQuiz', $course->id)); ?>" class="btn btn-sm bg-purple-600 hover:bg-purple-700 text-white rounded-md transition-colors" title="Generate AI Quiz">
                                <i class="fas fa-robot"></i>
                            </a>
                            <a href="<?php echo e(route('admin.editCourse', $course->id)); ?>" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors" title="Edit Course">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.deleteCourse', $course->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors" onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.')" title="Delete Course">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <?php if(count($courses) == 0): ?>
    <div class="text-center py-8">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-book-open text-5xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-300 mb-2">No courses found</h3>
        <p class="text-gray-500">Get started by creating your first course</p>
        <a href="<?php echo e(route('admin.createCourse')); ?>" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
            <i class="fas fa-plus mr-2"></i> Add New Course
        </a>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('course-search');
        const courseRows = document.querySelectorAll('.course-row');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();

            courseRows.forEach(row => {
                const courseTitle = row.querySelector('a').textContent.toLowerCase();
                if (courseTitle.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/courses.blade.php ENDPATH**/ ?>