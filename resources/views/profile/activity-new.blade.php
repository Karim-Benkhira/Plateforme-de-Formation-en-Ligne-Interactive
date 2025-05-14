@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-history mr-3 text-blue-300"></i>
                Activity History
            </h1>
            <p class="text-blue-100 opacity-90">A record of your recent activity on the platform.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('profile.edit') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Profile
            </a>
        </div>
    </div>
</div>

<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
    <div class="relative">
        <div class="divide-y divide-gray-700/50">
            @forelse ($activityLogs as $log)
                <div class="py-5 {{ $loop->first ? '' : 'pt-5' }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-lg overflow-hidden 
                                @if (Str::contains($log->action, 'login'))
                                    bg-gradient-to-br from-green-800 to-green-900 text-green-400 border border-green-700/50
                                @elseif (Str::contains($log->action, 'logout'))
                                    bg-gradient-to-br from-blue-800 to-blue-900 text-blue-400 border border-blue-700/50
                                @elseif (Str::contains($log->action, 'update'))
                                    bg-gradient-to-br from-purple-800 to-purple-900 text-purple-400 border border-purple-700/50
                                @elseif (Str::contains($log->action, 'create'))
                                    bg-gradient-to-br from-indigo-800 to-indigo-900 text-indigo-400 border border-indigo-700/50
                                @elseif (Str::contains($log->action, 'delete'))
                                    bg-gradient-to-br from-red-800 to-red-900 text-red-400 border border-red-700/50
                                @elseif (Str::contains($log->action, 'two_factor'))
                                    bg-gradient-to-br from-yellow-800 to-yellow-900 text-yellow-400 border border-yellow-700/50
                                @else
                                    bg-gradient-to-br from-gray-800 to-gray-900 text-gray-400 border border-gray-700/50
                                @endif
                                flex items-center justify-center shadow-inner">
                                @if (Str::contains($log->action, 'login'))
                                    <i class="fas fa-sign-in-alt text-xl"></i>
                                @elseif (Str::contains($log->action, 'logout'))
                                    <i class="fas fa-sign-out-alt text-xl"></i>
                                @elseif (Str::contains($log->action, 'update'))
                                    <i class="fas fa-edit text-xl"></i>
                                @elseif (Str::contains($log->action, 'create'))
                                    <i class="fas fa-plus text-xl"></i>
                                @elseif (Str::contains($log->action, 'delete'))
                                    <i class="fas fa-trash-alt text-xl"></i>
                                @elseif (Str::contains($log->action, 'two_factor'))
                                    <i class="fas fa-shield-alt text-xl"></i>
                                @else
                                    <i class="fas fa-info-circle text-xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex flex-col sm:flex-row sm:justify-between">
                                <h3 class="text-base font-medium text-white mb-1 sm:mb-0">
                                    {{ Str::title(str_replace('_', ' ', str_replace('.', ' - ', $log->action))) }}
                                </h3>
                                <span class="text-sm text-blue-400">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($log->description)
                                <p class="mt-1 text-sm text-gray-300">{{ $log->description }}</p>
                            @endif
                            <div class="mt-3 flex flex-wrap gap-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-800/80 text-gray-300 border border-gray-700/50">
                                    <i class="fas fa-map-marker-alt mr-1.5 text-blue-400"></i>
                                    {{ $log->ip_address ?? 'Unknown IP' }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-800/80 text-gray-300 border border-gray-700/50">
                                    <i class="fas fa-clock mr-1.5 text-purple-400"></i>
                                    {{ $log->created_at->format('M d, Y H:i:s') }}
                                </span>
                                @if ($log->user_agent)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-800/80 text-gray-300 border border-gray-700/50">
                                        <i class="fas fa-laptop mr-1.5 text-green-400"></i>
                                        {{ Str::limit($log->user_agent, 30) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800/80 text-gray-400 mb-4">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-400 mb-2">No Activity Found</h3>
                    <p class="text-gray-500">There are no activity logs to display at this time.</p>
                </div>
            @endforelse
        </div>
        
        @if ($activityLogs->hasPages())
            <div class="mt-6 pt-6 border-t border-gray-700/50">
                {{ $activityLogs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
