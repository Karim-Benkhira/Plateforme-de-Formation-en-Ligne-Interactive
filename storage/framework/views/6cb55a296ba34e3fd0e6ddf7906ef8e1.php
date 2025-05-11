<?php $__env->startSection('title', 'Profile Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Profile Settings</h1>
            <p class="text-blue-100">Manage your account settings and preferences.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'teacher' ? route('teacher.dashboard') : route('student.dashboard'))); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<?php if(session('status')): ?>
    <div class="mb-6 bg-green-900 border border-green-800 text-green-300 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-check-circle text-green-500 mr-2 text-xl"></i>
        <span><?php echo e(session('status')); ?></span>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="data-card p-6 text-center">
            <div class="relative mx-auto mb-6 group">
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-700 border-4 border-gray-600">
                    <?php if(auth()->user()->profile_image): ?>
                        <img src="<?php echo e(asset('storage/profile_images/' . auth()->user()->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-blue-900 text-blue-300">
                            <i class="fas fa-user text-4xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <label for="profile_image_upload" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-colors">
                    <i class="fas fa-camera"></i>
                </label>
            </div>

            <h2 class="text-xl font-semibold text-white mb-1"><?php echo e(auth()->user()->username); ?></h2>
            <p class="text-gray-400 mb-4"><?php echo e(auth()->user()->email); ?></p>

            <div class="py-3 px-4 bg-gray-800 rounded-lg mb-4 text-left">
                <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-2">Account Info</h3>
                <div class="flex items-center justify-between py-2 border-b border-gray-700">
                    <span class="text-gray-400">Role</span>
                    <span class="text-white capitalize"><?php echo e(auth()->user()->role); ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-700">
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

    <div class="lg:col-span-2">
        <div class="data-card p-6 mb-6">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                Profile Information
            </h2>

            <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <input type="file" id="profile_image_upload" name="profile_image" class="hidden" accept="image/*" onchange="document.getElementById('profile_form').submit()">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-gray-300 font-medium mb-2">Username <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <input type="text" id="username" name="username" value="<?php echo e(old('username', auth()->user()->username)); ?>" required
                                class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
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
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-500"></i>
                            </div>
                            <input type="email" id="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" required
                                class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
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
                            class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                    <button type="submit" id="profile_form" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="data-card p-6 mb-6">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-lock text-purple-500 mr-2"></i>
                Security Settings
            </h2>
            <p class="text-gray-400 mb-6">
                Ensure your account is using a strong password to stay secure.
            </p>

            <form action="<?php echo e(route('profile.password.update')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="block text-gray-300 font-medium mb-2">Current Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-500"></i>
                            </div>
                            <input type="password" id="current_password" name="current_password" required
                                class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
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
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-500"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
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
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-gray-500"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-shield-alt mr-2"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

        <div class="data-card p-6 mb-6">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                Two-Factor Authentication
            </h2>
            <p class="text-gray-400 mb-6">
                Add additional security to your account using two-factor authentication.
            </p>

            <div class="bg-gray-800 rounded-lg p-6 mb-6">
                <?php if(auth()->user()->hasTwoFactorEnabled()): ?>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-900 rounded-full flex items-center justify-center mr-4 text-green-400">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-white">Two-factor authentication is enabled</h3>
                            <p class="text-gray-400">Your account has an extra layer of security.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-yellow-900 rounded-full flex items-center justify-center mr-4 text-yellow-400">
                            <i class="fas fa-exclamation-triangle text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-white">Two-factor authentication is not enabled</h3>
                            <p class="text-gray-400">Add an extra layer of security to your account by enabling 2FA.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <a href="<?php echo e(route('profile.two-factor.show')); ?>" class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200">
                    <i class="fas fa-<?php echo e(auth()->user()->hasTwoFactorEnabled() ? 'cog' : 'plus'); ?> mr-2"></i>
                    <?php echo e(auth()->user()->hasTwoFactorEnabled() ? 'Manage Two-Factor Authentication' : 'Enable Two-Factor Authentication'); ?>

                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="data-card p-6">
                <h2 class="section-title flex items-center mb-6">
                    <i class="fas fa-history text-blue-500 mr-2"></i>
                    Activity Log
                </h2>
                <p class="text-gray-400 mb-6">
                    View a log of your recent account activity.
                </p>

                <div class="flex justify-center">
                    <a href="<?php echo e(route('profile.activity')); ?>" class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                        <i class="fas fa-list-alt mr-2"></i>
                        View Activity Log
                    </a>
                </div>
            </div>

            <div class="data-card p-6">
                <h2 class="section-title flex items-center mb-6">
                    <i class="fas fa-laptop text-indigo-500 mr-2"></i>
                    Browser Sessions
                </h2>
                <p class="text-gray-400 mb-6">
                    Manage and log out your active sessions on other browsers and devices.
                </p>

                <div class="flex justify-center">
                    <a href="<?php echo e(route('profile.sessions')); ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Manage Sessions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/profile/edit.blade.php ENDPATH**/ ?>