@extends('layouts.admin')

@section('title', 'Edit Course')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-edit mr-3 text-blue-300"></i>
                Edit Course
            </h1>
            <p class="text-blue-100 opacity-90">Update course information and content</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.showCourse', $course->id) }}" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Course
            </a>
        </div>
    </div>
</div>

<!-- Course Edit Form -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
    <div class="relative">
        <form action="{{ route('admin.updateCourse', $course->id) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <span>Basic Information</span>
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-gray-300 font-medium mb-2">Course Title <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-graduation-cap text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                            </div>
                            <input type="text" name="title" id="title" value="{{ $course->name }}" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                        </div>
                    </div>

                    <div>
                        <label for="score" class="block text-gray-300 font-medium mb-2">Finishing Score <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-star text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="score" id="score" value="{{ $course->score }}" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-gray-300 font-medium mb-2">Course Description <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <textarea name="description" id="description" rows="4" required
                            class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ $course->description }}</textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="category" class="block text-gray-300 font-medium mb-2">Category <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-folder text-gray-500 group-hover:text-blue-400 transition-colors duration-200"></i>
                        </div>
                        <select name="category_id" id="category" required
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="level" class="block text-gray-300 font-medium mb-2">Course Level <span class="text-red-500">*</span></label>
                    <div class="bg-gray-800/50 p-3 rounded-lg border border-gray-700/50 space-y-2">
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="level" value="beginner" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700" {{ $course->level == 'beginner' ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-300">Beginner</span>
                        </label>
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="level" value="intermediate" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700" {{ $course->level == 'intermediate' ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-300">Intermediate</span>
                        </label>
                        <label class="flex items-center p-2 rounded-md hover:bg-gray-700/50 transition-colors cursor-pointer">
                            <input type="radio" name="level" value="advanced" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700" {{ $course->level == 'advanced' ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-300">Advanced</span>
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_published" id="is_published" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700 rounded" {{ $course->is_published ? 'checked' : '' }}>
                        <label for="is_published" class="ml-2 block text-gray-300 font-medium">Publish this course</label>
                    </div>
                    <p class="text-sm text-gray-400 mt-1">Published courses will be visible to all students</p>
                </div>
            </div>

            <!-- Course Content Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span>Course Content</span>
                </h2>

                <div class="mb-6">
                    <label for="content_type" class="block text-gray-300 font-medium mb-2">Content Type <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-file-alt text-gray-500 group-hover:text-purple-400 transition-colors duration-200"></i>
                        </div>
                        <select name="content_type" id="content_type" required onchange="toggleContentInputs()"
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                            <option value="">Select Content Type</option>
                            <option value="text" {{ $course->contents->first()->type === 'text' ? 'selected' : '' }}>Text Content</option>
                            <option value="pdf" {{ $course->contents->first()->type === 'pdf' ? 'selected' : '' }}>PDF Document</option>
                            <option value="youtube" {{ $course->contents->first()->type === 'youtube' ? 'selected' : '' }}>YouTube Video</option>
                        </select>
                    </div>
                </div>

                <!-- Text Content Input -->
                <div id="text_input" class="{{ $course->contents->first()->type === 'text' ? '' : 'hidden' }} mb-6">
                    <label for="content" class="block text-gray-300 font-medium mb-2">Text Content</label>
                    <div class="relative">
                        <textarea name="content" id="content" rows="8"
                            class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">{{ $course->contents->first()->type === 'text' ? $course->contents->first()->content : '' }}</textarea>
                    </div>
                </div>

                <!-- PDF Input -->
                <div id="pdf_input" class="{{ $course->contents->first()->type === 'pdf' ? '' : 'hidden' }} mb-6">
                    <label for="pdf_file" class="block text-gray-300 font-medium mb-2">Upload PDF</label>
                    <div class="relative">
                        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf"
                            class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200" />
                    </div>
                    @if($course->contents->first()->type === 'pdf')
                        <div class="mt-3 p-3 bg-gray-800/50 rounded-lg border border-gray-700/50 flex items-center">
                            <i class="fas fa-file-pdf text-red-400 mr-2"></i>
                            <span class="text-gray-300">Current PDF: </span>
                            <a href="{{ asset('storage/' . $course->contents->first()->file) }}" target="_blank" class="ml-2 text-blue-400 hover:text-blue-300 underline">
                                View PDF
                            </a>
                        </div>
                    @endif
                </div>

                <!-- YouTube Input -->
                <div id="youtube_input" class="{{ $course->contents->first()->type === 'youtube' ? '' : 'hidden' }} mb-6">
                    <label for="youtube_link" class="block text-gray-300 font-medium mb-2">YouTube Video Link</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fab fa-youtube text-gray-500 group-hover:text-red-400 transition-colors duration-200"></i>
                        </div>
                        <input type="text" name="youtube_link" id="youtube_link" value="{{ $course->contents->first()->type === 'youtube' ? $course->contents->first()->file : '' }}"
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200" placeholder="https://www.youtube.com/watch?v=..." />
                    </div>
                </div>

                <!-- Content Preview -->
                @if($course->contents->first()->type === 'pdf')
                    <div id="pdf_preview" class="mt-6 bg-gray-800/50 rounded-lg border border-gray-700/50 p-4 content-preview">
                        <h3 class="text-white font-medium mb-3 flex items-center">
                            <i class="fas fa-eye mr-2 text-purple-400"></i> Content Preview
                        </h3>
                        <iframe class="w-full h-[500px] rounded-lg border border-gray-700/50" src="{{ asset('storage/' . $course->contents->first()->file) }}" frameborder="0"></iframe>
                    </div>
                @elseif($course->contents->first()->type === 'youtube')
                    <div id="youtube_preview_container" class="mt-6 bg-gray-800/50 rounded-lg border border-gray-700/50 p-4 content-preview">
                        <h3 class="text-white font-medium mb-3 flex items-center">
                            <i class="fas fa-eye mr-2 text-purple-400"></i> Content Preview
                        </h3>
                        @php
                            // Convert YouTube URL to embed format
                            $youtubeUrl = $course->contents->first()->file;
                            $embedUrl = '';

                            // Extract video ID from various YouTube URL formats
                            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $youtubeUrl, $matches)) {
                                $videoId = $matches[1];
                                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                            } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $youtubeUrl, $matches)) {
                                $embedUrl = $youtubeUrl; // Already an embed URL
                            } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $youtubeUrl, $matches)) {
                                $videoId = $matches[1];
                                $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                            } else {
                                $embedUrl = $youtubeUrl; // Use as is if format not recognized
                            }
                        @endphp
                        <iframe id="youtube_preview_iframe" class="w-full h-[500px] rounded-lg border border-gray-700/50" src="{{ $embedUrl }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endif
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-900/40 border border-red-700/50 text-red-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-red-600/5"></div>
                    <div class="relative w-full">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mr-2 text-xl mt-0.5"></i>
                            <div>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i> Update Course
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener for YouTube link input to show preview
        const youtubeInput = document.getElementById('youtube_link');
        if (youtubeInput) {
            youtubeInput.addEventListener('change', function() {
                updateYouTubePreview(this.value);
            });
        }
    });

    function toggleContentInputs() {
        const contentType = document.getElementById('content_type').value;
        const textInput = document.getElementById('text_input');
        const pdfInput = document.getElementById('pdf_input');
        const youtubeInput = document.getElementById('youtube_input');

        // Hide all content previews first
        const contentPreviews = document.querySelectorAll('.content-preview');
        contentPreviews.forEach(preview => {
            preview.classList.add('hidden');
        });

        if (contentType === 'text') {
            textInput.classList.remove('hidden');
            pdfInput.classList.add('hidden');
            youtubeInput.classList.add('hidden');
        } else if (contentType === 'pdf') {
            textInput.classList.add('hidden');
            pdfInput.classList.remove('hidden');
            youtubeInput.classList.add('hidden');

            // Show PDF preview if it exists
            const pdfPreview = document.getElementById('pdf_preview');
            if (pdfPreview) {
                pdfPreview.classList.remove('hidden');
            }
        } else if (contentType === 'youtube') {
            textInput.classList.add('hidden');
            pdfInput.classList.add('hidden');
            youtubeInput.classList.remove('hidden');

            // Create YouTube preview if it doesn't exist
            const youtubePreviewContainer = document.getElementById('youtube_preview_container');
            if (youtubePreviewContainer) {
                youtubePreviewContainer.classList.remove('hidden');

                // Update preview with current value
                const youtubeLink = document.getElementById('youtube_link').value;
                if (youtubeLink) {
                    updateYouTubePreview(youtubeLink);
                }
            }
        } else {
            textInput.classList.add('hidden');
            pdfInput.classList.add('hidden');
            youtubeInput.classList.add('hidden');
        }
    }

    function updateYouTubePreview(url) {
        // Create preview container if it doesn't exist
        let previewContainer = document.getElementById('youtube_preview_container');
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.id = 'youtube_preview_container';
            previewContainer.className = 'mt-6 bg-gray-800/50 rounded-lg border border-gray-700/50 p-4 content-preview';

            const heading = document.createElement('h3');
            heading.className = 'text-white font-medium mb-3 flex items-center';
            heading.innerHTML = '<i class="fas fa-eye mr-2 text-purple-400"></i> Content Preview';

            const iframe = document.createElement('iframe');
            iframe.id = 'youtube_preview_iframe';
            iframe.className = 'w-full h-[500px] rounded-lg border border-gray-700/50';
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allowfullscreen', '');

            previewContainer.appendChild(heading);
            previewContainer.appendChild(iframe);

            // Add after YouTube input
            const youtubeInput = document.getElementById('youtube_input');
            youtubeInput.parentNode.insertBefore(previewContainer, youtubeInput.nextSibling);
        }

        // Extract video ID and update iframe src
        const iframe = document.getElementById('youtube_preview_iframe');
        let embedUrl = '';

        // Extract video ID from various YouTube URL formats
        if (url.match(/youtube\.com\/watch\?v=([^\&\?\/]+)/)) {
            const videoId = url.match(/youtube\.com\/watch\?v=([^\&\?\/]+)/)[1];
            embedUrl = `https://www.youtube.com/embed/${videoId}`;
        } else if (url.match(/youtube\.com\/embed\/([^\&\?\/]+)/)) {
            embedUrl = url; // Already an embed URL
        } else if (url.match(/youtu\.be\/([^\&\?\/]+)/)) {
            const videoId = url.match(/youtu\.be\/([^\&\?\/]+)/)[1];
            embedUrl = `https://www.youtube.com/embed/${videoId}`;
        } else {
            embedUrl = url; // Use as is if format not recognized
        }

        iframe.src = embedUrl;
    }
</script>
@endsection
