<?php $__env->startSection('title', 'Leaderboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Leaderboard</h1>
            <p class="text-blue-100">See how you rank against other students and compete for the top spot.</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-4">
            <select id="timeFilter" class="bg-white/20 border border-white/30 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                <option value="all">All Time</option>
                <option value="month">This Month</option>
                <option value="week">This Week</option>
            </select>
        </div>
    </div>
</div>

<!-- Top 3 Winners -->
<div class="section-card mb-8">
    <div class="section-header">
        <i class="fas fa-trophy mr-2"></i> Top Performers
    </div>
    <div class="section-content">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php if(count($leaders) >= 3): ?>
                <!-- Second Place -->
                <div class="order-2 md:order-1">
                    <div class="bg-gray-800 rounded-xl p-6 text-center relative shadow-lg transition-transform hover:scale-105">
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-16 h-16 rounded-full bg-gray-500 border-4 border-gray-700 flex items-center justify-center shadow-lg">
                                <i class="fas fa-medal text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <div class="w-20 h-20 rounded-full bg-gray-700 mx-auto mb-4 flex items-center justify-center border-4 border-gray-600">
                                <span class="text-white text-2xl font-bold"><?php echo e(substr($leaders[1]->username, 0, 1)); ?></span>
                            </div>
                            <h3 class="text-white text-xl font-bold mb-1"><?php echo e($leaders[1]->username); ?></h3>
                            <p class="text-gray-400 text-sm mb-4">2nd Place</p>
                            <div class="bg-gray-600 text-white text-xl font-bold py-2 px-4 rounded-lg inline-block shadow-md">
                                <?php echo e($leaders[1]->total_score); ?> pts
                            </div>
                            <p class="text-gray-400 text-sm mt-2"><?php echo e($leaders[1]->quizzes_count); ?> Quizzes</p>
                        </div>
                    </div>
                </div>

                <!-- First Place -->
                <div class="order-1 md:order-2">
                    <div class="bg-gradient-to-b from-primary-900 to-secondary-900 rounded-xl p-6 text-center relative transform md:scale-110 z-10 shadow-xl transition-transform hover:scale-105">
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-20 h-20 rounded-full bg-yellow-500 border-4 border-yellow-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-crown text-white text-3xl"></i>
                            </div>
                        </div>
                        <div class="mt-10">
                            <div class="w-24 h-24 rounded-full bg-gray-700 mx-auto mb-4 flex items-center justify-center border-4 border-yellow-500">
                                <span class="text-white text-3xl font-bold"><?php echo e(substr($leaders[0]->username, 0, 1)); ?></span>
                            </div>
                            <h3 class="text-white text-2xl font-bold mb-1"><?php echo e($leaders[0]->username); ?></h3>
                            <p class="text-yellow-400 text-sm mb-4">1st Place</p>
                            <div class="bg-yellow-500 text-white text-2xl font-bold py-2 px-6 rounded-lg inline-block shadow-md">
                                <?php echo e($leaders[0]->total_score); ?> pts
                            </div>
                            <p class="text-gray-400 text-sm mt-2"><?php echo e($leaders[0]->quizzes_count); ?> Quizzes</p>
                        </div>
                    </div>
                </div>

                <!-- Third Place -->
                <div class="order-3">
                    <div class="bg-gray-800 rounded-xl p-6 text-center relative shadow-lg transition-transform hover:scale-105">
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-16 h-16 rounded-full bg-yellow-700 border-4 border-yellow-800 flex items-center justify-center shadow-lg">
                                <i class="fas fa-medal text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-8">
                            <div class="w-20 h-20 rounded-full bg-gray-700 mx-auto mb-4 flex items-center justify-center border-4 border-gray-600">
                                <span class="text-white text-2xl font-bold"><?php echo e(substr($leaders[2]->username, 0, 1)); ?></span>
                            </div>
                            <h3 class="text-white text-xl font-bold mb-1"><?php echo e($leaders[2]->username); ?></h3>
                            <p class="text-gray-400 text-sm mb-4">3rd Place</p>
                            <div class="bg-yellow-700 text-white text-xl font-bold py-2 px-4 rounded-lg inline-block shadow-md">
                                <?php echo e($leaders[2]->total_score); ?> pts
                            </div>
                            <p class="text-gray-400 text-sm mt-2"><?php echo e($leaders[2]->quizzes_count); ?> Quizzes</p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-span-3 bg-gray-800 rounded-xl p-6 text-center shadow-lg">
                    <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-gray-600">
                        <i class="fas fa-trophy text-gray-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Leaderboard Data</h3>
                    <p class="text-gray-400">There are not enough participants yet. Start taking quizzes to appear on the leaderboard!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Full Leaderboard -->
<div class="section-card mb-8">
    <div class="section-header">
        <i class="fas fa-list-ol mr-2"></i> Full Ranking
    </div>
    <div class="section-content">
        <?php if(count($leaders) > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800 text-gray-400 text-sm uppercase">
                            <th class="py-3 px-4 text-left rounded-tl-lg">Rank</th>
                            <th class="py-3 px-4 text-left">Student</th>
                            <th class="py-3 px-4 text-center">Quizzes</th>
                            <th class="py-3 px-4 text-center">Avg. Score</th>
                            <th class="py-3 px-4 text-right rounded-tr-lg">Total Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $leaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($index % 2 === 0 ? 'bg-gray-800 bg-opacity-40' : 'bg-gray-800 bg-opacity-20'); ?> <?php echo e(auth()->id() == $user->id ? 'bg-primary-900 bg-opacity-40' : ''); ?> hover:bg-gray-700 transition-colors">
                                <td class="py-4 px-4 text-left">
                                    <?php if($index < 3): ?>
                                        <div class="w-8 h-8 rounded-full <?php echo e($index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-500' : 'bg-yellow-700')); ?> flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold"><?php echo e($index + 1); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">
                                            <span class="text-white"><?php echo e($index + 1); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-left">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center mr-3 border-2 <?php echo e(auth()->id() == $user->id ? 'border-primary-500' : 'border-gray-600'); ?>">
                                            <span class="text-white font-bold"><?php echo e(substr($user->username, 0, 1)); ?></span>
                                        </div>
                                        <div>
                                            <div class="text-white font-semibold"><?php echo e($user->username); ?></div>
                                            <?php if(auth()->id() == $user->id): ?>
                                                <div class="text-primary-400 text-xs">You</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center text-gray-400"><?php echo e($user->quizzes_count); ?></td>
                                <td class="py-4 px-4 text-center">
                                    <?php
                                        $avgScore = $user->quizzes_count > 0 ? round($user->total_score / $user->quizzes_count) : 0;
                                    ?>
                                    <div class="flex items-center justify-center">
                                        <div class="w-full max-w-[100px] bg-gray-700 rounded-full h-2.5 mr-2">
                                            <div class="bg-primary-600 h-2.5 rounded-full" style="width: <?php echo e(min(100, $avgScore)); ?>%"></div>
                                        </div>
                                        <span class="text-white"><?php echo e($avgScore); ?>%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-white font-bold text-lg"><?php echo e($user->total_score); ?></span>
                                    <span class="text-gray-400 text-sm">pts</span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-700 mb-4">
                    <i class="fas fa-chart-bar text-gray-500 text-2xl"></i>
                </div>
                <p class="text-gray-400">No leaderboard data available yet.</p>
                <p class="text-sm text-gray-500 mt-2">Start taking quizzes to appear on the leaderboard!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Your Position -->
<?php if(count($leaders) > 0): ?>
    <?php
        $currentUser = null;
        $userRank = 0;

        foreach($leaders as $index => $user) {
            if($user->id == auth()->id()) {
                $currentUser = $user;
                $userRank = $index + 1;
                break;
            }
        }
    ?>

    <?php if($currentUser): ?>
        <div class="section-card mb-8">
            <div class="section-header">
                <i class="fas fa-user mr-2"></i> Your Position
            </div>
            <div class="section-content">
                <div class="bg-gradient-to-r from-primary-900 to-secondary-900 bg-opacity-30 rounded-xl p-6 shadow-lg">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-16 h-16 rounded-full bg-primary-700 border-4 border-primary-600 flex items-center justify-center mr-4 shadow-md">
                                <span class="text-white text-2xl font-bold"><?php echo e(substr($currentUser->username, 0, 1)); ?></span>
                            </div>
                            <div>
                                <h3 class="text-white text-xl font-bold"><?php echo e($currentUser->username); ?></h3>
                                <p class="text-primary-300">Rank #<?php echo e($userRank); ?> of <?php echo e(count($leaders)); ?></p>
                            </div>
                        </div>

                        <div class="text-center md:text-right">
                            <div class="text-3xl font-bold text-white"><?php echo e($currentUser->total_score); ?></div>
                            <p class="text-primary-300">Total Points</p>
                        </div>
                    </div>

                    <?php if($userRank > 1): ?>
                        <?php
                            $pointsToNextRank = $leaders[$userRank - 2]->total_score - $currentUser->total_score;
                        ?>
                        <div class="mt-6">
                            <p class="text-gray-300 mb-2">You need <span class="text-primary-300 font-bold"><?php echo e($pointsToNextRank); ?></span> more points to reach rank #<?php echo e($userRank - 1); ?></p>
                            <div class="w-full bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                <?php
                                    $progressToNext = $pointsToNextRank > 0 ?
                                        (($currentUser->total_score / ($currentUser->total_score + $pointsToNextRank)) * 100) : 100;
                                ?>
                                <div class="bg-primary-600 h-2.5 rounded-full" style="width: <?php echo e($progressToNext); ?>%"></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mt-6 text-center">
                        <a href="<?php echo e(route('student.courses')); ?>" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors shadow-md">
                            <i class="fas fa-book-open mr-2"></i> Explore Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Time filter functionality
        document.getElementById('timeFilter').addEventListener('change', function() {
            // In a real application, this would trigger an AJAX request to update the data
            // For now, we'll just show an alert
            alert('Time filter changed to: ' + this.value);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/leaderboard.blade.php ENDPATH**/ ?>