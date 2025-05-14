<?php $__env->startSection('title', 'Profile Settings'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-user-circle mr-3 text-blue-300"></i>
                Profile Settings
            </h1>
            <p class="text-blue-100 opacity-90">Manage your account settings and preferences.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'teacher' ? route('teacher.dashboard') : route('student.dashboard'))); ?>" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Dashboard
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
            <div class="relative text-center">
                <div class="relative mx-auto mb-6 group">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-800 border-4 border-blue-900/50 shadow-lg group-hover:border-blue-700/70 transition-all duration-300">
                        <?php if(auth()->user()->profile_image): ?>
                            <img src="<?php echo e(asset('storage/profile_images/' . auth()->user()->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-900 to-blue-800 text-blue-300">
                                <span class="text-4xl font-bold text-white"><?php echo e(strtoupper(substr(auth()->user()->username, 0, 1))); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <label for="profile_image_upload" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 hover:bg-blue-500 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all duration-300 hover:scale-110">
                        <i class="fas fa-camera"></i>
                    </label>
                </div>

                <h2 class="text-xl font-semibold text-white mb-1"><?php echo e(auth()->user()->username); ?></h2>
                <p class="text-blue-300 mb-6"><?php echo e(auth()->user()->email); ?></p>

                <div class="py-3 px-4 bg-gray-800/50 rounded-lg mb-4 text-left border border-gray-700/50">
                    <h3 class="text-sm font-medium text-blue-400 uppercase tracking-wider mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Account Info
                    </h3>
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Role</span>
                        <span class="text-white capitalize px-3 py-1 bg-blue-900/30 rounded-full text-sm"><?php echo e(auth()->user()->role); ?></span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Member Since</span>
                        <span class="text-white"><?php echo e(auth()->user()->created_at->format('M d, Y')); ?></span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-gray-400">Last Updated</span>
                        <span class="text-white"><?php echo e(auth()->user()->updated_at->format('M d, Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <span>Profile Information</span>
                </h2>

                <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <input type="file" id="profile_image_upload" name="profile_image" class="hidden" accept="image/*" onchange="document.getElementById('profile_form').submit()">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="username" class="block text-gray-300 font-medium mb-2">Username <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                                </div>
                                <input type="text" id="username" name="username" value="<?php echo e(old('username', auth()->user()->username)); ?>" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <?php $__errorArgs = ['username'];
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
                            <label for="email" class="block text-gray-300 font-medium mb-2">Email <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                                </div>
                                <input type="email" id="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                            </div>
                            <?php $__errorArgs = ['email'];
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

                    <div>
                        <label for="bio" class="block text-gray-300 font-medium mb-2">Bio</label>
                        <div class="relative">
                            <textarea id="bio" name="bio" rows="4"
                                class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Tell us a little about yourself"><?php echo e(old('bio', auth()->user()->bio)); ?></textarea>
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Brief description for your profile (optional)</p>
                        <?php $__errorArgs = ['bio'];
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

                    <div class="flex justify-end">
                        <button type="submit" id="profile_form" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-purple-800/5"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                        <i class="fas fa-lock"></i>
                    </div>
                    <span>Security Settings</span>
                </h2>
                <p class="text-gray-300 mb-6 flex items-start">
                    <i class="fas fa-shield-alt text-purple-400 mr-2 mt-1"></i>
                    Ensure your account is using a strong password to stay secure.
                </p>

                <form action="<?php echo e(route('profile.password.update')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="current_password" class="block text-gray-300 font-medium mb-2">Current Password <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200" />
                            </div>
                            <?php $__errorArgs = ['current_password'];
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
                            <label for="password" class="block text-gray-300 font-medium mb-2">New Password <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200" />
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

                        <div>
                            <label for="password_confirmation" class="block text-gray-300 font-medium mb-2">Confirm Password <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-check-circle text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                            <i class="fas fa-shield-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-green-600/5 to-green-800/5"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-green-900/70 text-green-400 rounded-lg p-2 mr-3 shadow-inner shadow-green-950/50">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <span>Two-Factor Authentication</span>
                </h2>
                <p class="text-gray-300 mb-6 flex items-start">
                    <i class="fas fa-lock text-green-400 mr-2 mt-1"></i>
                    Add additional security to your account using two-factor authentication.
                </p>

                <div class="bg-gray-800/50 rounded-lg p-6 mb-6 border border-gray-700/50 shadow-inner">
                    <?php if(auth()->user()->hasTwoFactorEnabled()): ?>
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-800 to-green-900 rounded-full flex items-center justify-center mr-4 text-green-400 shadow-lg border border-green-700/50">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-white">Two-factor authentication is enabled</h3>
                                <p class="text-green-300">Your account has an extra layer of security.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-800 to-yellow-900 rounded-full flex items-center justify-center mr-4 text-yellow-400 shadow-lg border border-yellow-700/50">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-white">Two-factor authentication is not enabled</h3>
                                <p class="text-yellow-300">Add an extra layer of security to your account by enabling 2FA.</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <a href="<?php echo e(route('profile.two-factor.show')); ?>" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 text-white font-medium rounded-lg shadow-lg transition duration-300 group">
                        <i class="fas fa-<?php echo e(auth()->user()->hasTwoFactorEnabled() ? 'cog' : 'plus'); ?> mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <?php echo e(auth()->user()->hasTwoFactorEnabled() ? 'Manage Two-Factor Authentication' : 'Enable Two-Factor Authentication'); ?>

                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden group hover:shadow-blue-500/10 hover:shadow-lg transition-all duration-300">
                <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                        <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50 group-hover:shadow-blue-900/30 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-history group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <span>Activity Log</span>
                    </h2>
                    <p class="text-gray-300 mb-6 flex items-start">
                        <i class="fas fa-info-circle text-blue-400 mr-2 mt-1"></i>
                        View a log of your recent account activity.
                    </p>

                    <div class="flex justify-center">
                        <a href="<?php echo e(route('profile.activity')); ?>" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-medium rounded-lg shadow-lg transition duration-300 group">
                            <i class="fas fa-list-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            View Activity Log
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden group hover:shadow-indigo-500/10 hover:shadow-lg transition-all duration-300">
                <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/5 to-indigo-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                        <div class="bg-indigo-900/70 text-indigo-400 rounded-lg p-2 mr-3 shadow-inner shadow-indigo-950/50 group-hover:shadow-indigo-900/30 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-laptop group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <span>Browser Sessions</span>
                    </h2>
                    <p class="text-gray-300 mb-6 flex items-start">
                        <i class="fas fa-info-circle text-indigo-400 mr-2 mt-1"></i>
                        Manage and log out your active sessions on other browsers and devices.
                    </p>

                    <div class="flex justify-center">
                        <a href="<?php echo e(route('profile.sessions')); ?>" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-medium rounded-lg shadow-lg transition duration-300 group">
                            <i class="fas fa-sign-out-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            Manage Sessions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/profile/edit.blade.php ENDPATH**/ ?>