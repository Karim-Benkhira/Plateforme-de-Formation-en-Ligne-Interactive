<?php $__env->startSection('title', 'Admin Dashboard'); ?>

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

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0;
        }
    }

    @keyframes admin-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .admin-glow {
        animation: admin-glow 2s ease-in-out infinite;
    }

    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .admin-gradient-bg {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
    }

    .admin-card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(245, 158, 11, 0.2);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Banner -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-crown text-yellow-400 mr-3 text-2xl"></i>
                Welcome, <span class="text-yellow-300 ml-2"><?php echo e(Auth::user()->username); ?></span><span class="text-pink-400">!</span>
            </h1>
            <p class="text-yellow-100 opacity-90">Manage your platform, monitor user activity, and keep everything running smoothly.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.createCourse')); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Add New Course</span>
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-lg hover:shadow-yellow-500/20 hover:shadow-xl transition-all duration-300 admin-card-hover relative overflow-hidden group">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-yellow-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-yellow-900/70 text-yellow-400 rounded-xl p-4 mr-4 shadow-inner shadow-yellow-950/50 group-hover:shadow-yellow-900/30 group-hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-users text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Users</p>
                    <p class="text-white text-2xl font-bold"><?php echo e($totalUsers); ?></p>
                </div>
            </div>
            <div class="w-full bg-gray-800/80 h-2 rounded-full overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2 rounded-full" style="width: 75%"></div>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-lg hover:shadow-pink-500/20 hover:shadow-xl transition-all duration-300 admin-card-hover relative overflow-hidden group">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-pink-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-pink-900/70 text-pink-400 rounded-xl p-4 mr-4 shadow-inner shadow-pink-950/50 group-hover:shadow-pink-900/30 group-hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-book text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium">Active Courses</p>
                    <p class="text-white text-2xl font-bold"><?php echo e($activeCourses); ?></p>
                </div>
            </div>
            <div class="w-full bg-gray-800/80 h-2 rounded-full overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 60%"></div>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-orange-500/30 rounded-xl p-6 shadow-lg hover:shadow-orange-500/20 hover:shadow-xl transition-all duration-300 admin-card-hover relative overflow-hidden group">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/5 to-orange-800/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-orange-900/70 text-orange-400 rounded-xl p-4 mr-4 shadow-inner shadow-orange-950/50 group-hover:shadow-orange-900/30 group-hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-question-circle text-2xl group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm font-medium">Quizzes Taken</p>
                    <p class="text-white text-2xl font-bold"><?php echo e($quizzesTaken); ?></p>
                </div>
            </div>
            <div class="w-full bg-gray-800/80 h-2 rounded-full overflow-hidden shadow-inner">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-2 rounded-full" style="width: 85%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Leaderboard -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl mb-8 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                    <i class="fas fa-trophy"></i>
                </div>
                <span>Top 10 Users Leaderboard</span>
            </h2>
            <a href="#" class="group bg-gray-800/80 hover:bg-yellow-500/20 text-yellow-400 hover:text-yellow-300 text-sm flex items-center py-2 px-4 rounded-lg border border-yellow-500/30 transition-all duration-300">
                <span>View All</span>
                <i class="fas fa-chevron-right ml-2 text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-gray-700/50 shadow-inner bg-gray-900/50">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-4 py-3 text-gray-400 font-medium w-16 border-b border-gray-700/50">#</th>
                        <th class="px-4 py-3 text-gray-400 font-medium border-b border-gray-700/50">Username</th>
                        <th class="px-4 py-3 text-gray-400 font-medium border-b border-gray-700/50">Total Score</th>
                        <th class="px-4 py-3 text-gray-400 font-medium border-b border-gray-700/50">Quizzes Taken</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $leaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200">
                        <td class="px-4 py-4">
                            <?php if($index === 0): ?>
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-bold shadow-lg relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/10 bg-[length:5px_5px]"></div>
                                    <span class="relative">1</span>
                                    <div class="absolute top-0 left-0 w-full h-full bg-white opacity-20 animate-pulse-slow"></div>
                                </div>
                            <?php elseif($index === 1): ?>
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold shadow-lg relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/10 bg-[length:5px_5px]"></div>
                                    <span class="relative">2</span>
                                </div>
                            <?php elseif($index === 2): ?>
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-yellow-700 to-yellow-800 text-white font-bold shadow-lg relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/10 bg-[length:5px_5px]"></div>
                                    <span class="relative">3</span>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 border border-gray-700 text-gray-300 font-bold">
                                    <?php echo e($index + 1); ?>

                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-4 font-medium text-white">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center mr-3 text-gray-300">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <?php echo e($user->username); ?>

                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="inline-flex items-center bg-blue-900/30 border border-blue-700/30 text-blue-400 px-4 py-2 rounded-lg font-medium">
                                <i class="fas fa-star text-yellow-500 mr-2"></i>
                                <span><?php echo e($user->total_score); ?> pts</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-gray-300">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-900/30 flex items-center justify-center mr-2 text-purple-400">
                                    <i class="fas fa-clipboard-check text-sm"></i>
                                </div>
                                <?php echo e($user->quizzes_count); ?>

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($leaders->isEmpty()): ?>
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-trophy text-gray-700 text-4xl mb-3"></i>
                                <p>No leaderboard data available yet.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions & Platform Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Quick Actions -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <span>Quick Actions</span>
                </h2>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <a href="<?php echo e(route('admin.users')); ?>" class="group relative bg-gradient-to-br from-gray-800 to-gray-900 hover:from-yellow-900/20 hover:to-yellow-800/20 border border-gray-700 hover:border-yellow-500/50 p-6 rounded-xl flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:shadow-yellow-500/10 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:10px_10px] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="bg-yellow-900/70 text-yellow-400 group-hover:bg-yellow-800 group-hover:text-yellow-300 p-4 rounded-xl mb-4 shadow-inner shadow-yellow-950/50 group-hover:shadow-yellow-900/30 group-hover:shadow-lg transition-all duration-300 transform group-hover:scale-110">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">Manage Users</span>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-yellow-500 to-yellow-600 w-0 group-hover:w-full transition-all duration-500"></div>
                </a>

                <a href="<?php echo e(route('admin.courses')); ?>" class="group relative bg-gradient-to-br from-gray-800 to-gray-900 hover:from-pink-900/20 hover:to-pink-800/20 border border-gray-700 hover:border-pink-500/50 p-6 rounded-xl flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:shadow-pink-500/10 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:10px_10px] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="bg-pink-900/70 text-pink-400 group-hover:bg-pink-800 group-hover:text-pink-300 p-4 rounded-xl mb-4 shadow-inner shadow-pink-950/50 group-hover:shadow-pink-900/30 group-hover:shadow-lg transition-all duration-300 transform group-hover:scale-110">
                            <i class="fas fa-book text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">Manage Courses</span>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-pink-500 to-pink-600 w-0 group-hover:w-full transition-all duration-500"></div>
                </a>

                <a href="<?php echo e(route('admin.quizzes')); ?>" class="group relative bg-gradient-to-br from-gray-800 to-gray-900 hover:from-orange-900/20 hover:to-orange-800/20 border border-gray-700 hover:border-orange-500/50 p-6 rounded-xl flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:shadow-orange-500/10 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:10px_10px] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="bg-orange-900/70 text-orange-400 group-hover:bg-orange-800 group-hover:text-orange-300 p-4 rounded-xl mb-4 shadow-inner shadow-orange-950/50 group-hover:shadow-orange-900/30 group-hover:shadow-lg transition-all duration-300 transform group-hover:scale-110">
                            <i class="fas fa-question-circle text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">Manage Quizzes</span>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-orange-500 to-orange-600 w-0 group-hover:w-full transition-all duration-500"></div>
                </a>

                <a href="<?php echo e(route('admin.reclamations')); ?>" class="group relative bg-gradient-to-br from-gray-800 to-gray-900 hover:from-red-900/20 hover:to-red-800/20 border border-gray-700 hover:border-red-500/50 p-6 rounded-xl flex flex-col items-center justify-center transition-all duration-300 hover:shadow-lg hover:shadow-red-500/10 overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:10px_10px] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="bg-red-900/70 text-red-400 group-hover:bg-red-800 group-hover:text-red-300 p-4 rounded-xl mb-4 shadow-inner shadow-red-950/50 group-hover:shadow-red-900/30 group-hover:shadow-lg transition-all duration-300 transform group-hover:scale-110">
                            <i class="fas fa-flag text-2xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">View Reports</span>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-red-500 to-red-600 w-0 group-hover:w-full transition-all duration-500"></div>
                </a>
            </div>
        </div>
    </div>

    <!-- Platform Overview -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-yellow-600/5"></div>

        <div class="relative">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Platform Overview</span>
                </h2>
            </div>

            <div class="space-y-4">
                <div class="group bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-700/50 rounded-xl p-4 hover:shadow-lg hover:shadow-blue-500/5 transition-all duration-300 hover:border-blue-500/30 relative overflow-hidden">
                    <div class="absolute inset-0 bg-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-blue-900/70 text-blue-400 p-3 rounded-xl mr-4 shadow-inner shadow-blue-950/50 group-hover:shadow-blue-900/30 group-hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-graduation-cap text-xl group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-medium mb-1">Students</p>
                                <p class="text-white text-lg font-bold"><?php echo e(App\Models\User::where('role', 'user')->count()); ?></p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-300 rounded-full mb-1">+5%</span>
                            <div class="w-24 h-1.5 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-700/50 rounded-xl p-4 hover:shadow-lg hover:shadow-purple-500/5 transition-all duration-300 hover:border-purple-500/30 relative overflow-hidden">
                    <div class="absolute inset-0 bg-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-purple-900/70 text-purple-400 p-3 rounded-xl mr-4 shadow-inner shadow-purple-950/50 group-hover:shadow-purple-900/30 group-hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-chalkboard-teacher text-xl group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-medium mb-1">Teachers</p>
                                <p class="text-white text-lg font-bold"><?php echo e(App\Models\User::where('role', 'teacher')->count()); ?></p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs px-2 py-1 bg-purple-500/20 text-purple-300 rounded-full mb-1">+2%</span>
                            <div class="w-24 h-1.5 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-700/50 rounded-xl p-4 hover:shadow-lg hover:shadow-yellow-500/5 transition-all duration-300 hover:border-yellow-500/30 relative overflow-hidden">
                    <div class="absolute inset-0 bg-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-yellow-900/70 text-yellow-400 p-3 rounded-xl mr-4 shadow-inner shadow-yellow-950/50 group-hover:shadow-yellow-900/30 group-hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-tags text-xl group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-medium mb-1">Categories</p>
                                <p class="text-white text-lg font-bold"><?php echo e(App\Models\Category::count()); ?></p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-300 rounded-full mb-1">+3%</span>
                            <div class="w-24 h-1.5 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group bg-gradient-to-r from-gray-900 to-gray-800 border border-gray-700/50 rounded-xl p-4 hover:shadow-lg hover:shadow-green-500/5 transition-all duration-300 hover:border-green-500/30 relative overflow-hidden">
                    <div class="absolute inset-0 bg-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-green-900/70 text-green-400 p-3 rounded-xl mr-4 shadow-inner shadow-green-950/50 group-hover:shadow-green-900/30 group-hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-question text-xl group-hover:scale-110 transition-transform duration-300"></i>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-medium mb-1">Quiz Questions</p>
                                <p class="text-white text-lg font-bold"><?php echo e(App\Models\Question::count()); ?></p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs px-2 py-1 bg-green-500/20 text-green-300 rounded-full mb-1">+8%</span>
                            <div class="w-24 h-1.5 bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-green-500 to-green-600 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>