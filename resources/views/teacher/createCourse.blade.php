@extends('layouts.app')

@section('title', 'Create New Course')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.courses') }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Create New Course</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="creator_id" value="{{ Auth::id() }}">
            <input type="hidden" name="score" value="0">

            <!-- Course Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>Basic Information
                </h2>

                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Title</label>
                    <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required></textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Difficulty Level</label>
                        <select name="level" id="level" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                        @error('level')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Image</label>
                    <div class="flex items-center">
                        <div class="flex-1">
                            <input type="file" name="image" id="image" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="ml-4 w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <img id="image-preview" src="#" alt="Preview" class="max-w-full max-h-full rounded-lg hidden">
                            <div id="image-placeholder" class="text-gray-400 dark:text-gray-500">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended size: 1280x720 pixels (16:9 ratio)</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Course Content -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-book-open mr-2 text-blue-500"></i>Course Content
                </h2>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content Type</label>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_text" value="text" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                            <label for="content_type_text" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Text</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_pdf" value="pdf" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="content_type_pdf" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">PDF Document</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_video" value="video" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="content_type_video" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Video File</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_youtube" value="youtube" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <label for="content_type_youtube" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">YouTube Link</label>
                        </div>
                    </div>
                </div>

                <!-- Text Content -->
                <div id="text_content_section" class="content-section mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Text Content</label>
                    <textarea name="content" id="content" rows="10" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can use Markdown formatting</p>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PDF Upload -->
                <div id="pdf_content_section" class="content-section mb-6 hidden">
                    <label for="pdf_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PDF Document</label>
                    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maximum file size: 10MB</p>
                    @error('pdf_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Upload -->
                <div id="video_content_section" class="content-section mb-6 hidden">
                    <label for="video_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Video File</label>
                    <input type="file" name="video_file" id="video_file" accept="video/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Supported formats: MP4, WebM, Ogg (max 100MB)</p>
                    @error('video_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- YouTube Link -->
                <div id="youtube_content_section" class="content-section mb-6 hidden">
                    <label for="youtube_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">YouTube Video URL</label>
                    <input type="url" name="youtube_link" id="youtube_link" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enter the full YouTube video URL</p>
                    @error('youtube_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Publishing Options -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-cog mr-2 text-blue-500"></i>Publishing Options
                </h2>

                <div class="flex items-center mb-6">
                    <input type="checkbox" name="is_published" id="is_published" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Publish course immediately</label>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('teacher.courses') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition duration-300">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-6 rounded-lg transition duration-300 shadow-md">
                    <i class="fas fa-save mr-2"></i>Create Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    imagePlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Content type switching
        const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
        const contentSections = document.querySelectorAll('.content-section');

        function showSelectedContentSection() {
            const selectedValue = document.querySelector('input[name="content_type"]:checked').value;

            contentSections.forEach(section => {
                section.classList.add('hidden');
            });

            document.getElementById(`${selectedValue}_content_section`).classList.remove('hidden');
        }

        contentTypeRadios.forEach(radio => {
            radio.addEventListener('change', showSelectedContentSection);
        });

        // Initialize with the default selected content type
        showSelectedContentSection();
    });
</script>
@endpush
