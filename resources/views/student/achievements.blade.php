@extends('layouts.student')

@section('title', 'My Achievements')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Achievements</h1>
            <p class="text-blue-100">Track your accomplishments and unlock rewards as you learn.</p>
        </div>
    </div>
</div>

<!-- Achievement Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-trophy"></i>
        </div>
        <div>
            <div class="stats-label">Total Score</div>
            <div class="stats-value">{{ $totalScore }}</div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon success">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <div class="stats-label">Quizzes Taken</div>
            <div class="stats-value">{{ $quizzesTaken }}</div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon warning">
            <i class="fas fa-medal"></i>
        </div>
        <div>
            <div class="stats-label">Achievements</div>
            <div class="stats-value">{{ count(array_filter($achievements, function($a) { return $a['unlocked']; })) }}</div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon danger">
            <i class="fas fa-lock"></i>
        </div>
        <div>
            <div class="stats-label">Locked</div>
            <div class="stats-value">{{ count(array_filter($achievements, function($a) { return !$a['unlocked']; })) }}</div>
        </div>
    </div>
</div>

<!-- Achievement Progress -->
<div class="data-card p-6 mb-8">
    <h2 class="section-title flex items-center mb-4">
        <i class="fas fa-chart-pie text-blue-500 mr-2"></i>
        Achievement Progress
    </h2>

    <div class="w-full bg-gray-700 rounded-full h-4 mb-6">
        @php
            $unlockedCount = count(array_filter($achievements, function($a) { return $a['unlocked']; }));
            $totalCount = count($achievements);
            $progressPercentage = $totalCount > 0 ? ($unlockedCount / $totalCount) * 100 : 0;
        @endphp
        <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progressPercentage }}%"></div>
    </div>

    <div class="flex justify-between text-sm text-gray-400 mb-8">
        <div>{{ $unlockedCount }} / {{ $totalCount }} Achievements</div>
        <div>{{ round($progressPercentage) }}% Complete</div>
    </div>

    <!-- Achievement Tiers -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $tiers = [
                'bronze' => [
                    'name' => 'Bronze',
                    'icon' => 'medal',
                    'color' => 'yellow-700',
                    'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'bronze' && $a['unlocked']; })),
                    'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'bronze'; }))
                ],
                'silver' => [
                    'name' => 'Silver',
                    'icon' => 'medal',
                    'color' => 'gray-400',
                    'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'silver' && $a['unlocked']; })),
                    'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'silver'; }))
                ],
                'gold' => [
                    'name' => 'Gold',
                    'icon' => 'medal',
                    'color' => 'yellow-400',
                    'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'gold' && $a['unlocked']; })),
                    'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'gold'; }))
                ],
                'diamond' => [
                    'name' => 'Diamond',
                    'icon' => 'gem',
                    'color' => 'blue-400',
                    'count' => count(array_filter($achievements, function($a) { return $a['tier'] === 'diamond' && $a['unlocked']; })),
                    'total' => count(array_filter($achievements, function($a) { return $a['tier'] === 'diamond'; }))
                ]
            ];
        @endphp

        @foreach($tiers as $key => $tier)
            <div class="bg-gray-800 rounded-lg p-4 text-center">
                <div class="w-16 h-16 rounded-full bg-{{ $tier['color'] }} bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-{{ $tier['icon'] }} text-{{ $tier['color'] }} text-2xl"></i>
                </div>
                <h3 class="text-white font-bold mb-2">{{ $tier['name'] }}</h3>
                <div class="text-gray-400 text-sm mb-2">{{ $tier['count'] }} / {{ $tier['total'] }} Unlocked</div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-{{ $tier['color'] }} h-2 rounded-full" style="width: {{ $tier['total'] > 0 ? ($tier['count'] / $tier['total']) * 100 : 0 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Achievement List -->
<div class="data-card p-6 mb-8">
    <h2 class="section-title flex items-center mb-6">
        <i class="fas fa-trophy text-blue-500 mr-2"></i>
        My Achievements
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($achievements as $ach)
            @php
                $tierColors = [
                    'bronze' => [
                        'bg' => 'bg-yellow-700',
                        'text' => 'text-yellow-200',
                        'border' => 'border-yellow-600',
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
            @endphp

            <div class="bg-gray-800 rounded-lg overflow-hidden {{ $ach['unlocked'] ? '' : 'opacity-60' }}">
                <div class="p-4 {{ $tierColor['bg'] }} flex items-center">
                    <div class="w-10 h-10 rounded-full bg-black bg-opacity-20 flex items-center justify-center mr-3">
                        <i class="fas fa-{{ $tierColor['icon'] }} {{ $tierColor['text'] }}"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-bold">{{ $ach['title'] }}</h3>
                        <div class="text-xs {{ $tierColor['text'] }} uppercase font-semibold">{{ $ach['tier'] }} Tier</div>
                    </div>
                    <div class="ml-auto">
                        @if($ach['unlocked'])
                            <div class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Unlocked</div>
                        @else
                            <div class="bg-gray-600 text-gray-300 text-xs font-bold px-2 py-1 rounded-full">Locked</div>
                        @endif
                    </div>
                </div>

                <div class="p-4">
                    <p class="text-gray-400 mb-3">{{ $ach['desc'] }}</p>

                    @if($ach['unlocked'])
                        <div class="flex items-center text-green-400 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Completed</span>
                        </div>
                    @else
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-lock mr-2"></i>
                            <span>Keep learning to unlock</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Achievement Rewards -->
<div class="data-card p-6 mb-8">
    <h2 class="section-title flex items-center mb-6">
        <i class="fas fa-gift text-blue-500 mr-2"></i>
        Rewards
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-lg p-4 text-center {{ $totalScore >= 100 ? '' : 'opacity-60' }}">
            <div class="w-16 h-16 rounded-full bg-purple-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-certificate text-purple-400 text-2xl"></i>
            </div>
            <h3 class="text-white font-bold mb-2">Beginner Certificate</h3>
            <p class="text-gray-400 text-sm mb-4">Earn 100 points to unlock this reward</p>

            @if($totalScore >= 100)
                <button class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 w-full">
                    Claim Reward
                </button>
            @else
                <div class="bg-gray-700 text-gray-500 font-medium py-2 px-4 rounded-lg w-full cursor-not-allowed">
                    Locked ({{ $totalScore }}/100)
                </div>
            @endif
        </div>

        <div class="bg-gray-800 rounded-lg p-4 text-center {{ $totalScore >= 300 ? '' : 'opacity-60' }}">
            <div class="w-16 h-16 rounded-full bg-blue-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-certificate text-blue-400 text-2xl"></i>
            </div>
            <h3 class="text-white font-bold mb-2">Intermediate Certificate</h3>
            <p class="text-gray-400 text-sm mb-4">Earn 300 points to unlock this reward</p>

            @if($totalScore >= 300)
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 w-full">
                    Claim Reward
                </button>
            @else
                <div class="bg-gray-700 text-gray-500 font-medium py-2 px-4 rounded-lg w-full cursor-not-allowed">
                    Locked ({{ $totalScore }}/300)
                </div>
            @endif
        </div>

        <div class="bg-gray-800 rounded-lg p-4 text-center {{ $totalScore >= 500 ? '' : 'opacity-60' }}">
            <div class="w-16 h-16 rounded-full bg-yellow-900 bg-opacity-20 flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-certificate text-yellow-400 text-2xl"></i>
            </div>
            <h3 class="text-white font-bold mb-2">Advanced Certificate</h3>
            <p class="text-gray-400 text-sm mb-4">Earn 500 points to unlock this reward</p>

            @if($totalScore >= 500)
                <button class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 w-full">
                    Claim Reward
                </button>
            @else
                <div class="bg-gray-700 text-gray-500 font-medium py-2 px-4 rounded-lg w-full cursor-not-allowed">
                    Locked ({{ $totalScore }}/500)
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
