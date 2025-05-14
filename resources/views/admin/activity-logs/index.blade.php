@extends('layouts.admin')

@section('title', 'Activity Logs')

@push('styles')
<style>
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0;
        }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Custom select styling */
    .custom-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
    }

    /* Input focus effect */
    .input-focus-effect {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-focus-effect:focus-within {
        transform: translateY(-2px);
    }

    .input-focus-effect:focus-within::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -5px;
        height: 3px;
        background: linear-gradient(to right, #3B82F6, #8B5CF6);
        border-radius: 3px;
        opacity: 0.7;
    }

    /* Filter panel animation */
    .filter-panel-enter {
        max-height: 0;
        opacity: 0;
        overflow: hidden;
    }

    .filter-panel-enter-active {
        max-height: 1000px;
        opacity: 1;
        transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out;
    }

    .filter-panel-exit {
        max-height: 1000px;
        opacity: 1;
        overflow: hidden;
    }

    .filter-panel-exit-active {
        max-height: 0;
        opacity: 0;
        transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out;
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
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-history mr-3 text-blue-300"></i>
                Activity Logs
            </h1>
            <p class="text-blue-100 opacity-90">Track and monitor all system activities and user actions</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
            <button type="button" id="filterButton" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-blue-500/20 hover:shadow-xl">
                <i class="fas fa-filter mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Filter Logs</span>
            </button>

            <form action="{{ route('admin.activity-logs.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="group bg-red-600/80 hover:bg-red-700/80 text-white font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-red-500/20 hover:shadow-xl">
                    <i class="fas fa-trash-alt mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    <span>Clear All</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Success Message -->
@if (session('success'))
    <div class="mb-6 bg-gradient-to-r from-green-900/80 to-green-800/80 border border-green-700/50 text-green-300 px-6 py-4 rounded-xl flex items-center shadow-lg">
        <div class="bg-green-800/80 p-2 rounded-lg mr-4 shadow-inner">
            <i class="fas fa-check-circle text-green-400 text-xl"></i>
        </div>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<!-- Filter Panel -->
<div id="filterPanel" class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-8 {{ request('user_id') || request('action') || request('date_from') || request('date_to') ? '' : 'hidden' }}">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-800/5"></div>

    <div class="relative">
        <div class="flex items-center mb-6">
            <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                <i class="fas fa-filter"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Filter Activity Logs</h2>
        </div>

        <form action="{{ route('admin.activity-logs.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- User Filter -->
                <div class="bg-gray-800/50 rounded-xl p-5 border border-gray-700/50">
                    <label for="user_id" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-user text-blue-400 mr-2"></i>
                        User
                    </label>
                    <div class="relative input-focus-effect">
                        <select id="user_id" name="user_id"
                            class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent appearance-none custom-select">
                            <option value="">All Users</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Filter -->
                <div class="bg-gray-800/50 rounded-xl p-5 border border-gray-700/50">
                    <label for="action" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-tag text-purple-400 mr-2"></i>
                        Action Type
                    </label>
                    <div class="relative input-focus-effect">
                        <select id="action" name="action"
                            class="w-full p-3 pl-4 pr-10 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent appearance-none custom-select">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date From Filter -->
                <div class="bg-gray-800/50 rounded-xl p-5 border border-gray-700/50">
                    <label for="date_from" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
                        Date From
                    </label>
                    <div class="relative input-focus-effect">
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            class="w-full p-3 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-transparent" />
                    </div>
                </div>

                <!-- Date To Filter -->
                <div class="bg-gray-800/50 rounded-xl p-5 border border-gray-700/50">
                    <label for="date_to" class="block text-gray-300 font-medium mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-red-400 mr-2"></i>
                        Date To
                    </label>
                    <div class="relative input-focus-effect">
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            class="w-full p-3 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500/50 focus:border-transparent" />
                    </div>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex flex-wrap justify-end gap-4 pt-6 mt-2">
                <a href="{{ route('admin.activity-logs.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium rounded-lg transition-all duration-300 flex items-center">
                    <i class="fas fa-undo mr-2"></i> Reset Filters
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-medium rounded-lg transition-all duration-300 flex items-center shadow-lg hover:shadow-blue-700/30">
                    <i class="fas fa-search mr-2"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Activity Logs Table -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-xl relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-800/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-700/50">
            <div class="flex items-center">
                <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                    <i class="fas fa-list-alt"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Activity Log Records</h2>
                <span class="ml-3 bg-blue-900/30 text-blue-400 text-sm py-1 px-3 rounded-full border border-blue-700/30">
                    {{ $activityLogs->total() }} entries
                </span>
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
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr class="border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200">
                            <td class="px-6 py-4">
                                @if ($log->user)
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                            <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                            <span class="relative">{{ strtoupper(substr($log->user->username, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">
                                                {{ $log->user->username }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $log->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center text-gray-300 mr-3 shadow-md relative overflow-hidden">
                                            <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:8px_8px]"></div>
                                            <i class="fas fa-cogs relative"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">System</div>
                                            <div class="text-xs text-gray-400">Automated action</div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    @php
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
                                        }
                                    @endphp

                                    <span class="badge {{ $badgeClass }} mb-2">
                                        <i class="fas {{ $icon }} mr-1"></i>
                                        {{ $log->action }}
                                    </span>

                                    @if ($log->description)
                                        <div class="text-sm text-gray-300 mt-1 line-clamp-2 hover:line-clamp-none transition-all duration-200 cursor-pointer">
                                            {{ $log->description }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-gray-400">
                                    <div class="bg-gray-800/80 p-1.5 rounded-lg mr-2 shadow-inner">
                                        <i class="fas fa-network-wired text-blue-400 text-sm"></i>
                                    </div>
                                    <span>{{ $log->ip_address }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-gray-400">
                                    <div class="bg-gray-800/80 p-1.5 rounded-lg mr-2 shadow-inner">
                                        <i class="far fa-clock text-green-400 text-sm"></i>
                                    </div>
                                    <div>
                                        <div>{{ $log->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.activity-logs.show', $log->id) }}"
                                   class="group bg-blue-900/40 hover:bg-blue-800/60 text-blue-300 border border-blue-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center w-fit">
                                    <i class="fas fa-eye mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Details</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 rounded-full bg-gray-800/80 flex items-center justify-center text-gray-400 mb-4">
                                        <i class="fas fa-search text-3xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-white mb-2">No activity logs found</h3>
                                    <p class="text-gray-400 max-w-md">Try adjusting your search filters or check back later when there's more activity.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-700/50">
            {{ $activityLogs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter panel toggle
        const filterButton = document.getElementById('filterButton');
        const filterPanel = document.getElementById('filterPanel');

        filterButton.addEventListener('click', function() {
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
        });

        // Make description text expandable
        document.querySelectorAll('.line-clamp-2').forEach(element => {
            element.addEventListener('click', function() {
                this.classList.toggle('line-clamp-2');
                this.classList.toggle('line-clamp-none');
            });
        });
    });
</script>
@endpush
