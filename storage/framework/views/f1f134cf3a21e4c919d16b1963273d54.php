<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Two-Factor Authentication</h2>
                
                <?php if(session('status')): ?>
                    <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                    <div class="mb-6 bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
                
                <div class="mb-8">
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to sign in.
                    </p>
                    
                    <?php if($enabled): ?>
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Two-factor authentication is enabled</h3>
                                <p class="text-gray-600 dark:text-gray-400">Your account has an extra layer of security.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Two-factor authentication is not enabled</h3>
                                <p class="text-gray-600 dark:text-gray-400">Add an extra layer of security to your account.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if($enabled): ?>
                    <!-- Recovery Codes Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recovery Codes</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            Recovery codes can be used to access your account if you lose your two-factor authentication device. Keep these codes in a secure place; like a password manager or a safe.
                        </p>
                        
                        <?php if(session('recoveryCodes')): ?>
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md mb-4">
                                <div class="grid grid-cols-2 gap-2">
                                    <?php $__currentLoopData = session('recoveryCodes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="font-mono text-sm"><?php echo e($code); ?></div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md mb-4">
                                <div class="grid grid-cols-2 gap-2">
                                    <?php $__currentLoopData = $recoveryCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="font-mono text-sm"><?php echo e($code); ?></div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('profile.two-factor.regenerate-recovery-codes')); ?>" method="POST" class="mt-4">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                                Regenerate Recovery Codes
                            </button>
                        </form>
                    </div>
                    
                    <!-- Disable 2FA Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Disable Two-Factor Authentication</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            If you would like to disable two-factor authentication, please confirm your password.
                        </p>
                        
                        <form action="<?php echo e(route('profile.two-factor.disable')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                <input type="password" id="password" name="password" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Enter your current password">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-300">
                                Disable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <!-- Enable 2FA Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Setup Instructions</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <ol class="list-decimal list-inside space-y-3 text-gray-600 dark:text-gray-300">
                                    <li>Download a two-factor authentication app like Google Authenticator, Microsoft Authenticator, or Authy.</li>
                                    <li>Scan the QR code with your app, or manually enter the setup key.</li>
                                    <li>Enter the 6-digit code from your app and your current password to enable two-factor authentication.</li>
                                </ol>
                                
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Setup Key:</p>
                                    <div class="font-mono text-sm bg-gray-100 dark:bg-gray-700 p-2 rounded"><?php echo e($secretKey); ?></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-center">
                                <div class="bg-white p-2 rounded-lg">
                                    <?php echo $qrCode; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <form action="<?php echo e(route('profile.two-factor.enable')); ?>" method="POST" class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Authentication Code</label>
                            <input type="text" id="code" name="code" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Enter the 6-digit code">
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                            <input type="password" id="password" name="password" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" placeholder="Enter your current password">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                            Enable Two-Factor Authentication
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/auth/two-factor/show.blade.php ENDPATH**/ ?>