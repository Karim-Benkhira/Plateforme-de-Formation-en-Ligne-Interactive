@extends('layouts.admin')

@section('title', 'Create New Course')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Create New Course</h1>
            <p class="text-blue-100">Add a new course to your learning platform.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.courses') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Courses
            </a>
        </div>
    </div>
</div>

<div class="data-card p-6">
    <form method="POST" action="{{ route('admin.storeCourse') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-gray-300 font-medium mb-2">Course Title <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-book text-gray-500"></i>
                    </div>
                    <input type="text" name="title" id="title" required
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter course title" />
                </div>
            </div>

            <div>
                <label for="category" class="block text-gray-300 font-medium mb-2">Category <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-500"></i>
                    </div>
                    <select name="category" id="category" required
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label for="description" class="block text-gray-300 font-medium mb-2">Course Description <span class="text-red-500">*</span></label>
            <div class="relative">
                <textarea name="description" id="description" rows="4" required
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter detailed course description"></textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="score" class="block text-gray-300 font-medium mb-2">Passing Score <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-star text-gray-500"></i>
                    </div>
                    <input type="number" name="score" id="score" required min="0" max="100"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter passing score (0-100)" />
                </div>
                <p class="text-sm text-gray-400 mt-1">Minimum score required to pass this course</p>
            </div>

            <div>
                <label for="level" class="block text-gray-300 font-medium mb-2">Difficulty Level</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-signal text-gray-500"></i>
                    </div>
                    <select name="level" id="level"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label for="image" class="block text-gray-300 font-medium mb-2">Course Image</label>
            <div class="relative">
                <div class="flex items-center justify-center w-full">
                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-700 border-gray-600 hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                            <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-400">PNG, JPG or JPEG (MAX. 2MB)</p>
                        </div>
                        <input id="image" name="image" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" />
                    </label>
                </div>
                <div id="image-preview" class="hidden mt-3">
                    <div class="flex items-center">
                        <img id="preview-image" src="#" alt="Preview" class="h-16 w-16 object-cover rounded-lg mr-3">
                        <button type="button" id="remove-image" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-6">
            <h3 class="text-xl font-semibold text-white mb-4">Course Content</h3>

            <div>
                <label for="content_type" class="block text-gray-300 font-medium mb-2">Content Type</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-file-alt text-gray-500"></i>
                    </div>
                    <select name="content_type" id="content_type" onchange="toggleContentInputs()"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                        <option value="">Select Content Type</option>
                        <option value="pdf">PDF Document</option>
                        <option value="youtube">YouTube Video</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                </div>
            </div>

            <div id="pdf_input" class="hidden mt-4">
                <label for="pdf_file" class="block text-gray-300 font-medium mb-2">Upload PDF Document</label>
                <div class="relative">
                    <div class="flex items-center justify-center w-full">
                        <label for="pdf_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-700 border-gray-600 hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-file-pdf text-gray-400 text-2xl mb-2"></i>
                                <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-400">PDF files only (MAX. 10MB)</p>
                            </div>
                            <input id="pdf_file" name="pdf_file" type="file" class="hidden" accept="application/pdf" />
                        </label>
                    </div>
                    <div id="pdf-preview" class="hidden mt-3">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf text-red-400 text-2xl mr-3"></i>
                            <span id="pdf-name" class="text-gray-300"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="youtube_input" class="hidden mt-4">
                <label for="youtube_link" class="block text-gray-300 font-medium mb-2">YouTube Video Link</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fab fa-youtube text-gray-500"></i>
                    </div>
                    <input type="text" name="youtube_link" id="youtube_link"
                        class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter YouTube video URL (e.g., https://www.youtube.com/watch?v=...)" />
                </div>
                <p class="text-sm text-gray-400 mt-1">Paste the full YouTube video URL</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-900 border border-red-800 text-red-300 p-4 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('admin.courses') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-200">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i> Create Course
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleContentInputs() {
        const contentType = document.getElementById('content_type').value;
        const pdfInput = document.getElementById('pdf_input');
        const youtubeInput = document.getElementById('youtube_input');

        pdfInput.classList.add('hidden');
        youtubeInput.classList.add('hidden');

        if (contentType === 'pdf') {
            pdfInput.classList.remove('hidden');
        } else if (contentType === 'youtube') {
            youtubeInput.classList.remove('hidden');
        }
    }

    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-image');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeButton.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
        });

        // PDF file name display
        const pdfInput = document.getElementById('pdf_file');
        const pdfPreview = document.getElementById('pdf-preview');
        const pdfName = document.getElementById('pdf-name');

        pdfInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                pdfName.textContent = file.name;
                pdfPreview.classList.remove('hidden');
            } else {
                pdfPreview.classList.add('hidden');
            }
        });
    });
</script>
@endpush
@endsection
