<?php $__env->startSection('title', 'My Achievements'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Achievements</h1>
            <p class="text-blue-100">Track your accomplishments and unlock rewards as you learn.</p>
        </div>
        <div class="hidden md:flex items-center">
            <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-sm rounded-lg px-6 py-3 text-white">
                <span class="font-bold text-2xl"><?php echo e($totalScore); ?></span>
                <span class="ml-2">Total Points</span>
            </div>
        </div>
    </div>
</div>

<!-- Achievement Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-blue-800 flex items-center justify-center mr-3">
            <i class="fas fa-trophy text-white text-xl"></i>
        </div>
        <div>
            <div class="text-blue-100 text-sm">Total Score</div>
            <div class="text-white text-2xl font-bold"><?php echo e($totalScore); ?></div>
        </div>
    </div>

    <div class="stats-card bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-green-800 flex items-center justify-center mr-3">
            <i class="fas fa-question-circle text-white text-xl"></i>
        </div>
        <div>
            <div class="text-green-100 text-sm">Quizzes Taken</div>
            <div class="text-white text-2xl font-bold"><?php echo e($quizzesTaken); ?></div>
        </div>
    </div>

    <div class="stats-card bg-gradient-to-r from-amber-600 to-amber-700 rounded-lg p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-amber-800 flex items-center justify-center mr-3">
            <i class="fas fa-medal text-white text-xl"></i>
        </div>
        <div>
            <div class="text-amber-100 text-sm">Achievements</div>
            <div class="text-white text-2xl font-bold"><?php echo e(count(array_filter($achievements, function($a) { return $a['unlocked']; }))); ?></div>
        </div>
    </div>

    <div class="stats-card bg-gradient-to-r from-red-600 to-red-700 rounded-lg p-4 flex items-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="w-12 h-12 rounded-full bg-red-800 flex items-center justify-center mr-3">
            <i class="fas fa-lock text-white text-xl"></i>
        </div>
        <div>
            <div class="text-red-100 text-sm">Locked</div>
            <div class="text-white text-2xl font-bold"><?php echo e(count(array_filter($achievements, function($a) { return !$a['unlocked']; }))); ?></div>
        </div>
    </div>
</div>

<!-- Achievement Progress -->
<div class="section-card mb-8">
    <div class="section-header bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-4 flex items-center">
        <i class="fas fa-chart-pie mr-2 text-white"></i>
        <span class="text-white font-bold">Achievement Progress</span>
    </div>
    <div class="section-content bg-gray-900 rounded-b-lg p-6">
        <?php
            $unlockedCount = count(array_filter($achievements, function($a) { return $a['unlocked']; }));
            $totalCount = count($achievements);
            $progressPercentage = $totalCount > 0 ? ($unlockedCount / $totalCount) * 100 : 0;
        ?>

        <div class="relative mb-6">
            <div class="flex justify-between text-sm text-gray-400 mb-2">
                <div><?php echo e($unlockedCount); ?> / <?php echo e($totalCount); ?> Achievements</div>
                <div><?php echo e(round($progressPercentage)); ?>% Complete</div>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-4 mb-8">
                <div class="bg-primary-600 h-4 rounded-full transition-all duration-1000 ease-out" style="width: <?php echo e($progressPercentage); ?>%"></div>
            </div>

            <!-- Large percentage circle -->
            <div class="absolute right-0 top-10 md:top-0 transform md:translate-y-0">
                <div class="relative w-40 h-40">
                    <div class="absolute inset-0 rounded-full border-8 border-gray-700 opacity-20"></div>
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path class="stroke-current text-gray-700" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                        <path class="stroke-current text-primary-500" stroke-width="3" fill="none" stroke-dasharray="<?php echo e($progressPercentage); ?>, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-white text-5xl font-bold"><?php echo e(round($progressPercentage)); ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievement Tiers -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-16">
            <?php
                $tiers = [
                    'bronze' => [
                        'name' => 'Bronze',
                        'icon' => 'medal',
                        'color' => 'amber',
                        'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'bronze' && $a['unlocked']; })),
                        'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'bronze'; }))
                    ],
                    'silver' => [
                        'name' => 'Silver',
                        'icon' => 'medal',
                        'color' => 'gray',
                        'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'silver' && $a['unlocked']; })),
                        'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'silver'; }))
                    ],
                    'gold' => [
                        'name' => 'Gold',
                        'icon' => 'medal',
                        'color' => 'yellow',
                        'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'gold' && $a['unlocked']; })),
                        'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'gold'; }))
                    ],
                    'diamond' => [
                        'name' => 'Diamond',
                        'icon' => 'gem',
                        'color' => 'blue',
                        'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'diamond' && $a['unlocked']; })),
                        'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'diamond'; }))
                    ]
                ];
            ?>

            <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-<?php echo e($tier['color']); ?>-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-<?php echo e($tier['icon']); ?> text-<?php echo e($tier['color']); ?>-400 text-2xl"></i>
                    </div>
                    <h3 class="text-white font-bold mb-2"><?php echo e($tier['name']); ?></h3>
                    <div class="text-gray-400 text-sm mb-2"><?php echo e($tier['count']); ?> / <?php echo e($tier['total']); ?> Unlocked</div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-<?php echo e($tier['color']); ?>-500 h-2 rounded-full transition-all duration-1000 ease-out" style="width: <?php echo e($tier['total'] > 0 ? ($tier['count'] / $tier['total']) * 100 : 0); ?>%"></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Achievement List -->
<div class="section-card mb-8">
    <div class="section-header bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-4 flex items-center">
        <i class="fas fa-trophy mr-2 text-white"></i>
        <span class="text-white font-bold">My Achievements</span>
    </div>
    <div class="section-content bg-gray-900 rounded-b-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__currentLoopData = $achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $tierColors = [
                        'bronze' => [
                            'bg' => 'bg-amber-600',
                            'text' => 'text-amber-200',
                            'border' => 'border-amber-600',
                            'icon' => 'medal'
                        ],
                        'silver' => [
                            'bg' => 'bg-gray-500',
                            'text' => 'text-gray-200',
                            'border' => 'border-gray-400',
                            'icon' => 'medal'
                        ],
                        'gold' => [
                            'bg' => 'bg-yellow-500',
                            'text' => 'text-yellow-100',
                            'border' => 'border-yellow-400',
                            'icon' => 'medal'
                        ],
                        'diamond' => [
                            'bg' => 'bg-blue-600',
                            'text' => 'text-blue-100',
                            'border' => 'border-blue-500',
                            'icon' => 'gem'
                        ]
                    ];
                    $tierColor = $tierColors[$ach['tier']];
                ?>

                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 <?php echo e($ach['unlocked'] ? '' : 'opacity-60'); ?>">
                    <div class="flex items-center p-4">
                        <div class="w-10 h-10 rounded-full <?php echo e($tierColor['bg']); ?> flex items-center justify-center mr-3">
                            <i class="fas fa-<?php echo e($tierColor['icon']); ?> text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold"><?php echo e($ach['title']); ?></h3>
                            <div class="text-xs text-gray-400 uppercase font-semibold"><?php echo e($ach['tier']); ?> TIER</div>
                        </div>
                        <div class="ml-auto">
                            <?php if($ach['unlocked']): ?>
                                <div class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Unlocked</div>
                            <?php else: ?>
                                <div class="bg-gray-600 text-gray-300 text-xs font-bold px-2 py-1 rounded-full">Locked</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-700">
                        <p class="text-gray-400 mb-3"><?php echo e($ach['desc']); ?></p>

                        <?php if($ach['unlocked']): ?>
                            <div class="flex items-center text-green-400 text-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Completed</span>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fas fa-lock mr-2"></i>
                                <span>Keep learning to unlock</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Achievement Rewards -->
<div class="section-card mb-8">
    <div class="section-header bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-4 flex items-center">
        <i class="fas fa-gift mr-2 text-white"></i>
        <span class="text-white font-bold">Rewards</span>
    </div>
    <div class="section-content bg-gray-900 rounded-b-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-800 rounded-lg p-5 text-center <?php echo e($totalScore >= 100 ? '' : 'opacity-80'); ?>">
                <div class="w-16 h-16 rounded-full bg-purple-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-certificate text-purple-400 text-2xl"></i>
                </div>
                <h3 class="text-white font-bold mb-2">Beginner Certificate</h3>
                <p class="text-gray-400 text-sm mb-4">Earn 100 points to unlock this reward</p>

                <?php if($totalScore >= 100): ?>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 w-full transform hover:scale-105">
                        Claim Reward
                    </button>
                <?php else: ?>
                    <div class="relative bg-gray-700 text-gray-500 font-medium py-2 px-4 rounded-lg w-full cursor-not-allowed">
                        <div class="flex justify-between items-center">
                            <span>Locked</span>
                            <span><?php echo e($totalScore); ?>/100</span>
                        </div>
                        <div class="w-full bg-gray-800 rounded-full h-1 mt-1">
                            <div class="bg-purple-600 h-1 rounded-full" style="width: <?php echo e(min(100, ($totalScore / 100) * 100)); ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-gray-800 rounded-lg p-5 text-center <?php echo e($totalScore >= 300 ? '' : 'opacity-80'); ?>">
                <div class="w-16 h-16 rounded-full bg-blue-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-certificate text-blue-400 text-2xl"></i>
                </div>
                <h3 class="text-white font-bold mb-2">Intermediate Certificate</h3>
                <p class="text-gray-400 text-sm mb-4">Earn 300 points to unlock this reward</p>

                <?php if($totalScore >= 300): ?>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 w-full transform hover:scale-105">
                        Claim Reward
                    </button>
                <?php else: ?>
                    <div class="relative bg-gray-700 text-gray-500 font-medium py-2 px-4 rounded-lg w-full cursor-not-allowed">
                        <div class="flex justify-between items-center">
                            <span>Locked</span>
                            <span><?php echo e($totalScore); ?>/300</span>
                        </div>
                        <div class="w-full bg-gray-800 rounded-full h-1 mt-1">
                            <div class="bg-blue-600 h-1 rounded-full" style="width: <?php echo e(min(100, ($totalScore / 300) * 100)); ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-gray-800 rounded-lg p-5 text-center <?php echo e($totalScore >= 500 ? '' : 'opacity-80'); ?>">
                <div class="w-16 h-16 rounded-full bg-yellow-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-certificate text-yellow-400 text-2xl"></i>
                </div>
                <h3 class="text-white font-bold mb-2">Advanced Certificate</h3>
                <p class="text-gray-400 text-sm mb-4">Earn 500 points to unlock this reward</p>

                <?php if($totalScore >= 500): ?>
                    <button class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 w-full transform hover:scale-105">
                        Claim Reward
                    </button>
                <?php else: ?>
                    <div class="relative bg-gray-700 text-gray-500 font-medium py-2 px-4 rounded-lg w-full cursor-not-allowed">
                        <div class="flex justify-between items-center">
                            <span>Locked</span>
                            <span><?php echo e($totalScore); ?>/500</span>
                        </div>
                        <div class="w-full bg-gray-800 rounded-full h-1 mt-1">
                            <div class="bg-yellow-600 h-1 rounded-full" style="width: <?php echo e(min(100, ($totalScore / 500) * 100)); ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .section-card {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .section-card:hover {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }
    .bg-primary-600 {
        background-color: #4f46e5;
    }
    .bg-primary-500 {
        background-color: #6366f1;
    }
    .text-primary-500 {
        color: #6366f1;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to progress bars
        setTimeout(() => {
            document.querySelectorAll('.transition-all').forEach(el => {
                el.classList.add('animated');
            });
        }, 300);

        // Add hover effects to achievement cards
        const achievementCards = document.querySelectorAll('.bg-gray-800.rounded-lg');
        achievementCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                if (!this.classList.contains('opacity-60')) {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.3)';
                }
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/achievements-new.blade.php ENDPATH**/ ?>