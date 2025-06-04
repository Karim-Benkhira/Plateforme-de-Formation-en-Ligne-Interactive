<?php $__env->startSection('title', 'Enrollment Requests'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Enrollment Requests</h1>
                    <p class="text-gray-300">Manage student enrollment requests for your courses</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white"><?php echo e($pendingEnrollments->count()); ?></div>
                        <div class="text-sm text-gray-300">Pending Requests</div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-emerald-500/20 border border-emerald-400/50 text-emerald-300 px-6 py-4 rounded-xl mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if($pendingEnrollments->count() > 0): ?>
            <!-- Pending Enrollments -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden">
                <div class="p-6 border-b border-white/10">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-clock mr-3 text-yellow-400"></i>
                        Pending Enrollment Requests
                    </h2>
                </div>

                <div class="divide-y divide-white/10">
                    <?php $__currentLoopData = $pendingEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-6 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Student Avatar -->
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <?php if($enrollment['student']->profile_image): ?>
                                            <img src="<?php echo e(asset('storage/' . $enrollment['student']->profile_image)); ?>" 
                                                 alt="<?php echo e($enrollment['student']->username); ?>" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        <?php else: ?>
                                            <span class="text-white font-medium text-lg">
                                                <?php echo e(strtoupper(substr($enrollment['student']->username, 0, 1))); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Student Info -->
                                    <div>
                                        <h3 class="text-white font-medium"><?php echo e($enrollment['student']->username); ?></h3>
                                        <p class="text-gray-400 text-sm"><?php echo e($enrollment['student']->email); ?></p>
                                        <p class="text-gray-500 text-xs">
                                            Requested <?php echo e($enrollment['requested_at']->diffForHumans()); ?>

                                        </p>
                                    </div>

                                    <!-- Course Info -->
                                    <div class="ml-8">
                                        <div class="bg-gray-800/50 rounded-lg p-3">
                                            <h4 class="text-white font-medium text-sm"><?php echo e($enrollment['course']->title); ?></h4>
                                            <p class="text-gray-400 text-xs"><?php echo e($enrollment['course']->category->name ?? 'No Category'); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-3">
                                    <!-- Approve Button -->
                                    <form action="<?php echo e(route('teacher.enrollments.approve', [$enrollment['course']->id, $enrollment['student']->id])); ?>" 
                                          method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center text-sm"
                                                onclick="return confirm('Are you sure you want to approve this enrollment?')">
                                            <i class="fas fa-check mr-2"></i>
                                            Approve
                                        </button>
                                    </form>

                                    <!-- Reject Button -->
                                    <form action="<?php echo e(route('teacher.enrollments.reject', [$enrollment['course']->id, $enrollment['student']->id])); ?>" 
                                          method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center text-sm"
                                                onclick="return confirm('Are you sure you want to reject this enrollment?')">
                                            <i class="fas fa-times mr-2"></i>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <!-- No Pending Requests -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-12 text-center">
                <div class="w-20 h-20 mx-auto bg-gray-700/50 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Pending Requests</h3>
                <p class="text-gray-400 mb-6">All enrollment requests have been processed.</p>
                <a href="<?php echo e(route('teacher.courses')); ?>" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Courses
                </a>
            </div>
        <?php endif; ?>

        <!-- Course Summary -->
        <?php if($courses->count() > 0): ?>
            <div class="mt-8 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-blue-400"></i>
                    Course Enrollment Summary
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-800/50 rounded-lg p-4">
                            <h4 class="text-white font-medium mb-2"><?php echo e($course->title); ?></h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Pending:</span>
                                    <span class="text-yellow-400"><?php echo e($course->pendingEnrollments->count()); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Approved:</span>
                                    <span class="text-emerald-400"><?php echo e($course->approvedEnrollments->count()); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Total Students:</span>
                                    <span class="text-blue-400"><?php echo e($course->users->count()); ?></span>
                                </div>
                            </div>
                            <a href="<?php echo e(route('teacher.enrollments.course-students', $course->id)); ?>" 
                               class="mt-3 text-blue-400 hover:text-blue-300 text-xs inline-flex items-center">
                                <i class="fas fa-users mr-1"></i>
                                View Students
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Auto-refresh pending count every 30 seconds
setInterval(function() {
    fetch('<?php echo e(route("teacher.enrollments.pending-count")); ?>')
        .then(response => response.json())
        .then(data => {
            // Update any pending count displays
            const countElements = document.querySelectorAll('.pending-count');
            countElements.forEach(element => {
                element.textContent = data.count;
            });
        })
        .catch(error => console.log('Error fetching pending count:', error));
}, 30000);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/enrollments/index.blade.php ENDPATH**/ ?>