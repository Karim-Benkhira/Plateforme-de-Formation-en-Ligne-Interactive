@extends('layouts.admin')

@section('title', 'Manage Categories')

@push('styles')
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
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-layer-group mr-3 text-yellow-300"></i>
                Category Management
            </h1>
            <p class="text-yellow-100 opacity-90">Create and manage categories to organize your courses.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.createCategory') }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Add New Category</span>
            </a>
        </div>
    </div>
</div>

<!-- Categories Table Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                    <i class="fas fa-tags"></i>
                </div>
                <span>All Categories</span>
                <span class="ml-3 bg-yellow-900/30 text-yellow-400 text-sm py-1 px-3 rounded-full border border-yellow-700/30">
                    {{ count($categories) }} categories
                </span>
            </h2>

            <div class="relative group w-full md:w-auto">
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-pink-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative bg-gray-900 border border-gray-700 rounded-lg flex items-center overflow-hidden">
                    <div class="px-3 text-yellow-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="category-search" placeholder="Search categories..."
                        class="bg-transparent border-0 px-2 py-2.5 focus:outline-none text-gray-200 w-full placeholder-gray-500">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-700/50 shadow-inner bg-gray-900/50">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Category Name</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Courses</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Created</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="category-row border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200">
                        <td class="px-4 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-500 to-pink-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <span class="relative">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-medium text-white group-hover:text-yellow-400 transition-colors">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center bg-pink-900/20 text-pink-400 px-3 py-1 rounded-lg border border-pink-700/30 w-fit">
                                <i class="fas fa-book mr-2"></i>
                                <span>{{ $category->courses->count() }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center text-gray-400">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ $category->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.editCategory', $category->id) }}"
                                   class="group bg-yellow-900/40 hover:bg-yellow-800/60 text-yellow-300 border border-yellow-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-edit mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Edit</span>
                                    <span class="tooltip-text">Edit Category</span>
                                </a>
                                <form action="{{ route('admin.deleteCategory', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="group bg-red-900/40 hover:bg-red-800/60 text-red-300 border border-red-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger"
                                            onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone and may affect courses assigned to this category.')">
                                        <i class="fas fa-trash-alt mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                        <span>Delete</span>
                                        <span class="tooltip-text">Delete Category</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(count($categories) == 0)
        <div class="text-center py-16 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-800/80 text-gray-400 mb-6">
                <i class="fas fa-tags text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">No categories found</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">Get started by creating your first category to organize your courses.</p>
            <a href="{{ route('admin.createCategory') }}" class="group bg-gradient-to-r from-yellow-600/80 to-pink-600/80 hover:from-yellow-500/80 hover:to-pink-500/80 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/20 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Create Your First Category</span>
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced search functionality
        const searchInput = document.getElementById('category-search');
        const categoryRows = document.querySelectorAll('.category-row');
        const categoryTable = document.querySelector('table');
        const noCategoriesMessage = document.querySelector('.text-center.py-16');

        // Add focus effect to search input
        searchInput.addEventListener('focus', function() {
            this.parentElement.parentElement.classList.add('ring-2', 'ring-yellow-500/50');
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.parentElement.classList.remove('ring-2', 'ring-yellow-500/50');
        });

        // Enhanced search with highlighting
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            categoryRows.forEach(row => {
                const categoryName = row.querySelector('.font-medium').textContent.toLowerCase();

                if (categoryName.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;

                    // Add a subtle highlight effect for matching search terms
                    if (searchTerm !== '') {
                        // Reset any previous highlights
                        row.classList.add('bg-yellow-900/10');
                        setTimeout(() => {
                            row.classList.remove('bg-yellow-900/10');
                        }, 300);
                    }
                } else {
                    row.style.display = 'none';
                }
            });

            // Update the category count badge
            const categoryBadge = document.querySelector('.bg-yellow-900\\/30.text-yellow-400.text-sm');
            if (categoryBadge) {
                categoryBadge.textContent = `${visibleCount} categories`;
            }

            // Show/hide empty state message
            if (categoryTable && noCategoriesMessage) {
                if (visibleCount === 0 && categoryRows.length > 0) {
                    categoryTable.style.display = 'none';

                    // Check if we already have a "no results" message
                    let noResultsMsg = document.querySelector('.no-results-message');
                    if (!noResultsMsg) {
                        // Create a "no results" message
                        noResultsMsg = document.createElement('div');
                        noResultsMsg.className = 'no-results-message text-center py-8 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4';
                        noResultsMsg.innerHTML = `
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800/80 text-gray-400 mb-4">
                                <i class="fas fa-search text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">No matching categories</h3>
                            <p class="text-gray-400">Try adjusting your search term</p>
                        `;
                        categoryTable.parentNode.appendChild(noResultsMsg);
                    } else {
                        noResultsMsg.style.display = 'block';
                    }
                } else {
                    categoryTable.style.display = '';
                    const noResultsMsg = document.querySelector('.no-results-message');
                    if (noResultsMsg) {
                        noResultsMsg.style.display = 'none';
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection