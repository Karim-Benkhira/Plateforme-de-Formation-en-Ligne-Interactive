@extends('layouts.admin')

@section('title', 'Support Tickets')

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

    /* Tooltip styles */
    .tooltip-trigger {
        position: relative;
    }

    .tooltip-text {
        visibility: hidden;
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(17, 24, 39, 0.95);
        color: #e2e8f0;
        text-align: center;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s, visibility 0.3s;
        z-index: 10;
        border: 1px solid rgba(75, 85, 99, 0.3);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .tooltip-trigger:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Add a small arrow at the bottom of the tooltip */
    .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: rgba(17, 24, 39, 0.95) transparent transparent transparent;
    }

    /* Message text styles */
    .message-text {
        position: relative;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .message-text.expanded {
        -webkit-line-clamp: unset;
    }

    /* Custom select styling */
    .custom-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
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
                <i class="fas fa-headset mr-3 text-red-300"></i>
                Support Ticket Management
            </h1>
            <p class="text-blue-100 opacity-90">Manage and respond to user support tickets and inquiries.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-blue-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative">
                    <select id="status-filter"
                        class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 focus:outline-none text-gray-200 appearance-none pr-10 custom-select">
                        <option value="all">All Tickets</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-blue-800/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-red-900/70 text-red-400 rounded-lg p-2 mr-3 shadow-inner shadow-red-950/50">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <span>Support Tickets</span>
                <span class="ml-3 bg-red-900/30 text-red-400 text-sm py-1 px-3 rounded-full border border-red-700/30">
                    <span id="ticket-count">{{ count($reclamations) }}</span> tickets
                </span>
            </h2>

            <div class="relative group w-full md:w-auto">
                <div class="absolute inset-0 bg-gradient-to-r from-red-600/20 to-blue-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative bg-gray-900 border border-gray-700 rounded-lg flex items-center overflow-hidden">
                    <div class="px-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="ticket-search" placeholder="Search tickets..."
                        class="bg-transparent border-0 px-2 py-2.5 focus:outline-none text-gray-200 w-full placeholder-gray-500">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-700/50 shadow-inner bg-gray-900/50">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">User</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Message</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Status</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Submitted</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Response</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reclamations as $reclamation)
                    <tr class="ticket-row border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200" data-status="{{ $reclamation->status }}">
                        <td class="px-4 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <span class="relative">{{ strtoupper(substr($reclamation->user->username ?? 'U', 0, 1)) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium block text-white">{{ $reclamation->user->username ?? 'Unknown' }}</span>
                                    <span class="text-xs text-gray-400">{{ $reclamation->user->email ?? '' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="message-text text-gray-300 max-w-xs">
                                {{ $reclamation->message }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @if($reclamation->status === 'resolved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900/50 text-green-300 border border-green-700/50">
                                    <i class="fas fa-check-circle mr-1.5"></i> Resolved
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                                    <i class="fas fa-clock mr-1.5"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center text-gray-400">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ $reclamation->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="message-text text-gray-300 max-w-xs">
                                {{ $reclamation->response ?? 'No response yet' }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2">
                                @if($reclamation->status !== 'resolved')
                                    <a href="{{ route('admin.respondReclamation', $reclamation->id) }}"
                                       class="group bg-blue-900/40 hover:bg-blue-800/60 text-blue-300 border border-blue-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger">
                                        <i class="fas fa-reply mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                        <span>Reply</span>
                                        <span class="tooltip-text">Respond to Ticket</span>
                                    </a>
                                @else
                                    <button disabled
                                            class="bg-gray-800/80 text-gray-500 border border-gray-700/50 rounded-lg px-3 py-1.5 flex items-center opacity-50 cursor-not-allowed">
                                        <i class="fas fa-check mr-1.5"></i>
                                        <span>Resolved</span>
                                    </button>
                                @endif
                                <form action="{{ route('admin.deleteReclamation', $reclamation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="group bg-red-900/40 hover:bg-red-800/60 text-red-300 border border-red-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger"
                                            onclick="return confirm('Are you sure you want to delete this support ticket? This action cannot be undone.')">
                                        <i class="fas fa-trash-alt mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                        <span>Delete</span>
                                        <span class="tooltip-text">Delete Ticket</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($reclamations->isEmpty())
        <div class="text-center py-16 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-800/80 text-gray-400 mb-6">
                <i class="fas fa-ticket-alt text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">No support tickets found</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">All user inquiries have been addressed.</p>
        </div>
        @endif

        <!-- No Results Message (Hidden by default) -->
        <div id="no-results-message" class="hidden text-center py-8 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800/80 text-gray-400 mb-4">
                <i class="fas fa-search text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">No matching tickets</h3>
            <p class="text-gray-400">Try adjusting your search term or filter</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('ticket-search');
        const statusFilter = document.getElementById('status-filter');
        const ticketRows = document.querySelectorAll('.ticket-row');
        const ticketTable = document.querySelector('table');
        const noResultsMessage = document.getElementById('no-results-message');
        const ticketCountElement = document.getElementById('ticket-count');

        // Add focus effect to search input
        searchInput.addEventListener('focus', function() {
            this.parentElement.parentElement.classList.add('ring-2', 'ring-red-500/50');
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.parentElement.classList.remove('ring-2', 'ring-red-500/50');
        });

        // Add focus effect to status filter
        statusFilter.addEventListener('focus', function() {
            this.parentElement.parentElement.classList.add('ring-2', 'ring-red-500/50');
        });

        statusFilter.addEventListener('blur', function() {
            this.parentElement.parentElement.classList.remove('ring-2', 'ring-red-500/50');
        });

        // Enhanced search functionality
        searchInput.addEventListener('input', function() {
            filterTickets();
        });

        // Status filter functionality
        statusFilter.addEventListener('change', function() {
            filterTickets();
        });

        // Make message text expandable
        document.querySelectorAll('.message-text').forEach(element => {
            element.addEventListener('click', function() {
                this.classList.toggle('expanded');
            });
        });

        function filterTickets() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value;
            let visibleCount = 0;

            ticketRows.forEach(row => {
                const username = row.querySelector('.font-medium').textContent.toLowerCase();
                const email = row.querySelector('.text-xs.text-gray-400').textContent.toLowerCase();
                const messageElements = row.querySelectorAll('.message-text');
                const message = messageElements[0].textContent.toLowerCase();
                const response = messageElements[1].textContent.toLowerCase();
                const status = row.dataset.status;

                const matchesSearch = username.includes(searchTerm) ||
                                     email.includes(searchTerm) ||
                                     message.includes(searchTerm) ||
                                     response.includes(searchTerm);
                const matchesStatus = statusValue === 'all' || status === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;

                    // Add a subtle highlight effect for matching search terms
                    if (searchTerm !== '') {
                        // Reset any previous highlights
                        row.classList.add('bg-red-900/10');
                        setTimeout(() => {
                            row.classList.remove('bg-red-900/10');
                        }, 300);
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            // Update the ticket count
            if (ticketCountElement) {
                ticketCountElement.textContent = visibleCount;
            }

            // Show/hide no results message
            if (ticketTable && noResultsMessage) {
                if (visibleCount === 0 && ticketRows.length > 0) {
                    ticketTable.classList.add('hidden');
                    noResultsMessage.classList.remove('hidden');
                } else {
                    ticketTable.classList.remove('hidden');
                    noResultsMessage.classList.add('hidden');
                }
            }
        }
    });
</script>
@endpush