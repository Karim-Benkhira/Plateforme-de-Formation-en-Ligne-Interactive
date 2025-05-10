<?php $__env->startSection('title', 'Manage Courses'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Manage Courses</h1>
        <div>
            <a href="<?php echo e(route('teacher.courses.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Create New Course
            </a>
        </div>
    </div>

    <!-- Courses List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <?php if(count($courses) > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                            <th class="py-3 px-4 bg-gray-100 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <?php if($course->image): ?>
                                            <img class="h-10 w-10 rounded-full object-cover mr-4" src="<?php echo e(asset('storage/' . $course->image)); ?>" alt="<?php echo e($course->title); ?>">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-4">
                                                <i class="fas fa-book text-gray-400 dark:text-gray-300"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($course->title); ?></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(Str::limit($course->description, 50)); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">
                                    <?php echo e($course->category ? $course->category->name : 'Uncategorized'); ?>

                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo e($course->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e($course->is_published ? 'Published' : 'Draft'); ?>

                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">
                                    <?php echo e($course->created_at->format('M d, Y')); ?>

                                </td>
                                <td class="py-4 px-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="<?php echo e(route('teacher.courses.show', $course->id)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('teacher.generate-quiz', $course->id)); ?>" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                            <i class="fas fa-magic"></i>
                                        </a>
                                        <a href="<?php echo e(route('teacher.course-analytics', $course->id)); ?>" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <?php echo e($courses->links()); ?>

            </div>
        <?php else: ?>
            <div class="p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't created any courses yet.</p>
                <a href="<?php echo e(route('teacher.courses.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                    <i class="fas fa-plus mr-2"></i> Create Your First Course
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/teacher/courses.blade.php ENDPATH**/ ?>