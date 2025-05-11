<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Profile</h1>
            <p class="text-blue-100">Manage your personal information and account settings.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Overview -->
    <div class="data-card p-6 mb-8">
        <div class="flex flex-col items-center text-center">
            <div class="relative group mb-6">
                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-800 border-4 border-gray-700">
                    <?php if($user->profile_image): ?>
                        <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>" alt="<?php echo e($user->username); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-500">
                            <i class="fas fa-user text-5xl"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <label for="profile_image_upload" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center cursor-pointer border-4 border-gray-800 hover:bg-blue-700 transition-colors">
                    <i class="fas fa-camera text-white"></i>
                </label>
            </div>

            <h2 class="text-2xl font-bold text-white mb-1"><?php echo e($user->username); ?></h2>
            <p class="text-gray-400 mb-4"><?php echo e($user->email); ?></p>

            <div class="bg-gray-800 rounded-lg p-4 w-full mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400">Role</span>
                    <span class="text-white font-medium"><?php echo e(ucfirst($user->role)); ?></span>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-400">Member Since</span>
                    <span class="text-white font-medium"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Last Login</span>
                    <span class="text-white font-medium"><?php echo e(now()->format('M d, Y')); ?></span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 w-full">
                <div class="bg-gray-800 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-white"><?php echo e($user->quizResults()->count() ?? 0); ?></div>
                    <p class="text-gray-400 text-sm">Quizzes Taken</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-white"><?php echo e($user->quizResults()->avg('score') ? round($user->quizResults()->avg('score')) : 0); ?></div>
                    <p class="text-gray-400 text-sm">Avg. Score</p>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <!-- Edit Profile Form -->
        <div class="data-card p-6 mb-8">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-user-edit text-blue-500 mr-2"></i>
                Edit Profile
            </h2>

            <?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-green-900 bg-opacity-40 border border-green-700 text-green-300 rounded-lg flex items-start">
                    <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold">Success!</h4>
                        <p><?php echo e(session('success')); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($errors->any() && !old('old_password')): ?>
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

            <form action="<?php echo e(route('student.profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <input type="file" id="profile_image_upload" name="profile_image" class="hidden" accept="image/*" onchange="document.getElementById('submit_profile').click()">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-gray-300 mb-2">Full Name</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Full Name"
                            value="<?php echo e(old('username', $user->username)); ?>"
                            required
                            class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <div>
                        <label for="email" class="block text-gray-300 mb-2">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Email"
                            value="<?php echo e(old('email', $user->email)); ?>"
                            required
                            class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        id="submit_profile"
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 flex items-center"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="data-card p-6 mb-8">
            <h2 class="section-title flex items-center mb-6">
                <i class="fas fa-lock text-blue-500 mr-2"></i>
                Change Password
            </h2>

            <?php if($errors->any() && old('old_password')): ?>
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

            <?php if(session('password_success')): ?>
                <div class="mb-6 p-4 bg-green-900 bg-opacity-40 border border-green-700 text-green-300 rounded-lg flex items-start">
                    <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold">Success!</h4>
                        <p><?php echo e(session('password_success')); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('student.profile.password')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="old_password" class="block text-gray-300 mb-2">Current Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="old_password"
                            name="old_password"
                            required
                            class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white" onclick="togglePasswordVisibility('old_password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="new_password" class="block text-gray-300 mb-2">New Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                required
                                class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white" onclick="togglePasswordVisibility('new_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-gray-300 mb-2">Confirm New Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                required
                                class="w-full p-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white" onclick="togglePasswordVisibility('new_password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 flex items-center"
                    >
                        <i class="fas fa-key mr-2"></i>
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = event.currentTarget.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/profile.blade.php ENDPATH**/ ?>