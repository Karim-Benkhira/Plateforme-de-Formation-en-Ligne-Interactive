@extends('layouts.admin')

@section('title', 'Create New Category')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Create New Category</h1>
            <p class="text-blue-100">Add a new category to organize your courses.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.categories') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Categories
            </a>
        </div>
    </div>
</div>

<div class="data-card p-6 max-w-2xl">
    <form action="{{ route('admin.storeCategory') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-gray-300 font-medium mb-2">Category Name <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-tag text-gray-500"></i>
                </div>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Enter category name" />
            </div>
            <p class="text-sm text-gray-400 mt-1">Choose a clear and concise name for the category</p>
        </div>

        <div>
            <label for="description" class="block text-gray-300 font-medium mb-2">Description</label>
            <div class="relative">
                <textarea name="description" id="description" rows="3"
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
            </div>
            <p class="text-sm text-gray-400 mt-1">Provide a brief description of what this category includes</p>
        </div>

        <div>
            <label for="icon" class="block text-gray-300 font-medium mb-2">Category Icon</label>
            <div class="grid grid-cols-4 md:grid-cols-8 gap-3 p-3 bg-gray-800 rounded-lg">
                @foreach(['book', 'code', 'laptop', 'calculator', 'flask', 'language', 'music', 'palette'] as $icon)
                <div>
                    <input type="radio" name="icon" id="icon-{{ $icon }}" value="{{ $icon }}" class="hidden peer" {{ old('icon') == $icon ? 'checked' : '' }}>
                    <label for="icon-{{ $icon }}" class="flex flex-col items-center justify-center p-2 rounded-lg cursor-pointer bg-gray-700 peer-checked:bg-green-900 peer-checked:text-green-300 hover:bg-gray-600 transition-colors">
                        <i class="fas fa-{{ $icon }} text-xl"></i>
                        <span class="text-xs mt-1 capitalize">{{ $icon }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <p class="text-sm text-gray-400 mt-1">Select an icon that represents this category (optional)</p>
        </div>

        <div>
            <label for="color" class="block text-gray-300 font-medium mb-2">Category Color</label>
            <div class="grid grid-cols-5 md:grid-cols-10 gap-3 p-3 bg-gray-800 rounded-lg">
                @foreach(['blue', 'green', 'red', 'yellow', 'purple', 'pink', 'indigo', 'teal', 'orange', 'cyan'] as $color)
                <div>
                    <input type="radio" name="color" id="color-{{ $color }}" value="{{ $color }}" class="hidden peer" {{ old('color') == $color ? 'checked' : '' }}>
                    <label for="color-{{ $color }}" class="block w-full h-10 rounded-lg cursor-pointer bg-{{ $color }}-500 peer-checked:ring-2 peer-checked:ring-white hover:opacity-90 transition-opacity"></label>
                </div>
                @endforeach
            </div>
            <p class="text-sm text-gray-400 mt-1">Choose a color for this category (optional)</p>
        </div>

        @if($errors->any())
            <div class="bg-red-900 border border-red-800 text-red-300 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('admin.categories') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-200">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i> Create Category
            </button>
        </div>
    </form>
</div>
@endsection