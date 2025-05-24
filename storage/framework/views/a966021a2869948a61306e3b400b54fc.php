<?php $__env->startSection('title', 'Two-Factor Authentication'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        /* Admin Color Scheme - Yellow/Pink */
        --admin-primary: #f59e0b;
        --admin-primary-dark: #d97706;
        --admin-primary-light: #fbbf24;
        --admin-secondary: #ec4899;
        --admin-secondary-dark: #db2777;
        --admin-secondary-light: #f472b6;
        --admin-accent: #fbbf24;
        --admin-accent-dark: #f59e0b;
        --admin-bg-primary: #1f2937;
        --admin-bg-secondary: #111827;
        --admin-text-primary: #f9fafb;
        --admin-text-secondary: #d1d5db;
        --admin-border: #374151;
    }

    @keyframes admin-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
        }
    }

    .admin-glow {
        animation: admin-glow 2s ease-in-out infinite;
    }

    .admin-gradient-bg {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
    }

    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-shield-alt mr-3 text-yellow-300"></i>
                Two-Factor Authentication
            </h1>
            <p class="text-yellow-100 opacity-90">Secure your account with an additional layer of protection.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('profile.edit')); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span>Back to Profile</span>
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

<?php if(session('error')): ?>
    <div class="mb-6 bg-red-900/40 border border-red-700/50 text-red-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-red-600/5"></div>
        <div class="relative flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-2 text-xl"></i>
            <span><?php echo e(session('error')); ?></span>
        </div>
    </div>
<?php endif; ?>

<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-yellow-500/20 hover:shadow-xl transition-all duration-300">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>
    <div class="relative">
        <div class="mb-6">
            <p class="text-gray-300 flex items-start">
                <i class="fas fa-info-circle text-yellow-400 mr-2 mt-1"></i>
                Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to sign in.
            </p>

            <?php if($enabled): ?>
                <div class="flex items-center mt-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-800 to-green-900 rounded-full flex items-center justify-center mr-4 text-green-400 shadow-lg border border-green-700/50">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Two-factor authentication is enabled</h3>
                        <p class="text-green-300">Your account has an extra layer of security.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex items-center mt-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-800 to-yellow-900 rounded-full flex items-center justify-center mr-4 text-yellow-400 shadow-lg border border-yellow-700/50">
                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Two-factor authentication is not enabled</h3>
                        <p class="text-yellow-300">Add an extra layer of security to your account.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if($enabled): ?>
    <!-- Recovery Codes Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-pink-500/20 hover:shadow-xl transition-all duration-300">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-pink-800/5"></div>
        <div class="relative">
            <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50">
                    <i class="fas fa-key"></i>
                </div>
                <span>Recovery Codes</span>
            </h2>
            <p class="text-gray-300 mb-6 flex items-start">
                <i class="fas fa-info-circle text-pink-400 mr-2 mt-1"></i>
                Recovery codes can be used to access your account if you lose your two-factor authentication device. Keep these codes in a secure place; like a password manager or a safe.
            </p>

            <div class="bg-gray-800/50 p-4 rounded-lg mb-6 border border-gray-700/50 shadow-inner">
                <div class="grid grid-cols-2 gap-3">
                    <?php if(session('recoveryCodes')): ?>
                        <?php $__currentLoopData = session('recoveryCodes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="font-mono text-sm bg-gray-900/50 p-2 rounded border border-gray-700/50 text-gray-300"><?php echo e($code); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <?php $__currentLoopData = $recoveryCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="font-mono text-sm bg-gray-900/50 p-2 rounded border border-gray-700/50 text-gray-300"><?php echo e($code); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <form action="<?php echo e(route('profile.two-factor.regenerate-recovery-codes')); ?>" method="POST" class="mt-4">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-500 hover:to-pink-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-sync-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Regenerate Recovery Codes
                </button>
            </form>
        </div>
    </div>

    <!-- Disable 2FA Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-red-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-red-500/20 hover:shadow-xl transition-all duration-300">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-red-800/5"></div>
        <div class="relative">
            <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                <div class="bg-red-900/70 text-red-400 rounded-lg p-2 mr-3 shadow-inner shadow-red-950/50">
                    <i class="fas fa-ban"></i>
                </div>
                <span>Disable Two-Factor Authentication</span>
            </h2>
            <p class="text-gray-300 mb-6 flex items-start">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2 mt-1"></i>
                If you would like to disable two-factor authentication, please confirm your password.
            </p>

            <form action="<?php echo e(route('profile.two-factor.disable')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <div class="mb-4">
                    <label for="password" class="block text-gray-300 font-medium mb-2">Password <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-hover:text-red-400 transition-colors duration-200"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200" placeholder="Enter your current password" />
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-shield-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Disable Two-Factor Authentication
                </button>
            </form>
        </div>
    </div>
<?php else: ?>
    <!-- Enable 2FA Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-orange-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-orange-500/20 hover:shadow-xl transition-all duration-300">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/5 to-orange-800/5"></div>
        <div class="relative">
            <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                <div class="bg-orange-900/70 text-orange-400 rounded-lg p-2 mr-3 shadow-inner shadow-orange-950/50">
                    <i class="fas fa-cog"></i>
                </div>
                <span>Setup Instructions</span>
            </h2>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <ol class="list-decimal list-inside space-y-3 text-gray-300">
                        <li>Download a two-factor authentication app like Google Authenticator, Microsoft Authenticator, or Authy.</li>
                        <li>Scan the QR code with your app, or manually enter the setup key.</li>
                        <li>Enter the 6-digit code from your app and your current password to enable two-factor authentication.</li>
                    </ol>

                    <div class="mt-6 bg-gray-800/50 p-4 rounded-lg border border-gray-700/50 shadow-inner">
                        <p class="text-sm text-gray-400 mb-2">Setup Key:</p>
                        <div class="font-mono text-sm bg-gray-900/50 p-3 rounded border border-gray-700/50 text-orange-300"><?php echo e($secretKey); ?></div>
                    </div>
                </div>

                <div class="flex justify-center items-center">
                    <div class="bg-white p-3 rounded-lg shadow-lg">
                        <?php echo $qrCode; ?>

                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('profile.two-factor.enable')); ?>" method="POST" class="border-t border-gray-700/50 pt-6">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="code" class="block text-gray-300 font-medium mb-2">Authentication Code <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-500 group-hover:text-orange-400 transition-colors duration-200"></i>
                            </div>
                            <input type="text" id="code" name="code" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200" placeholder="Enter the 6-digit code" />
                        </div>
                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-300 font-medium mb-2">Current Password <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-500 group-hover:text-orange-400 transition-colors duration-200"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200" placeholder="Enter your current password" />
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                        <i class="fas fa-shield-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Enable Two-Factor Authentication
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/profile/two-factor.blade.php ENDPATH**/ ?>