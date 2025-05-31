<?php $__env->startSection('title', 'Teacher Profile'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
    }
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    .profile-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .profile-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Profile Header -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
    </div>

    <div class="flex flex-col md:flex-row items-center relative z-10">
        <div class="relative mb-6 md:mb-0 md:mr-8">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-2xl">
                <?php if($user->profile_image): ?>
                    <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" alt="<?php echo e($user->username); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full gradient-pink-blue flex items-center justify-center">
                        <span class="text-4xl text-white font-bold"><?php echo e(strtoupper(substr($user->username, 0, 1))); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" onclick="document.getElementById('profile-image-modal').classList.remove('hidden')"
                    class="absolute bottom-0 right-0 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-full p-3 shadow-lg transition-all transform hover:scale-110">
                <i class="fas fa-camera text-lg"></i>
            </button>
        </div>
        <div class="text-center md:text-left flex-1">
            <h1 class="text-4xl font-bold text-white mb-2 text-shadow">👨‍🏫 <?php echo e($user->username); ?></h1>
            <p class="text-pink-100 text-lg mb-6"><?php echo e($user->email); ?></p>
            <div class="grid grid-cols-3 gap-4 max-w-md mx-auto md:mx-0">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                    <div class="text-white font-bold text-2xl"><?php echo e($coursesCount); ?></div>
                    <div class="text-pink-100 text-sm">Courses</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                    <div class="text-white font-bold text-2xl"><?php echo e($quizzesCount); ?></div>
                    <div class="text-pink-100 text-sm">Quizzes</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                    <div class="text-white font-bold text-2xl"><?php echo e($studentCount); ?></div>
                    <div class="text-pink-100 text-sm">Students</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-emerald-500/20 border-l-4 border-emerald-500 text-emerald-300 p-4 mb-8 rounded-xl shadow-lg backdrop-blur-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Profile Information -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Profile Information -->
        <div class="profile-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-user-circle mr-3 text-pink-400"></i> Profile Information
                </h2>
            </div>

            <form action="<?php echo e(route('teacher.profile.update')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="username" id="username" value="<?php echo e(old('username', $user->username)); ?>"
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-white transition-all">
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
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>"
                               class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-white transition-all">
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
                    <label for="specialization" class="block text-sm font-medium text-gray-300 mb-2">Specialization</label>
                    <input type="text" name="specialization" id="specialization" value="<?php echo e(old('specialization', $user->specialization)); ?>"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-white transition-all">
                    <?php $__errorArgs = ['specialization'];
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
                    <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Bio</label>
                    <textarea name="bio" id="bio" rows="4"
                              class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-white transition-all"><?php echo e(old('bio', $user->bio)); ?></textarea>
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
                    <button type="submit" class="gradient-pink-blue hover:opacity-90 text-white px-8 py-3 rounded-xl transition-all font-medium shadow-lg transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column - Password Update -->
    <div class="space-y-8">
        <!-- Password Update -->
        <div class="profile-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-lock mr-3 text-purple-400"></i> Update Password
                </h2>
            </div>

            <form action="<?php echo e(route('teacher.profile.password')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-white transition-all">
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
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-white transition-all">
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
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-white transition-all">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white px-8 py-3 rounded-xl transition-all font-medium shadow-lg transform hover:scale-105">
                        <i class="fas fa-key mr-2"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Links -->
        <div class="profile-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-bolt mr-3 text-yellow-400"></i> Quick Links
                </h2>
            </div>

            <div class="space-y-3">
                <a href="<?php echo e(route('teacher.courses')); ?>" class="flex items-center p-4 bg-gray-800/50 hover:bg-gray-700/50 rounded-xl transition-all card-hover border border-gray-700/50 hover:border-pink-400/50">
                    <div class="p-2 rounded-lg gradient-pink-blue mr-3">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <span class="text-white font-medium">My Courses</span>
                    <i class="fas fa-arrow-right text-gray-400 ml-auto"></i>
                </a>
                <a href="<?php echo e(route('teacher.quizzes')); ?>" class="flex items-center p-4 bg-gray-800/50 hover:bg-gray-700/50 rounded-xl transition-all card-hover border border-gray-700/50 hover:border-purple-400/50">
                    <div class="p-2 rounded-lg bg-gradient-to-r from-purple-500 to-pink-600 mr-3">
                        <i class="fas fa-clipboard-list text-white"></i>
                    </div>
                    <span class="text-white font-medium">My Quizzes</span>
                    <i class="fas fa-arrow-right text-gray-400 ml-auto"></i>
                </a>
                <a href="<?php echo e(route('teacher.analytics')); ?>" class="flex items-center p-4 bg-gray-800/50 hover:bg-gray-700/50 rounded-xl transition-all card-hover border border-gray-700/50 hover:border-blue-400/50">
                    <div class="p-2 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-600 mr-3">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <span class="text-white font-medium">Analytics</span>
                    <i class="fas fa-arrow-right text-gray-400 ml-auto"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Profile Image Modal -->
<div id="profile-image-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="profile-card max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-camera mr-3 text-pink-400"></i> Update Profile Image
            </h3>
            <button type="button" onclick="document.getElementById('profile-image-modal').classList.add('hidden')"
                    class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-gray-700/50 rounded-lg">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="<?php echo e(route('teacher.profile.image')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-pink-500/30 mb-4 shadow-xl">
                    <div id="image-preview" class="w-full h-full gradient-pink-blue flex items-center justify-center">
                        <?php if($user->profile_image): ?>
                            <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" alt="<?php echo e($user->username); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-4xl text-white font-bold"><?php echo e(strtoupper(substr($user->username, 0, 1))); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <label for="profile_image" class="gradient-pink-blue hover:opacity-90 text-white px-6 py-3 rounded-xl shadow-lg transition-all cursor-pointer font-medium transform hover:scale-105">
                    <i class="fas fa-upload mr-2"></i> Choose Image
                </label>
                <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                <p class="text-sm text-gray-400 mt-3 text-center">Recommended: Square image, max 2MB</p>
                <?php $__errorArgs = ['profile_image'];
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
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('profile-image-modal').classList.add('hidden')"
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl shadow-lg transition-all font-medium">
                    Cancel
                </button>
                <button type="submit" class="gradient-pink-blue hover:opacity-90 text-white px-6 py-3 rounded-xl shadow-lg transition-all font-medium transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i> Upload Image
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.teacher', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/teacher/profile.blade.php ENDPATH**/ ?>