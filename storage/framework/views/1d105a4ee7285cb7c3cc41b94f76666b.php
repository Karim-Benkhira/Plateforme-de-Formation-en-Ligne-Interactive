<?php $__env->startSection('title', 'Browser Sessions'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-laptop mr-3 text-blue-300"></i>
                Browser Sessions
            </h1>
            <p class="text-blue-100 opacity-90">Manage and log out your active sessions on other browsers and devices.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('profile.edit')); ?>" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Profile
            </a>
        </div>
    </div>
</div>

<?php if(session('status')): ?>
    <div class="mb-6 bg-green-900/40 border border-green-700/50 text-green-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-green-600/5"></div>
        <div class="relative flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-2 text-xl"></i>
            <span><?php echo e(session('status')); ?></span>
        </div>
    </div>
<?php endif; ?>

<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
    <div class="relative">
        <div class="max-w-3xl text-gray-300 mb-8">
            <p class="flex items-start">
                <i class="fas fa-info-circle text-blue-400 mr-2 mt-1"></i>
                If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
            </p>
        </div>
        
        <?php if(count($sessions) > 0): ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50 shadow-inner flex items-center group hover:bg-gray-800 transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg overflow-hidden 
                                <?php if($session->agent->is_desktop): ?>
                                    bg-gradient-to-br from-indigo-800 to-indigo-900 text-indigo-400 border border-indigo-700/50
                                <?php else: ?>
                                    bg-gradient-to-br from-purple-800 to-purple-900 text-purple-400 border border-purple-700/50
                                <?php endif; ?>
                                flex items-center justify-center shadow-inner">
                                <?php if($session->agent->is_desktop): ?>
                                    <i class="fas fa-desktop text-xl"></i>
                                <?php else: ?>
                                    <i class="fas fa-mobile-alt text-xl"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="ml-4 flex-1">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <h3 class="text-base font-medium text-white mb-1 sm:mb-0">
                                    <?php echo e($session->agent->platform); ?> - <?php echo e($session->agent->browser); ?>

                                </h3>
                                <?php if($session->is_current_device): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900/50 text-green-300 border border-green-700/50">
                                        <i class="fas fa-circle text-xs mr-1.5 text-green-400"></i>
                                        This device
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-800/80 text-gray-300 border border-gray-700/50">
                                    <i class="fas fa-map-marker-alt mr-1.5 text-blue-400"></i>
                                    <?php echo e($session->ip_address); ?>

                                </span>
                                <?php if(!$session->is_current_device): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-800/80 text-gray-300 border border-gray-700/50">
                                        <i class="fas fa-clock mr-1.5 text-purple-400"></i>
                                        Last active <?php echo e($session->last_active); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="mt-8 flex items-center">
                <button type="button" id="logoutOtherSessionsButton" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-sign-out-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Log Out Other Browser Sessions
                </button>
                
                <div id="logoutOtherSessionsSpinner" class="ml-3 hidden">
                    <i class="fas fa-circle-notch fa-spin text-blue-400 text-xl"></i>
                </div>
            </div>
        <?php else: ?>
            <div class="py-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800/80 text-gray-400 mb-4">
                    <i class="fas fa-laptop text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-400 mb-2">No Active Sessions</h3>
                <p class="text-gray-500">There are no active browser sessions to display at this time.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Log Out Other Devices Confirmation Modal -->
<div id="logoutOtherSessionsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-red-800/5"></div>
                <div class="relative">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900/50 text-red-400 border border-red-700/50 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Log Out Other Browser Sessions
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-300">
                                    Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.
                                </p>
                                
                                <div class="mt-4">
                                    <form id="logoutOtherSessionsForm" action="<?php echo e(route('profile.sessions.destroy')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password <span class="text-red-500">*</span></label>
                                            <div class="relative group">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <i class="fas fa-lock text-gray-500 group-hover:text-red-400 transition-colors duration-200"></i>
                                                </div>
                                                <input type="password" id="password" name="password" required
                                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200" />
                                            </div>
                                            <div id="passwordError" class="mt-2 text-sm text-red-400 hidden"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button" id="confirmLogoutOtherSessions" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-medium transition-all duration-200 sm:ml-3 sm:w-auto sm:text-sm">
                            Log Out Other Browser Sessions
                        </button>
                        <button type="button" id="cancelLogoutOtherSessions" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-gray-800 text-gray-300 font-medium hover:bg-gray-700 transition-all duration-200 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutOtherSessionsButton = document.getElementById('logoutOtherSessionsButton');
        const logoutOtherSessionsModal = document.getElementById('logoutOtherSessionsModal');
        const cancelLogoutOtherSessions = document.getElementById('cancelLogoutOtherSessions');
        const confirmLogoutOtherSessions = document.getElementById('confirmLogoutOtherSessions');
        const logoutOtherSessionsForm = document.getElementById('logoutOtherSessionsForm');
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');
        const logoutOtherSessionsSpinner = document.getElementById('logoutOtherSessionsSpinner');
        
        // Show modal
        logoutOtherSessionsButton.addEventListener('click', function() {
            logoutOtherSessionsModal.classList.remove('hidden');
            passwordInput.focus();
        });
        
        // Hide modal
        cancelLogoutOtherSessions.addEventListener('click', function() {
            logoutOtherSessionsModal.classList.add('hidden');
            passwordInput.value = '';
            passwordError.classList.add('hidden');
            passwordError.textContent = '';
        });
        
        // Submit form
        confirmLogoutOtherSessions.addEventListener('click', function() {
            if (passwordInput.value === '') {
                passwordError.textContent = 'Please enter your password.';
                passwordError.classList.remove('hidden');
                return;
            }
            
            logoutOtherSessionsSpinner.classList.remove('hidden');
            logoutOtherSessionsForm.submit();
        });
        
        // Close modal when clicking outside
        logoutOtherSessionsModal.addEventListener('click', function(event) {
            if (event.target === logoutOtherSessionsModal) {
                logoutOtherSessionsModal.classList.add('hidden');
                passwordInput.value = '';
                passwordError.classList.add('hidden');
                passwordError.textContent = '';
            }
        });
        
        // Handle escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !logoutOtherSessionsModal.classList.contains('hidden')) {
                logoutOtherSessionsModal.classList.add('hidden');
                passwordInput.value = '';
                passwordError.classList.add('hidden');
                passwordError.textContent = '';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/profile/sessions-new.blade.php ENDPATH**/ ?>