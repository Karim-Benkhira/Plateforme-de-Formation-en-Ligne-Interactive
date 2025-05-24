<?php $__env->startSection('title', 'Activity Log Details'); ?>

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

    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .admin-gradient-bg {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
    }

    .admin-card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-file-alt mr-3 text-yellow-300"></i>
                Activity Log Details
            </h1>
            <p class="text-yellow-100 opacity-90">Detailed information about this activity log entry</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Back to Activity Logs</span>
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

            <div class="relative">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <span>Basic Information</span>
                </h2>

                <?php if($activityLog->user): ?>
                    <div class="flex items-center mb-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-4 shadow-lg relative overflow-hidden">
                            <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                            <span class="text-white font-bold text-2xl relative"><?php echo e(strtoupper(substr($activityLog->user->username, 0, 1))); ?></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-white"><?php echo e($activityLog->user->username); ?></h3>
                            <p class="text-gray-400"><?php echo e($activityLog->user->email); ?></p>
                            <?php if($activityLog->user->role !== 'user'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium mt-2
                                    <?php if($activityLog->user->role === 'admin'): ?> bg-yellow-900/50 text-yellow-300 border border-yellow-700/50
                                    <?php elseif($activityLog->user->role === 'teacher'): ?> bg-blue-900/50 text-blue-300 border border-blue-700/50
                                    <?php elseif($activityLog->user->role === 'agent'): ?> bg-orange-900/50 text-orange-300 border border-orange-700/50
                                    <?php endif; ?>">
                                    <i class="fas fa-crown mr-1"></i>
                                    <?php echo e(ucfirst($activityLog->user->role)); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center mb-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="w-16 h-16 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center mr-4 shadow-lg relative overflow-hidden">
                            <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:8px_8px]"></div>
                            <i class="fas fa-cogs text-gray-300 text-2xl relative"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-white">System</h3>
                            <p class="text-gray-400">Automated action</p>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium mt-2 bg-gray-900/50 text-gray-300 border border-gray-700/50">
                                <i class="fas fa-robot mr-1"></i>
                                Automated
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="space-y-4">
                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-bolt text-purple-400 mr-2"></i>
                                Action
                            </span>
                            <?php
                                $badgeClass = 'bg-blue-900/50 text-blue-300 border-blue-700/50';
                                $icon = 'fa-info-circle';

                                if (Str::contains($activityLog->action, ['login', 'logout', 'register'])) {
                                    $badgeClass = 'bg-green-900/50 text-green-300 border-green-700/50';
                                    $icon = 'fa-sign-in-alt';
                                } elseif (Str::contains($activityLog->action, ['create', 'add', 'insert'])) {
                                    $badgeClass = 'bg-purple-900/50 text-purple-300 border-purple-700/50';
                                    $icon = 'fa-plus-circle';
                                } elseif (Str::contains($activityLog->action, ['update', 'edit', 'modify'])) {
                                    $badgeClass = 'bg-yellow-900/50 text-yellow-300 border-yellow-700/50';
                                    $icon = 'fa-edit';
                                } elseif (Str::contains($activityLog->action, ['delete', 'remove'])) {
                                    $badgeClass = 'bg-red-900/50 text-red-300 border-red-700/50';
                                    $icon = 'fa-trash-alt';
                                }
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($badgeClass); ?> border">
                                <i class="fas <?php echo e($icon); ?> mr-1"></i>
                                <?php echo e($activityLog->action); ?>

                            </span>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-calendar text-green-400 mr-2"></i>
                                Date
                            </span>
                            <span class="text-white font-medium"><?php echo e($activityLog->created_at->format('F d, Y')); ?></span>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-clock text-blue-400 mr-2"></i>
                                Time
                            </span>
                            <div class="text-right">
                                <div class="text-white font-medium"><?php echo e($activityLog->created_at->format('H:i:s')); ?></div>
                                <div class="text-xs text-blue-400"><?php echo e($activityLog->created_at->diffForHumans()); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-network-wired text-orange-400 mr-2"></i>
                                IP Address
                            </span>
                            <div class="text-right">
                                <span class="text-white font-mono"><?php echo e($activityLog->ip_address ?? 'N/A'); ?></span>
                                <?php if($activityLog->ip_address === request()->ip()): ?>
                                    <div class="text-xs text-green-400">Current IP</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <!-- Activity Details Card -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-purple-600/5"></div>

            <div class="relative">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span>Activity Details</span>
                </h2>

                <div class="space-y-6">
                    <!-- Description -->
                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <h3 class="text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-align-left text-blue-400 mr-2"></i>
                            Description
                        </h3>
                        <div class="p-4 bg-gray-900/70 rounded-lg text-white border border-gray-700/30">
                            <?php if($activityLog->description): ?>
                                <?php echo e($activityLog->description); ?>

                            <?php else: ?>
                                <span class="text-gray-400 italic">No description available</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- User Agent -->
                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <h3 class="text-gray-300 font-medium mb-3 flex items-center">
                            <i class="fas fa-desktop text-green-400 mr-2"></i>
                            User Agent
                        </h3>
                        <div class="p-4 bg-gray-900/70 rounded-lg border border-gray-700/30">
                            <?php if($activityLog->user_agent): ?>
                                <div class="text-gray-300 text-sm break-words font-mono">
                                    <?php echo e($activityLog->user_agent); ?>

                                </div>
                                <div class="mt-3 pt-3 border-t border-gray-700/50">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                        <?php
                                            $userAgent = $activityLog->user_agent;
                                            $browser = 'Unknown';
                                            $os = 'Unknown';

                                            // Simple browser detection
                                            if (strpos($userAgent, 'Chrome') !== false) $browser = 'Chrome';
                                            elseif (strpos($userAgent, 'Firefox') !== false) $browser = 'Firefox';
                                            elseif (strpos($userAgent, 'Safari') !== false) $browser = 'Safari';
                                            elseif (strpos($userAgent, 'Edge') !== false) $browser = 'Edge';

                                            // Simple OS detection
                                            if (strpos($userAgent, 'Windows') !== false) $os = 'Windows';
                                            elseif (strpos($userAgent, 'Mac') !== false) $os = 'macOS';
                                            elseif (strpos($userAgent, 'Linux') !== false) $os = 'Linux';
                                            elseif (strpos($userAgent, 'Android') !== false) $os = 'Android';
                                            elseif (strpos($userAgent, 'iOS') !== false) $os = 'iOS';
                                        ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-globe text-blue-400 mr-2"></i>
                                            <span class="text-gray-400">Browser:</span>
                                            <span class="text-white ml-2"><?php echo e($browser); ?></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-laptop text-purple-400 mr-2"></i>
                                            <span class="text-gray-400">OS:</span>
                                            <span class="text-white ml-2"><?php echo e($os); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Not available</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Properties -->
                    <?php if($activityLog->properties): ?>
                        <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                            <h3 class="text-gray-300 font-medium mb-3 flex items-center">
                                <i class="fas fa-code text-yellow-400 mr-2"></i>
                                Properties
                            </h3>
                            <div class="p-4 bg-gray-900/70 rounded-lg border border-gray-700/30">
                                <pre class="text-sm text-blue-300 overflow-auto whitespace-pre-wrap"><?php echo e(json_encode($activityLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-blue-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-cyan-600/5"></div>

            <div class="relative">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span>Additional Information</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-hashtag text-green-400 mr-2"></i>
                                Log ID
                            </span>
                            <span class="text-white font-mono">#<?php echo e($activityLog->id); ?></span>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-database text-purple-400 mr-2"></i>
                                Created
                            </span>
                            <span class="text-white"><?php echo e($activityLog->created_at->format('M d, Y H:i')); ?></span>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-clock text-orange-400 mr-2"></i>
                                Time Ago
                            </span>
                            <span class="text-white"><?php echo e($activityLog->created_at->diffForHumans()); ?></span>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 flex items-center">
                                <i class="fas fa-calendar-week text-pink-400 mr-2"></i>
                                Day of Week
                            </span>
                            <span class="text-white"><?php echo e($activityLog->created_at->format('l')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/activity-logs/show.blade.php ENDPATH**/ ?>