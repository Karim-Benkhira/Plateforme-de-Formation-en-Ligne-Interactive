<?php $__env->startSection('title', 'Activity Log Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Activity Log Details</h1>
            <p class="text-blue-100">Detailed information about this activity log entry.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Activity Logs
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="data-card p-6">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Basic Information
            </h2>

            <?php if($activityLog->user): ?>
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-blue-900 rounded-full flex items-center justify-center mr-4">
                        <span class="text-blue-300 font-bold text-2xl"><?php echo e(substr($activityLog->user->username, 0, 1)); ?></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white"><?php echo e($activityLog->user->username); ?></h3>
                        <p class="text-gray-400"><?php echo e($activityLog->user->email); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-cogs text-gray-400 text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">System</h3>
                        <p class="text-gray-400">Automated action</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="py-3 px-4 bg-gray-800 rounded-lg mb-4">
                <div class="flex items-center justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Action</span>
                    <span class="text-white font-medium"><?php echo e($activityLog->action); ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Date</span>
                    <span class="text-white"><?php echo e($activityLog->created_at->format('F d, Y')); ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Time</span>
                    <span class="text-white"><?php echo e($activityLog->created_at->format('H:i:s')); ?></span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-400">IP Address</span>
                    <span class="text-white"><?php echo e($activityLog->ip_address ?? 'N/A'); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="data-card p-6 mb-6">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-file-alt text-purple-500 mr-2"></i>
                Activity Details
            </h2>

            <div class="mb-6">
                <h3 class="text-gray-300 font-medium mb-2">Description</h3>
                <div class="p-4 bg-gray-800 rounded-lg text-white">
                    <?php echo e($activityLog->description ?? 'No description available'); ?>

                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-gray-300 font-medium mb-2">User Agent</h3>
                <div class="p-4 bg-gray-800 rounded-lg text-gray-300 text-sm break-words">
                    <?php echo e($activityLog->user_agent ?? 'Not available'); ?>

                </div>
            </div>

            <?php if($activityLog->properties): ?>
                <div>
                    <h3 class="text-gray-300 font-medium mb-2">Properties</h3>
                    <div class="p-4 bg-gray-800 rounded-lg">
                        <pre class="text-sm text-blue-300 overflow-auto"><?php echo e(json_encode($activityLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/activity-logs/show.blade.php ENDPATH**/ ?>