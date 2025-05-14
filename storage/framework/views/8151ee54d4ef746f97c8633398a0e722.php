<?php $__env->startSection('title', 'Support Center'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Support Center</h1>
            <p class="text-blue-100">Get help with any issues or submit feedback about your learning experience.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="#submit-request" class="btn-white inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors shadow-md">
                <i class="fas fa-paper-plane mr-2"></i> New Request
            </a>
        </div>
    </div>
</div>

<!-- Support Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stats-card bg-gray-800 rounded-xl p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-primary-900 flex items-center justify-center mr-4 flex-shrink-0">
            <i class="fas fa-ticket-alt text-primary-400 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-400 text-sm">Total Requests</p>
            <p class="text-white text-2xl font-bold"><?php echo e(count($reclamations)); ?></p>
        </div>
    </div>

    <div class="stats-card bg-gray-800 rounded-xl p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-green-900 flex items-center justify-center mr-4 flex-shrink-0">
            <i class="fas fa-check-circle text-green-400 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-400 text-sm">Resolved</p>
            <p class="text-white text-2xl font-bold"><?php echo e($reclamations->where('status', 'resolved')->count()); ?></p>
        </div>
    </div>

    <div class="stats-card bg-gray-800 rounded-xl p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-yellow-900 flex items-center justify-center mr-4 flex-shrink-0">
            <i class="fas fa-clock text-yellow-400 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-400 text-sm">Pending</p>
            <p class="text-white text-2xl font-bold"><?php echo e($reclamations->where('status', 'pending')->count()); ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Support Guidelines -->
    <div class="lg:col-span-1 space-y-6">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-info-circle mr-2"></i> Support Guidelines
            </div>
            <div class="section-content">
                <div class="bg-gray-800 rounded-lg p-4 mb-4 transition-all duration-300 hover:bg-gray-700">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3 shadow-md">
                            <i class="fas fa-lightbulb text-primary-400"></i>
                        </div>
                        <h3 class="text-white font-semibold">Tips for Faster Support</h3>
                    </div>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mt-1 mr-2"></i>
                            <span>Describe your issue clearly and concisely</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mt-1 mr-2"></i>
                            <span>Include steps to reproduce the problem</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mt-1 mr-2"></i>
                            <span>Check FAQ before submitting technical issues</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-400 mt-1 mr-2"></i>
                            <span>Avoid submitting duplicate requests</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-question-circle mr-2"></i> Common Questions
            </div>
            <div class="section-content">
                <div class="space-y-3">
                    <div class="bg-gray-800 rounded-lg p-4 mb-2 transition-all duration-300 hover:bg-gray-700">
                        <button class="flex items-center justify-between w-full text-left text-white font-medium">
                            <span>How long until I get a response?</span>
                            <i class="fas fa-chevron-down text-primary-400"></i>
                        </button>
                        <div class="mt-3 text-gray-300 text-sm border-t border-gray-700 pt-3">
                            Our support team typically responds within 24-48 hours on business days.
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4 mb-2 transition-all duration-300 hover:bg-gray-700">
                        <button class="flex items-center justify-between w-full text-left text-white font-medium">
                            <span>Can I update my request?</span>
                            <i class="fas fa-chevron-down text-primary-400"></i>
                        </button>
                        <div class="mt-3 text-gray-300 text-sm border-t border-gray-700 pt-3">
                            You can submit a new request with additional information referencing your previous request.
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4 transition-all duration-300 hover:bg-gray-700">
                        <button class="flex items-center justify-between w-full text-left text-white font-medium">
                            <span>What if my issue is urgent?</span>
                            <i class="fas fa-chevron-down text-primary-400"></i>
                        </button>
                        <div class="mt-3 text-gray-300 text-sm border-t border-gray-700 pt-3">
                            For urgent issues, please mark your request as "Urgent" in the description.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Request & History -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Submit Request -->
        <div class="section-card" id="submit-request">
            <div class="section-header">
                <i class="fas fa-paper-plane mr-2"></i> Submit a Support Request
            </div>
            <div class="section-content">
                <?php if(session('success')): ?>
                    <div class="mb-6 p-4 bg-green-900 bg-opacity-40 border border-green-700 text-green-300 rounded-lg flex items-start">
                        <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Success!</h4>
                            <p><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mb-6 p-4 bg-red-900 bg-opacity-40 border border-red-700 text-red-300 rounded-lg flex items-start">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Error</h4>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p><?php echo e($error); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('student.support.submit')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="message" class="block text-gray-300 mb-2 font-medium">Describe your issue or suggestion</label>
                        <textarea
                            name="message"
                            id="message"
                            rows="5"
                            placeholder="Please provide as much detail as possible..."
                            required
                            class="w-full p-4 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                        ></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 flex items-center shadow-md">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Request History -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-history mr-2"></i> Request History
            </div>
            <div class="section-content">
                <?php if(count($reclamations) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-800 text-gray-400 text-sm uppercase">
                                    <th class="py-3 px-4 text-left rounded-tl-lg">Date</th>
                                    <th class="py-3 px-4 text-left">Message</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-left rounded-tr-lg">Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $reclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="<?php echo e($loop->even ? 'bg-gray-800 bg-opacity-40' : 'bg-gray-800 bg-opacity-20'); ?> hover:bg-gray-700 transition-colors">
                                        <td class="py-4 px-4 text-left text-gray-400 whitespace-nowrap">
                                            <?php echo e($rec->created_at->format('M d, Y')); ?>

                                            <div class="text-xs"><?php echo e($rec->created_at->format('h:i A')); ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-left">
                                            <div class="text-white line-clamp-2"><?php echo e($rec->message); ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <?php if($rec->status === 'resolved'): ?>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                                    <i class="fas fa-check-circle mr-1"></i> Resolved
                                                </span>
                                            <?php elseif($rec->status === 'pending'): ?>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-900 text-yellow-300">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-900 text-primary-300">
                                                    <i class="fas fa-sync-alt mr-1"></i> <?php echo e(ucfirst($rec->status)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-4 text-left">
                                            <?php if($rec->response): ?>
                                                <div class="text-white line-clamp-2"><?php echo e($rec->response); ?></div>
                                                <?php if($rec->agent): ?>
                                                    <div class="text-xs text-gray-400 mt-1">
                                                        Responded by: <?php echo e($rec->agent->name ?? 'Support Agent'); ?>

                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-500">No response yet</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-gray-600">
                            <i class="fas fa-ticket-alt text-gray-500 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Requests Yet</h3>
                        <p class="text-gray-400">You haven't submitted any support requests yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/support.blade.php ENDPATH**/ ?>