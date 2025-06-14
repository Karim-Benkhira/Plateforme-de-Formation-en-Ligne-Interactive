<?php $__env->startSection('title', 'Activity Logs'); ?>

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
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);
    }

    /* Custom select styling */
    .custom-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
    }

    /* Badge styles */
    .badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
    }

    .badge-blue {
        @apply bg-blue-900/50 text-blue-300 border border-blue-700/50;
    }

    .badge-green {
        @apply bg-green-900/50 text-green-300 border border-green-700/50;
    }

    .badge-red {
        @apply bg-red-900/50 text-red-300 border border-red-700/50;
    }

    .badge-yellow {
        @apply bg-yellow-900/50 text-yellow-300 border border-yellow-700/50;
    }

    .badge-purple {
        @apply bg-purple-900/50 text-purple-300 border border-purple-700/50;
    }

    .badge-orange {
        @apply bg-orange-900/50 text-orange-300 border border-orange-700/50;
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
                <i class="fas fa-history mr-3 text-yellow-300"></i>
                Activity Logs
            </h1>
            <p class="text-yellow-100 opacity-90">Track and monitor all system activities and user actions</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
                <i class="fas fa-list-alt mr-2 text-yellow-300"></i>
                <span class="text-sm font-medium">Total Logs: <?php echo e($activityLogs->total()); ?></span>
            </div>
            <button type="button" id="filterButton" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-filter mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Filter Logs</span>
            </button>

            <form action="<?php echo e(route('admin.activity-logs.clear')); ?>" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="group bg-red-600/80 hover:bg-red-700/80 text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-red-500/20 hover:shadow-xl">
                    <i class="fas fa-trash-alt mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    <span>Clear All</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Logs -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-yellow-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-900/70 text-yellow-400 flex items-center justify-center mr-4 shadow-inner shadow-yellow-950/50">
                <i class="fas fa-list-alt text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Total Logs</p>
                <p class="text-white text-2xl font-bold"><?php echo e($activityLogs->total()); ?></p>
            </div>
        </div>
    </div>

    <!-- Today's Logs -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-blue-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-blue-900/70 text-blue-400 flex items-center justify-center mr-4 shadow-inner shadow-blue-950/50">
                <i class="fas fa-calendar-day text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Today's Logs</p>
                <p class="text-white text-2xl font-bold"><?php echo e(\App\Models\ActivityLog::whereDate('created_at', today())->count()); ?></p>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-green-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-green-600/5 to-green-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-green-900/70 text-green-400 flex items-center justify-center mr-4 shadow-inner shadow-green-950/50">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Active Users</p>
                <p class="text-white text-2xl font-bold"><?php echo e(\App\Models\ActivityLog::distinct('user_id')->whereNotNull('user_id')->whereDate('created_at', today())->count()); ?></p>
            </div>
        </div>
    </div>

    <!-- Most Common Action -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-purple-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-purple-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-purple-900/70 text-purple-400 flex items-center justify-center mr-4 shadow-inner shadow-purple-950/50">
                <i class="fas fa-chart-bar text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Top Action</p>
                <p class="text-white text-lg font-bold"><?php echo e(\App\Models\ActivityLog::select('action')->groupBy('action')->orderByRaw('COUNT(*) DESC')->first()->action ?? 'N/A'); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Success Message -->
<?php if(session('success')): ?>
    <div class="mb-6 bg-gradient-to-r from-green-900/80 to-green-800/80 border border-green-700/50 text-green-300 px-6 py-4 rounded-xl flex items-center shadow-lg">
        <div class="bg-green-800/80 p-2 rounded-lg mr-4 shadow-inner">
            <i class="fas fa-check-circle text-green-400 text-xl"></i>
        </div>
        <span class="font-medium"><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>

<!-- Filter Panel -->
<div id="filterPanel" class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-8 admin-card-hover <?php echo e(request('user_id') || request('action') || request('date_from') || request('date_to') ? '' : 'hidden'); ?>">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                    <i class="fas fa-filter"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Filter Activity Logs</h2>
            </div>
            <button type="button" id="closeFilterPanel" class="text-gray-400 hover:text-white transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form action="<?php echo e(route('admin.activity-logs.index')); ?>" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- User Filter -->
                <div class="group">
                    <label for="user_id" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-user text-blue-400 mr-2"></i>
                        User
                    </label>
                    <div class="relative">
                        <select id="user_id" name="user_id"
                            class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all duration-300 appearance-none custom-select hover:border-blue-500/30">
                            <option value="">All Users</option>
                            <?php $__currentLoopData = \App\Models\User::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->username); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Action Filter -->
                <div class="group">
                    <label for="action" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-tag text-purple-400 mr-2"></i>
                        Action Type
                    </label>
                    <div class="relative">
                        <select id="action" name="action"
                            class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all duration-300 appearance-none custom-select hover:border-purple-500/30">
                            <option value="">All Actions</option>
                            <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($action); ?>" <?php echo e(request('action') == $action ? 'selected' : ''); ?>>
                                    <?php echo e($action); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Date From Filter -->
                <div class="group">
                    <label for="date_from" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
                        Date From
                    </label>
                    <div class="relative">
                        <input type="date" id="date_from" name="date_from" value="<?php echo e(request('date_from')); ?>"
                            class="w-full p-3 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 transition-all duration-300 hover:border-green-500/30" />
                    </div>
                </div>

                <!-- Date To Filter -->
                <div class="group">
                    <label for="date_to" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-orange-400 mr-2"></i>
                        Date To
                    </label>
                    <div class="relative">
                        <input type="date" id="date_to" name="date_to" value="<?php echo e(request('date_to')); ?>"
                            class="w-full p-3 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500/50 transition-all duration-300 hover:border-orange-500/30" />
                    </div>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex flex-wrap justify-end gap-4 pt-6 mt-6 border-t border-gray-700/50">
                <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="group px-6 py-3 bg-gray-800/80 hover:bg-gray-700/80 text-gray-300 hover:text-white border border-gray-600/50 hover:border-gray-500/50 font-medium rounded-lg transition-all duration-300 flex items-center">
                    <i class="fas fa-undo mr-2 group-hover:rotate-180 transition-transform duration-300"></i> Reset Filters
                </a>
                <button type="submit" class="group px-6 py-3 bg-gradient-to-r from-yellow-600 to-pink-600 hover:from-yellow-500 hover:to-pink-500 text-white font-medium rounded-lg transition-all duration-300 flex items-center shadow-lg hover:shadow-yellow-500/20">
                    <i class="fas fa-search mr-2 group-hover:scale-110 transition-transform duration-300"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Activity Logs Table -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl shadow-xl relative overflow-hidden admin-card-hover">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-700/50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center">
                    <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Activity Log Records</h2>
                        <p class="text-gray-400 text-sm mt-1">Monitor all system activities and user actions</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-yellow-900/30 text-yellow-400 text-sm py-2 px-4 rounded-lg border border-yellow-700/30 flex items-center">
                        <i class="fas fa-database mr-2"></i>
                        <?php echo e($activityLogs->total()); ?> entries
                    </span>
                    <?php if(request()->hasAny(['user_id', 'action', 'date_from', 'date_to'])): ?>
                        <span class="bg-blue-900/30 text-blue-400 text-sm py-2 px-4 rounded-lg border border-blue-700/30 flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            Filtered
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="p-6 border-b border-gray-700/50">
            <div class="relative group max-w-md">
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-pink-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative bg-gray-900 border border-gray-700 rounded-lg flex items-center overflow-hidden">
                    <input type="text" id="search-logs" placeholder="Search logs by user, action, or description..."
                        class="bg-transparent border-0 px-4 py-3 focus:outline-none text-gray-200 w-full placeholder-gray-500">
                    <div class="px-3 text-yellow-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-gray-700/50">
                            User
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-gray-700/50">
                            Action
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-gray-700/50">
                            IP Address
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-gray-700/50">
                            Date & Time
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-gray-700/50">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="logs-table-body">
                    <?php $__empty_1 = true; $__currentLoopData = $activityLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200 log-row">
                            <td class="px-6 py-4">
                                <?php if($log->user): ?>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                            <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                            <span class="relative"><?php echo e(strtoupper(substr($log->user->username, 0, 1))); ?></span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white user-name">
                                                <?php echo e($log->user->username); ?>

                                            </div>
                                            <div class="text-xs text-gray-400">
                                                <?php echo e($log->user->email); ?>

                                            </div>
                                            <?php if($log->user->role !== 'user'): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                                    <?php if($log->user->role === 'admin'): ?> bg-yellow-900/50 text-yellow-300 border border-yellow-700/50
                                                    <?php elseif($log->user->role === 'teacher'): ?> bg-blue-900/50 text-blue-300 border border-blue-700/50
                                                    <?php elseif($log->user->role === 'agent'): ?> bg-orange-900/50 text-orange-300 border border-orange-700/50
                                                    <?php endif; ?>">
                                                    <?php echo e(ucfirst($log->user->role)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center text-gray-300 mr-3 shadow-md relative overflow-hidden">
                                            <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:8px_8px]"></div>
                                            <i class="fas fa-cogs relative"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white user-name">System</div>
                                            <div class="text-xs text-gray-400">Automated action</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <?php
                                        $badgeClass = 'badge-blue';
                                        $icon = 'fa-info-circle';

                                        if (Str::contains($log->action, ['login', 'logout', 'register'])) {
                                            $badgeClass = 'badge-green';
                                            $icon = 'fa-sign-in-alt';
                                        } elseif (Str::contains($log->action, ['create', 'add', 'insert'])) {
                                            $badgeClass = 'badge-purple';
                                            $icon = 'fa-plus-circle';
                                        } elseif (Str::contains($log->action, ['update', 'edit', 'modify'])) {
                                            $badgeClass = 'badge-yellow';
                                            $icon = 'fa-edit';
                                        } elseif (Str::contains($log->action, ['delete', 'remove'])) {
                                            $badgeClass = 'badge-red';
                                            $icon = 'fa-trash-alt';
                                        } elseif (Str::contains($log->action, ['view', 'access', 'visit'])) {
                                            $badgeClass = 'badge-orange';
                                            $icon = 'fa-eye';
                                        }
                                    ?>

                                    <span class="badge <?php echo e($badgeClass); ?> mb-2 action-badge">
                                        <i class="fas <?php echo e($icon); ?> mr-1"></i>
                                        <?php echo e($log->action); ?>

                                    </span>

                                    <?php if($log->description): ?>
                                        <div class="text-sm text-gray-300 mt-1 max-w-xs truncate hover:max-w-none hover:whitespace-normal transition-all duration-200 cursor-pointer log-description" title="<?php echo e($log->description); ?>">
                                            <?php echo e($log->description); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-gray-400">
                                    <div class="bg-gray-800/80 p-1.5 rounded-lg mr-2 shadow-inner">
                                        <i class="fas fa-network-wired text-blue-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-mono text-sm"><?php echo e($log->ip_address); ?></span>
                                        <?php if($log->ip_address === request()->ip()): ?>
                                            <div class="text-xs text-green-400 mt-1">Current IP</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-gray-400">
                                    <div class="bg-gray-800/80 p-1.5 rounded-lg mr-2 shadow-inner">
                                        <i class="far fa-clock text-green-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium"><?php echo e($log->created_at->format('M d, Y')); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo e($log->created_at->format('H:i:s')); ?></div>
                                        <div class="text-xs text-blue-400 mt-1"><?php echo e($log->created_at->diffForHumans()); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="<?php echo e(route('admin.activity-logs.show', $log->id)); ?>"
                                   class="group bg-yellow-900/40 hover:bg-yellow-800/60 text-yellow-300 hover:text-yellow-200 border border-yellow-700/50 hover:border-yellow-600/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center w-fit">
                                    <i class="fas fa-eye mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Details</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-gray-800/80 flex items-center justify-center text-gray-400 mb-4">
                                        <i class="fas fa-history text-3xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-white mb-2">No activity logs found</h3>
                                    <p class="text-gray-400 max-w-md">Try adjusting your search filters or check back later when there's more activity.</p>
                                    <div class="mt-4">
                                        <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="text-yellow-400 hover:text-yellow-300 text-sm underline">
                                            Clear all filters
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-700/50 bg-gray-800/30">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-400">
                    Showing <?php echo e($activityLogs->firstItem() ?? 0); ?> to <?php echo e($activityLogs->lastItem() ?? 0); ?> of <?php echo e($activityLogs->total()); ?> results
                </div>
                <div class="pagination-wrapper">
                    <?php echo e($activityLogs->withQueryString()->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter panel toggle
        const filterButton = document.getElementById('filterButton');
        const filterPanel = document.getElementById('filterPanel');
        const closeFilterButton = document.getElementById('closeFilterPanel');

        function toggleFilterPanel() {
            if (filterPanel.classList.contains('hidden')) {
                // Show panel with animation
                filterPanel.classList.remove('hidden');
                filterPanel.style.maxHeight = '0';
                filterPanel.style.opacity = '0';
                filterPanel.style.overflow = 'hidden';

                setTimeout(() => {
                    filterPanel.style.maxHeight = '1000px';
                    filterPanel.style.opacity = '1';
                    filterPanel.style.transition = 'max-height 0.5s ease-in-out, opacity 0.3s ease-in-out';
                }, 10);
            } else {
                // Hide panel with animation
                filterPanel.style.maxHeight = '0';
                filterPanel.style.opacity = '0';

                setTimeout(() => {
                    filterPanel.classList.add('hidden');
                    filterPanel.style.maxHeight = '';
                    filterPanel.style.opacity = '';
                }, 500);
            }
        }

        filterButton.addEventListener('click', toggleFilterPanel);
        if (closeFilterButton) {
            closeFilterButton.addEventListener('click', toggleFilterPanel);
        }

        // Search functionality
        const searchInput = document.getElementById('search-logs');
        const tableRows = document.querySelectorAll('.log-row');

        if (searchInput && tableRows.length > 0) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const userName = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
                    const actionBadge = row.querySelector('.action-badge')?.textContent.toLowerCase() || '';
                    const description = row.querySelector('.log-description')?.textContent.toLowerCase() || '';

                    const matchesSearch = userName.includes(searchTerm) ||
                                        actionBadge.includes(searchTerm) ||
                                        description.includes(searchTerm);

                    if (matchesSearch) {
                        row.style.display = '';
                        visibleCount++;

                        // Add highlight effect
                        if (searchTerm !== '') {
                            row.classList.add('bg-yellow-900/10');
                            setTimeout(() => {
                                row.classList.remove('bg-yellow-900/10');
                            }, 300);
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update visible count or show no results message
                updateSearchResults(visibleCount, searchTerm);
            });

            // Add focus effects
            searchInput.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('ring-2', 'ring-yellow-500/50');
            });

            searchInput.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('ring-2', 'ring-yellow-500/50');
            });
        }

        function updateSearchResults(count, searchTerm) {
            // You can add logic here to show/hide a "no results" message
            // or update a results counter if needed
        }

        // Make description text expandable on click
        document.querySelectorAll('.log-description').forEach(element => {
            element.addEventListener('click', function() {
                this.classList.toggle('truncate');
                this.classList.toggle('whitespace-normal');
            });
        });

        // Add loading state for filter form
        const filterForm = document.querySelector('#filterPanel form');
        if (filterForm) {
            filterForm.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Applying...';
                    submitButton.disabled = true;
                }
            });
        }

        // Auto-refresh functionality (optional)
        let autoRefreshInterval;
        const autoRefreshCheckbox = document.getElementById('auto-refresh');

        function startAutoRefresh() {
            autoRefreshInterval = setInterval(() => {
                // Only refresh if no search is active and no filters are applied
                if (!searchInput?.value && !document.querySelector('#filterPanel:not(.hidden)')) {
                    window.location.reload();
                }
            }, 30000); // Refresh every 30 seconds
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        }

        // Uncomment to enable auto-refresh
        // startAutoRefresh();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/admin/activity-logs/index.blade.php ENDPATH**/ ?>