

<?php $__env->startSection('title', 'Respond to Support Ticket'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0;
        }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Input focus effect */
    .input-focus-effect {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-focus-effect:focus-within {
        transform: translateY(-2px);
    }

    .input-focus-effect:focus-within::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -5px;
        height: 3px;
        background: linear-gradient(to right, #EF4444, #3B82F6);
        border-radius: 3px;
        opacity: 0.7;
    }

    /* Message card styling */
    .message-card {
        position: relative;
        overflow: hidden;
    }

    .message-card::before {
        content: "";
        position: absolute;
        top: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(to right, #EF4444, #3B82F6);
        border-radius: 3px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <div class="flex items-center mb-2">
                <a href="<?php echo e(route('admin.reclamations')); ?>" class="text-blue-300 hover:text-blue-200 transition-colors mr-2">
                    <i class="fas fa-arrow-left"></i> Back to Support Tickets
                </a>
                <span class="text-gray-400 mx-2">|</span>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-reply mr-3 text-red-300"></i>
                    Respond to Support Ticket
                </h1>
            </div>
            <p class="text-blue-100 opacity-90">Reply to user inquiry and resolve the ticket</p>
        </div>
    </div>
</div>

<!-- Response Form Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden max-w-3xl mx-auto">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-blue-800/5"></div>

    <div class="relative">
        <!-- Ticket Information -->
        <div class="message-card bg-gray-800/70 rounded-xl p-6 border border-gray-700/50 mb-8">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                    <span class="relative"><?php echo e(strtoupper(substr($reclamation->user->username ?? 'U', 0, 1))); ?></span>
                </div>
                <div>
                    <span class="font-medium text-white text-lg"><?php echo e($reclamation->user->username ?? 'Unknown'); ?></span>
                    <div class="text-gray-400 text-sm"><?php echo e($reclamation->user->email ?? ''); ?></div>
                </div>
                <div class="ml-auto">
                    <?php if($reclamation->status === 'resolved'): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900/50 text-green-300 border border-green-700/50">
                            <i class="fas fa-check-circle mr-1.5"></i> Resolved
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                            <i class="fas fa-clock mr-1.5"></i> Pending
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-gray-900/50 rounded-lg p-4 border border-gray-700/30 mb-2">
                <div class="flex items-start mb-2">
                    <div class="bg-red-900/70 text-red-400 rounded-lg p-1.5 mr-2 shadow-inner shadow-red-950/50 mt-0.5">
                        <i class="fas fa-comment-alt text-sm"></i>
                    </div>
                    <div class="text-gray-300 font-medium">User Message:</div>
                </div>
                <div class="text-gray-300 pl-8"><?php echo e($reclamation->message); ?></div>
            </div>

            <div class="text-gray-400 text-sm flex items-center">
                <i class="far fa-calendar-alt mr-2"></i>
                <span>Submitted on <?php echo e($reclamation->created_at->format('M d, Y \a\t h:i A')); ?></span>
            </div>
        </div>

        <!-- Response Form -->
        <form action="<?php echo e(route('admin.submitReclamationResponse', $reclamation->id)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="response" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-reply text-blue-400 mr-2"></i>
                    Your Response <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative input-focus-effect">
                    <textarea name="response" id="response" rows="5" required
                        class="w-full p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-300"
                        placeholder="Type your response here..."><?php echo e(old('response', $reclamation->response)); ?></textarea>
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">This response will be sent to the user and the ticket will be marked as resolved</p>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4 border-t border-gray-700/50">
                <a href="<?php echo e(route('admin.reclamations')); ?>" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-blue-600 hover:from-red-500 hover:to-blue-500 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-red-700/30">
                    <i class="fas fa-paper-plane mr-2"></i> Send Response & Resolve Ticket
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/respondReclamation.blade.php ENDPATH**/ ?>