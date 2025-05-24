<?php $__env->startSection('title', 'Profile Settings'); ?>

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
                <i class="fas fa-user-circle mr-3 text-yellow-300"></i>
                Profile Settings
            </h1>
            <p class="text-yellow-100 opacity-90">Manage your account settings and preferences.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'teacher' ? route('teacher.dashboard') : route('student.dashboard'))); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span>Back to Dashboard</span>
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
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden hover:shadow-yellow-500/20 hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>
            <div class="relative text-center">
                <div class="relative mx-auto mb-6 group">
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-800 border-4 border-yellow-900/50 shadow-lg group-hover:border-yellow-700/70 transition-all duration-300">
                        <?php if(auth()->user()->profile_image): ?>
                            <img src="<?php echo e(asset('storage/profile_images/' . auth()->user()->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-yellow-900 to-yellow-800 text-yellow-300">
                                <span class="text-4xl font-bold text-white"><?php echo e(strtoupper(substr(auth()->user()->username, 0, 1))); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <label for="profile_image_upload" class="absolute bottom-0 right-0 w-10 h-10 bg-yellow-600 hover:bg-yellow-500 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all duration-300 hover:scale-110">
                        <i class="fas fa-camera"></i>
                    </label>
                </div>

                <h2 class="text-xl font-semibold text-white mb-1"><?php echo e(auth()->user()->username); ?></h2>
                <p class="text-yellow-300 mb-6"><?php echo e(auth()->user()->email); ?></p>

                <div class="py-3 px-4 bg-gray-800/50 rounded-lg mb-4 text-left border border-gray-700/50">
                    <h3 class="text-sm font-medium text-yellow-400 uppercase tracking-wider mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Account Info
                    </h3>
                    <div class="flex items-center justify-between py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Role</span>
                        <span class="text-white capitalize px-3 py-1 bg-yellow-900/30 rounded-full text-sm"><?php echo e(auth()->user()->role); ?></span>
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
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-yellow-500/20 hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
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
                                    <i class="fas fa-user text-gray-500 group-hover:text-yellow-400 transition-colors duration-200"></i>
                                </div>
                                <input type="text" id="username" name="username" value="<?php echo e(old('username', auth()->user()->username)); ?>" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200" />
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
                                    <i class="fas fa-envelope text-gray-500 group-hover:text-yellow-400 transition-colors duration-200"></i>
                                </div>
                                <input type="email" id="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200" />
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
                                class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
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
                        <button type="submit" id="profile_form" class="px-6 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-500 hover:to-yellow-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-pink-500/20 hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-pink-800/5"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50">
                        <i class="fas fa-lock"></i>
                    </div>
                    <span>Security Settings</span>
                </h2>
                <p class="text-gray-300 mb-6 flex items-start">
                    <i class="fas fa-shield-alt text-pink-400 mr-2 mt-1"></i>
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
                                    <i class="fas fa-key text-gray-500 group-hover:text-pink-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200" />
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
                                    <i class="fas fa-lock text-gray-500 group-hover:text-pink-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200" />
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
                                    <i class="fas fa-check-circle text-gray-500 group-hover:text-pink-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-500 hover:to-pink-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                            <i class="fas fa-shield-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-orange-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-orange-500/20 hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600/5 to-orange-800/5"></div>
            <div class="relative">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-orange-900/70 text-orange-400 rounded-lg p-2 mr-3 shadow-inner shadow-orange-950/50">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <span>Two-Factor Authentication</span>
                </h2>
                <p class="text-gray-300 mb-6 flex items-start">
                    <i class="fas fa-lock text-orange-400 mr-2 mt-1"></i>
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

                    <a href="<?php echo e(route('profile.two-factor.show')); ?>" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-500 hover:to-orange-600 text-white font-medium rounded-lg shadow-lg transition duration-300 group">
                        <i class="fas fa-<?php echo e(auth()->user()->hasTwoFactorEnabled() ? 'cog' : 'plus'); ?> mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <?php echo e(auth()->user()->hasTwoFactorEnabled() ? 'Manage Two-Factor Authentication' : 'Enable Two-Factor Authentication'); ?>

                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden group hover:shadow-yellow-500/20 hover:shadow-xl transition-all duration-300">
                <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-yellow-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                        <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50 group-hover:shadow-yellow-900/30 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-history group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <span>Activity Log</span>
                    </h2>
                    <p class="text-gray-300 mb-6 flex items-start">
                        <i class="fas fa-info-circle text-yellow-400 mr-2 mt-1"></i>
                        View a log of your recent account activity.
                    </p>

                    <div class="flex justify-center">
                        <a href="<?php echo e(route('profile.activity')); ?>" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-500 hover:to-yellow-600 text-white font-medium rounded-lg shadow-lg transition duration-300 group">
                            <i class="fas fa-list-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            View Activity Log
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden group hover:shadow-pink-500/20 hover:shadow-xl transition-all duration-300">
                <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-pink-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                        <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50 group-hover:shadow-pink-900/30 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-laptop group-hover:scale-110 transition-transform duration-300"></i>
                        </div>
                        <span>Browser Sessions</span>
                    </h2>
                    <p class="text-gray-300 mb-6 flex items-start">
                        <i class="fas fa-info-circle text-pink-400 mr-2 mt-1"></i>
                        Manage and log out your active sessions on other browsers and devices.
                    </p>

                    <div class="flex justify-center">
                        <a href="<?php echo e(route('profile.sessions')); ?>" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-pink-600 to-pink-700 hover:from-pink-500 hover:to-pink-600 text-white font-medium rounded-lg shadow-lg transition duration-300 group">
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/profile/edit.blade.php ENDPATH**/ ?>