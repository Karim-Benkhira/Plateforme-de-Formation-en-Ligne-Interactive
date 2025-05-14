@extends('layouts.admin')

@section('title', 'Create New Category')

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
        background: linear-gradient(to right, #10B981, #3B82F6);
        border-radius: 3px;
        opacity: 0.7;
    }

    /* Custom radio buttons */
    .radio-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .radio-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(16, 185, 129, 0.2), rgba(59, 130, 246, 0.2));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .radio-card:hover::before {
        opacity: 1;
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
                <i class="fas fa-folder-plus mr-3 text-blue-300"></i>
                Create New Category
            </h1>
            <p class="text-blue-100 opacity-90">Add a new category to organize your courses.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.categories') }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-blue-500/20 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:translate-x-[-2px] transition-transform duration-300"></i>
                <span>Back to Categories</span>
            </a>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden max-w-4xl mx-auto">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-green-600/5 to-blue-800/5"></div>

    <div class="relative">
        <!-- Form Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="bg-green-900/70 text-green-400 rounded-lg p-2 mr-3 shadow-inner shadow-green-950/50">
                    <i class="fas fa-tag text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Category Details</h2>
            </div>
            <p class="text-gray-400 mt-2 ml-12">Fill in the details below to create a new category</p>
        </div>

        <!-- Form Content -->
        <form action="{{ route('admin.storeCategory') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Category Name -->
            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="name" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-signature text-green-400 mr-2"></i>
                    Category Name <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative input-focus-effect">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-green-500/70"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full pl-12 p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-transparent transition-all duration-300"
                        placeholder="Enter category name" />
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">Choose a clear and concise name for the category</p>
            </div>

            <!-- Category Description -->
            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="description" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-align-left text-blue-400 mr-2"></i>
                    Description
                </label>
                <div class="relative input-focus-effect">
                    <textarea name="description" id="description" rows="3"
                        class="w-full p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-300"
                        placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">Provide a brief description of what this category includes</p>
            </div>

            <!-- Category Icon -->
            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="icon" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-icons text-purple-400 mr-2"></i>
                    Category Icon
                </label>
                <div class="grid grid-cols-4 md:grid-cols-8 gap-4 p-4 bg-gray-900/70 rounded-xl border border-gray-700/50">
                    @foreach(['book', 'code', 'laptop', 'calculator', 'flask', 'language', 'music', 'palette', 'chart-pie', 'brain', 'atom', 'globe', 'camera', 'video', 'microphone', 'graduation-cap'] as $icon)
                    <div>
                        <input type="radio" name="icon" id="icon-{{ $icon }}" value="{{ $icon }}" class="hidden peer" {{ old('icon') == $icon ? 'checked' : '' }}>
                        <label for="icon-{{ $icon }}" class="radio-card flex flex-col items-center justify-center p-3 rounded-lg cursor-pointer bg-gray-800 hover:bg-gray-700 peer-checked:bg-gradient-to-br peer-checked:from-green-900/80 peer-checked:to-blue-900/80 peer-checked:text-green-300 peer-checked:border-green-500/50 peer-checked:shadow-lg transition-all duration-300 border border-gray-700 hover:border-gray-600">
                            <i class="fas fa-{{ $icon }} text-xl mb-1"></i>
                            <span class="text-xs capitalize">{{ $icon }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">Select an icon that represents this category (optional)</p>
            </div>

            <!-- Category Color -->
            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="color" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-palette text-yellow-400 mr-2"></i>
                    Category Color
                </label>
                <div class="grid grid-cols-5 md:grid-cols-10 gap-4 p-4 bg-gray-900/70 rounded-xl border border-gray-700/50">
                    @foreach(['blue', 'green', 'red', 'yellow', 'purple', 'pink', 'indigo', 'teal', 'orange', 'cyan'] as $color)
                    <div>
                        <input type="radio" name="color" id="color-{{ $color }}" value="{{ $color }}" class="hidden peer" {{ old('color') == $color ? 'checked' : '' }}>
                        <label for="color-{{ $color }}" class="block w-full h-12 rounded-lg cursor-pointer bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 peer-checked:ring-2 peer-checked:ring-{{ $color }}-400 peer-checked:shadow-lg peer-checked:shadow-{{ $color }}-500/20 hover:shadow-md transition-all duration-300"></label>
                    </div>
                    @endforeach
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">Choose a color for this category (optional)</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-900/50 border border-red-700/50 text-red-300 p-5 rounded-xl">
                    <div class="flex items-center mb-3">
                        <div class="bg-red-800/80 p-2 rounded-lg mr-3">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <span class="font-semibold text-lg">Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc pl-12 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4 border-t border-gray-700/50">
                <a href="{{ route('admin.categories') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-green-700/30">
                    <i class="fas fa-save mr-2"></i> Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection