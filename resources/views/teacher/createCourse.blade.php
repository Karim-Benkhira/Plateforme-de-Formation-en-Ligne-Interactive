@extends('layouts.teacher')

@section('title', 'Create New Course')

@section('content')
<!-- Page Header -->
<div class="welcome-banner">
    <div class="flex items-center">
        <a href="{{ route('teacher.courses') }}" class="mr-4 text-white hover:text-blue-100 transition-colors">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-white">Create New Course</h1>
            <p class="text-blue-100">Add a new course to your teaching portfolio</p>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto">
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-edit mr-2"></i> Course Details
        </div>
        <div class="section-content bg-gray-900">
            <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data" id="course-form">
            @csrf
            <input type="hidden" name="creator_id" value="{{ Auth::id() }}">
            <input type="hidden" name="score" value="100">

            @if ($errors->any())
            <div class="bg-red-900/50 border border-red-700 text-red-300 p-4 rounded-lg mb-6">
                <div class="flex items-start mb-2">
                    <i class="fas fa-exclamation-triangle text-red-400 mt-1 mr-3"></i>
                    <h4 class="font-semibold">Please fix the following errors:</h4>
                </div>
                <ul class="list-disc pl-10 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Course Basic Information -->
            <div class="mb-8">
                <div class="form-section-title mb-6">
                    <i class="fas fa-info-circle mr-2 text-blue-400"></i>Basic Information
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <div class="mb-6">
                            <label for="title" class="block text-white text-lg font-medium mb-2">Course Title</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400">
                                    <i class="fas fa-heading"></i>
                                </span>
                                <input type="text" name="title" id="title"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                    placeholder="Enter a descriptive title for your course" required>
                            </div>
                            @error('title')
                                <p class="form-error mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="mb-6">
                            <label for="description" class="block text-white text-lg font-medium mb-2">Description</label>
                            <div class="relative">
                                <span class="absolute top-3 left-3 text-blue-400">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                    placeholder="Provide a detailed description of what students will learn" required></textarea>
                            </div>
                            @error('description')
                                <p class="form-error mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <div class="mb-6">
                            <label for="category_id" class="block text-white text-lg font-medium mb-2">Category</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400">
                                    <i class="fas fa-folder"></i>
                                </span>
                                <select name="category_id" id="category_id"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 appearance-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            @error('category_id')
                                <p class="form-error mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <div class="mb-6">
                            <label for="level" class="block text-white text-lg font-medium mb-2">Difficulty</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-400">
                                    <i class="fas fa-signal"></i>
                                </span>
                                <select name="level" id="level"
                                    class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 appearance-none focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors">
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            @error('level')
                                <p class="form-error mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-span-12 mt-6">
                    <div class="form-section-title mb-4">
                        <i class="fas fa-image mr-2 text-blue-400"></i>Course Image
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700">
                        <div class="flex flex-col md:flex-row items-start md:items-center">
                            <div class="w-full md:w-1/2 mb-6 md:mb-0">
                                <div class="relative">
                                    <input type="file" name="image" id="image" class="hidden" accept="image/*" aria-label="Course image" aria-describedby="image-requirements">
                                    <label for="image" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg cursor-pointer hover:from-blue-700 hover:to-blue-600 transition-all shadow-lg hover:shadow-blue-500/20" role="button" tabindex="0">
                                        <i class="fas fa-cloud-upload-alt text-xl mr-2" aria-hidden="true"></i>
                                        <span class="font-medium">Choose File</span>
                                    </label>
                                    <div id="file-name" class="mt-3 text-gray-300 flex items-center">
                                        <i class="fas fa-file-image text-blue-400 mr-2"></i>
                                        <span>No file chosen</span>
                                    </div>
                                </div>
                                <div id="image-requirements" class="mt-4 bg-gray-900/50 p-3 rounded-lg border border-gray-700">
                                    <p class="text-sm text-gray-300 flex items-start">
                                        <i class="fas fa-info-circle text-blue-400 mr-2 mt-1" aria-hidden="true"></i>
                                        <span>
                                            <strong class="block text-white mb-1">Image Requirements:</strong>
                                            Recommended size: 1280x720 pixels (16:9 ratio). Maximum file size: 2MB.
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 md:pl-6">
                                <div class="w-full h-48 bg-gray-900 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-700 hover:border-blue-500 transition-colors overflow-hidden">
                                    <img id="image-preview" src="#" alt="Preview" class="max-w-full max-h-full rounded-lg hidden object-cover">
                                    <div id="image-placeholder" class="text-gray-500 flex flex-col items-center p-4">
                                        <i class="fas fa-image text-5xl mb-3 text-gray-600"></i>
                                        <p class="text-sm text-center text-gray-400">Image Preview</p>
                                        <p class="text-xs text-center text-gray-500 mt-2">Your course thumbnail will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="form-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Course Content -->
            <div class="mb-8">
                <div class="form-section-title mb-6">
                    <i class="fas fa-book-open mr-2 text-blue-400"></i>Course Content
                </div>

                <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700 mb-6">
                    <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                        <i class="fas fa-layer-group text-blue-400 mr-3"></i>
                        <span>Select Content Type</span>
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="content-type-option">
                            <input type="radio" name="content_type" id="content_type_text" value="text" class="hidden" checked>
                            <label for="content_type_text" class="content-type-label group">
                                <div class="w-16 h-16 rounded-full bg-blue-900/30 flex items-center justify-center mb-4 group-hover:bg-blue-800/50 transition-all transform group-hover:scale-110 mx-auto">
                                    <i class="fas fa-file-alt text-2xl text-blue-400"></i>
                                </div>
                                <span class="block text-center text-lg font-medium text-gray-300 group-hover:text-white transition-colors">Text</span>
                                <span class="block text-center text-xs text-gray-500 mt-1">Rich text content</span>
                            </label>
                        </div>
                        <div class="content-type-option">
                            <input type="radio" name="content_type" id="content_type_pdf" value="pdf" class="hidden">
                            <label for="content_type_pdf" class="content-type-label group">
                                <div class="w-16 h-16 rounded-full bg-red-900/30 flex items-center justify-center mb-4 group-hover:bg-red-800/50 transition-all transform group-hover:scale-110 mx-auto">
                                    <i class="fas fa-file-pdf text-2xl text-red-400"></i>
                                </div>
                                <span class="block text-center text-lg font-medium text-gray-300 group-hover:text-white transition-colors">PDF</span>
                                <span class="block text-center text-xs text-gray-500 mt-1">Upload document</span>
                            </label>
                        </div>
                        <div class="content-type-option">
                            <input type="radio" name="content_type" id="content_type_video" value="video" class="hidden">
                            <label for="content_type_video" class="content-type-label group">
                                <div class="w-16 h-16 rounded-full bg-green-900/30 flex items-center justify-center mb-4 group-hover:bg-green-800/50 transition-all transform group-hover:scale-110 mx-auto">
                                    <i class="fas fa-file-video text-2xl text-green-400"></i>
                                </div>
                                <span class="block text-center text-lg font-medium text-gray-300 group-hover:text-white transition-colors">Video</span>
                                <span class="block text-center text-xs text-gray-500 mt-1">Upload video file</span>
                            </label>
                        </div>
                        <div class="content-type-option">
                            <input type="radio" name="content_type" id="content_type_youtube" value="youtube" class="hidden">
                            <label for="content_type_youtube" class="content-type-label group">
                                <div class="w-16 h-16 rounded-full bg-red-900/30 flex items-center justify-center mb-4 group-hover:bg-red-800/50 transition-all transform group-hover:scale-110 mx-auto">
                                    <i class="fab fa-youtube text-2xl text-red-500"></i>
                                </div>
                                <span class="block text-center text-lg font-medium text-gray-300 group-hover:text-white transition-colors">YouTube</span>
                                <span class="block text-center text-xs text-gray-500 mt-1">Embed video link</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Text Content -->
                <div id="text_content_section" class="content-section mb-6">
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700 shadow-lg">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-900/30 flex items-center justify-center mr-3">
                                <i class="fas fa-file-alt text-blue-400"></i>
                            </div>
                            <span>Text Content</span>
                        </h3>
                        <div class="mb-6">
                            <textarea name="content" id="content" rows="12"
                                class="w-full bg-gray-900 text-white border-2 border-gray-700 rounded-lg p-4 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors"
                                placeholder="Enter your course content here. You can use Markdown formatting."></textarea>
                        </div>
                        <div class="bg-gray-900/50 p-4 rounded-lg border border-gray-700">
                            <p class="text-sm text-gray-300 flex items-start">
                                <i class="fas fa-lightbulb text-yellow-400 mr-3 text-xl mt-1"></i>
                                <span>
                                    <strong class="block text-white text-base mb-2">Markdown Formatting Tips:</strong>
                                    <span class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-300">
                                        <code class="bg-gray-800 px-2 py-1 rounded text-xs inline-block">## Heading</code>
                                        <code class="bg-gray-800 px-2 py-1 rounded text-xs inline-block">* Bullet point</code>
                                        <code class="bg-gray-800 px-2 py-1 rounded text-xs inline-block">**bold text**</code>
                                        <code class="bg-gray-800 px-2 py-1 rounded text-xs inline-block">*italic text*</code>
                                        <code class="bg-gray-800 px-2 py-1 rounded text-xs inline-block">[link text](url)</code>
                                        <code class="bg-gray-800 px-2 py-1 rounded text-xs inline-block">![image alt](image url)</code>
                                    </span>
                                </span>
                            </p>
                        </div>
                        @error('content')
                            <p class="form-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- PDF Upload -->
                <div id="pdf_content_section" class="content-section mb-6 hidden">
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700 shadow-lg">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <div class="w-10 h-10 rounded-full bg-red-900/30 flex items-center justify-center mr-3">
                                <i class="fas fa-file-pdf text-red-400"></i>
                            </div>
                            <span>PDF Document</span>
                        </h3>
                        <div class="file-upload-area bg-gray-900 p-8 flex flex-col items-center justify-center border-2 border-dashed border-gray-700 rounded-lg hover:border-red-500 transition-colors">
                            <i class="fas fa-file-pdf text-5xl text-red-400 mb-6"></i>
                            <p class="text-gray-400 mb-6 text-center">Upload your PDF document to share with students</p>
                            <div class="relative mb-4">
                                <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="hidden" aria-label="PDF document" aria-describedby="pdf-requirements">
                                <label for="pdf_file" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 text-white rounded-lg cursor-pointer hover:from-red-700 hover:to-red-600 transition-all shadow-lg hover:shadow-red-500/20" role="button" tabindex="0">
                                    <i class="fas fa-cloud-upload-alt text-xl mr-2" aria-hidden="true"></i>
                                    <span class="font-medium">Choose PDF File</span>
                                </label>
                            </div>
                            <div id="pdf-file-name" class="mt-3 text-gray-300 flex items-center">
                                <i class="fas fa-file-pdf text-red-400 mr-2"></i>
                                <span>No file chosen</span>
                            </div>
                        </div>
                        <div id="pdf-requirements" class="bg-gray-900/50 p-4 rounded-lg border border-gray-700 mt-6">
                            <p class="text-sm text-gray-300 flex items-start">
                                <i class="fas fa-info-circle text-red-400 mr-3 text-xl mt-1" aria-hidden="true"></i>
                                <span>
                                    <strong class="block text-white text-base mb-2">PDF Requirements:</strong>
                                    <ul class="list-disc pl-5 space-y-1 text-gray-300">
                                        <li>Maximum file size: 10MB</li>
                                        <li>Ensure your PDF is properly formatted for online viewing</li>
                                        <li>Text in the PDF should be selectable for better accessibility</li>
                                    </ul>
                                </span>
                            </p>
                        </div>
                        @error('pdf_file')
                            <p class="form-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Video Upload -->
                <div id="video_content_section" class="content-section mb-6 hidden">
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700 shadow-lg">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <div class="w-10 h-10 rounded-full bg-green-900/30 flex items-center justify-center mr-3">
                                <i class="fas fa-file-video text-green-400"></i>
                            </div>
                            <span>Video File</span>
                        </h3>
                        <div class="file-upload-area bg-gray-900 p-8 flex flex-col items-center justify-center border-2 border-dashed border-gray-700 rounded-lg hover:border-green-500 transition-colors">
                            <i class="fas fa-film text-5xl text-green-400 mb-6"></i>
                            <p class="text-gray-400 mb-6 text-center">Upload your video file to share with students</p>
                            <div class="relative mb-4">
                                <input type="file" name="video_file" id="video_file" accept="video/*" class="hidden" aria-label="Video file" aria-describedby="video-requirements">
                                <label for="video_file" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 text-white rounded-lg cursor-pointer hover:from-green-700 hover:to-green-600 transition-all shadow-lg hover:shadow-green-500/20" role="button" tabindex="0">
                                    <i class="fas fa-cloud-upload-alt text-xl mr-2" aria-hidden="true"></i>
                                    <span class="font-medium">Choose Video File</span>
                                </label>
                            </div>
                            <div id="video-file-name" class="mt-3 text-gray-300 flex items-center">
                                <i class="fas fa-file-video text-green-400 mr-2"></i>
                                <span>No file chosen</span>
                            </div>
                        </div>
                        <div id="video-requirements" class="bg-gray-900/50 p-4 rounded-lg border border-gray-700 mt-6">
                            <p class="text-sm text-gray-300 flex items-start">
                                <i class="fas fa-info-circle text-green-400 mr-3 text-xl mt-1" aria-hidden="true"></i>
                                <span>
                                    <strong class="block text-white text-base mb-2">Video Requirements:</strong>
                                    <ul class="list-disc pl-5 space-y-1 text-gray-300">
                                        <li>Supported formats: MP4, WebM, Ogg</li>
                                        <li>Maximum file size: 100MB</li>
                                        <li>Recommended resolution: 720p or 1080p</li>
                                        <li>Keep videos concise and focused on the topic</li>
                                    </ul>
                                </span>
                            </p>
                        </div>
                        @error('video_file')
                            <p class="form-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- YouTube Link -->
                <div id="youtube_content_section" class="content-section mb-6 hidden">
                    <div class="bg-gray-800 p-6 rounded-lg border-2 border-gray-700 shadow-lg">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <div class="w-10 h-10 rounded-full bg-red-900/30 flex items-center justify-center mr-3">
                                <i class="fab fa-youtube text-red-500"></i>
                            </div>
                            <span>YouTube Video</span>
                        </h3>
                        <div class="bg-gray-900/50 p-6 rounded-lg border-2 border-gray-700">
                            <div class="flex items-center justify-center mb-6">
                                <div class="w-16 h-16 rounded-full bg-red-900/20 flex items-center justify-center">
                                    <i class="fab fa-youtube text-5xl text-red-500"></i>
                                </div>
                            </div>
                            <div class="relative mb-6">
                                <label for="youtube_link" class="block text-white text-lg font-medium mb-2">YouTube Video URL</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-red-500">
                                        <i class="fab fa-youtube"></i>
                                    </span>
                                    <input type="url" name="youtube_link" id="youtube_link"
                                        class="w-full bg-gray-800 text-white border-2 border-gray-700 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition-colors"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        aria-label="YouTube video URL"
                                        aria-describedby="youtube-tips">
                                </div>
                            </div>
                            <div id="youtube-tips" class="bg-gray-900/80 p-4 rounded-lg border border-gray-700 mt-4">
                                <p class="text-sm text-gray-300 flex items-start">
                                    <i class="fas fa-info-circle text-red-400 mr-3 text-xl mt-1" aria-hidden="true"></i>
                                    <span>
                                        <strong class="block text-white text-base mb-2">YouTube Tips:</strong>
                                        <ul class="list-disc pl-5 space-y-1 text-gray-300">
                                            <li>Paste the full YouTube URL (e.g., https://www.youtube.com/watch?v=XXXXXXXXXXX)</li>
                                            <li>Make sure the video is publicly accessible or unlisted</li>
                                            <li>You can also use YouTube Shorts or specific timestamps</li>
                                            <li>Verify that the content doesn't violate copyright restrictions</li>
                                        </ul>
                                    </span>
                                </p>
                            </div>
                            <div class="mt-6 bg-black/50 p-4 rounded-lg border border-gray-700">
                                <div id="youtube-preview-container">
                                    <h4 class="text-white font-medium mb-3 flex items-center">
                                        <i class="fas fa-play-circle text-red-500 mr-2"></i>
                                        Video Preview
                                    </h4>
                                    <div id="youtube-preview" class="aspect-video bg-black rounded-lg flex items-center justify-center">
                                        <p class="text-gray-500">Enter a valid YouTube URL to see preview</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('youtube_link')
                            <p class="form-error mt-3">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Publishing Options -->
            <div class="mb-8">
                <div class="form-section-title mb-6">
                    <i class="fas fa-cog mr-2 text-blue-400"></i>Publishing Options
                </div>

                <div class="bg-gray-800 rounded-lg p-6 border-2 border-gray-700 shadow-lg">
                    <div class="flex flex-col md:flex-row items-start">
                        <div class="mr-6 mb-4 md:mb-0">
                            <div class="w-16 h-16 rounded-full bg-blue-900/30 flex items-center justify-center">
                                <i class="fas fa-globe text-2xl text-blue-400"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-white mb-3">Course Visibility</h3>
                            <p class="text-gray-300 mb-6 leading-relaxed">
                                Choose whether to publish your course immediately or save it as a draft for later publication.
                            </p>
                            <div class="flex items-center p-5 bg-gray-900/70 rounded-lg border-2 border-gray-700 hover:border-blue-600 transition-colors">
                                <div class="toggle-switch">
                                    <input type="checkbox" id="is_published_toggle" class="toggle-input" onchange="updatePublishValue(this)">
                                    <input type="hidden" name="is_published" id="is_published" value="0">
                                    <label for="is_published_toggle" class="toggle-label"></label>
                                </div>
                                <label for="is_published_toggle" class="ml-3 block text-white font-medium text-lg cursor-pointer">Publish course immediately</label>
                            </div>
                            <div class="mt-4 bg-gray-900/50 p-4 rounded-lg border border-gray-700">
                                <p class="text-sm text-gray-300 flex items-start">
                                    <i class="fas fa-info-circle text-blue-400 mr-3 text-xl mt-1"></i>
                                    <span>
                                        <strong class="block text-white text-base mb-2">Publishing Information:</strong>
                                        <ul class="list-disc pl-5 space-y-1 text-gray-300">
                                            <li>If enabled, the course will be visible to students immediately after creation</li>
                                            <li>Draft courses can be published later from your course management dashboard</li>
                                            <li>You can always unpublish a course if you need to make significant changes</li>
                                        </ul>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg p-8 border-2 border-gray-700 mb-6 shadow-lg">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <h3 class="text-2xl font-semibold text-white mb-2">Ready to create your course?</h3>
                        <p class="text-gray-300 leading-relaxed">
                            You can edit all information after creating the course. Your students will appreciate your effort!
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('teacher.courses') }}"
                            class="px-8 py-4 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-all flex items-center justify-center shadow-lg hover:shadow-gray-700/30 transform hover:-translate-y-1">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span class="font-medium">Cancel</span>
                        </a>
                        <button type="submit" id="submit-button"
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition-all flex items-center justify-center font-medium shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1">
                            <i class="fas fa-save mr-2"></i>
                            <span>Create Course</span>
                            <span class="loading-spinner ml-2 hidden">
                                <i class="fas fa-circle-notch fa-spin"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #111827;
    }

    /* Form Styles */
    .form-label {
        @apply block text-sm font-medium text-gray-300 mb-2;
    }

    .form-input {
        @apply w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-white transition-colors;
    }

    .form-input:hover {
        @apply border-gray-600;
    }

    .form-input:focus {
        @apply border-primary-500 bg-gray-900;
    }

    .form-select {
        @apply w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-white appearance-none transition-colors;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    .form-select:hover {
        @apply border-gray-600;
    }

    .form-select:focus {
        @apply border-primary-500 bg-gray-900;
    }

    .form-error {
        @apply text-red-400 text-xs mt-1 flex items-center;
    }

    .form-error:before {
        content: "⚠️";
        @apply mr-1;
    }

    .form-section-title {
        @apply text-xl font-semibold text-white mb-4 pb-2 border-b border-gray-700 flex items-center;
    }

    /* File Input Styling */
    .file-input {
        @apply absolute inset-0 w-full h-full opacity-0 cursor-pointer;
    }

    .file-label {
        @apply flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-md cursor-pointer hover:bg-primary-700 transition-colors shadow-md;
    }

    .file-name {
        @apply text-gray-400 transition-colors;
    }

    /* Content Type Options */
    .content-type-option {
        @apply relative;
    }

    .content-type-label {
        @apply flex flex-col items-center justify-center p-4 bg-gray-800 border border-gray-700 rounded-lg cursor-pointer transition-all text-gray-300 hover:bg-gray-700 shadow-md hover:shadow-lg;
    }

    input[name="content_type"]:checked + .content-type-label {
        @apply bg-primary-900/50 border-primary-500 text-primary-300 shadow-lg;
    }

    /* Toggle Switch */
    .toggle-switch {
        @apply relative inline-block w-14 h-7;
    }

    .toggle-input {
        @apply opacity-0 w-0 h-0;
    }

    .toggle-label {
        @apply absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-700 rounded-full transition-all duration-300 ease-in-out;
    }

    .toggle-label:before {
        @apply absolute content-[''] h-5 w-5 left-1 bottom-1 bg-white rounded-full transition-all duration-300 ease-in-out shadow-md;
    }

    .toggle-input:checked + .toggle-label {
        @apply bg-blue-600;
    }

    .toggle-input:checked + .toggle-label:before {
        @apply transform translate-x-7 bg-white scale-110;
    }

    .toggle-input:focus + .toggle-label {
        @apply ring-2 ring-blue-400;
    }

    .toggle-label:hover:before {
        @apply shadow-lg;
    }

    /* Custom Section Card */
    .section-card {
        @apply bg-gray-900 rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-800;
    }

    .section-header {
        @apply bg-gradient-to-r from-primary-600 to-blue-600 px-6 py-4 flex items-center text-white font-bold text-lg shadow-md;
    }

    .section-content {
        @apply p-6;
    }

    /* Form Grid Layout */
    .form-grid {
        @apply grid grid-cols-1 md:grid-cols-2 gap-6;
    }

    /* File Upload Area */
    .file-upload-area {
        @apply border-2 border-dashed border-gray-700 rounded-lg p-4 text-center cursor-pointer hover:border-primary-500 transition-colors;
    }

    .file-upload-icon {
        @apply text-3xl text-gray-500 mb-2;
    }

    /* Welcome Banner */
    .welcome-banner {
        @apply bg-gradient-to-r from-primary-600 to-blue-600 rounded-xl shadow-lg p-6 mb-8;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }

    .content-section {
        animation: fadeIn 0.3s ease-out;
    }

    /* Improved Buttons */
    button[type="submit"], a.px-6 {
        @apply shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview with animation
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-placeholder');
        const fileName = document.getElementById('file-name');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Validate file size
                const fileSize = this.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 2) {
                    showError('Image file size must be less than 2MB');
                    this.value = ''; // Clear the input
                    return;
                }

                // Validate file type
                const fileType = this.files[0].type;
                if (!fileType.match('image.*')) {
                    showError('Please select an image file');
                    this.value = ''; // Clear the input
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Fade out placeholder
                    imagePlaceholder.style.opacity = '0';
                    setTimeout(() => {
                        // Set new image and fade it in
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        imagePlaceholder.classList.add('hidden');
                        imagePreview.style.opacity = '0';
                        setTimeout(() => {
                            imagePreview.style.opacity = '1';
                        }, 50);

                        // Show filename with animation
                        fileName.textContent = imageInput.files[0].name;
                        fileName.classList.add('text-primary-400');
                        setTimeout(() => {
                            fileName.classList.remove('text-primary-400');
                        }, 1500);
                    }, 200);
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.classList.add('hidden');
                imagePlaceholder.classList.remove('hidden');
                fileName.textContent = 'No file chosen';
            }
        });

        // Enhanced file input handling with validation
        function setupFileInput(inputId, fileNameId, maxSize, fileType) {
            const input = document.getElementById(inputId);
            const fileNameElement = document.getElementById(fileNameId);

            if (input && fileNameElement) {
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        // Validate file size
                        const fileSize = this.files[0].size / 1024 / 1024; // in MB
                        if (fileSize > maxSize) {
                            showError(`File size must be less than ${maxSize}MB`);
                            this.value = ''; // Clear the input
                            return;
                        }

                        // Validate file type if specified
                        if (fileType && !this.files[0].type.match(fileType)) {
                            showError(`Please select a valid ${fileType.replace('.*', '')} file`);
                            this.value = ''; // Clear the input
                            return;
                        }

                        // Animate filename change
                        fileNameElement.style.opacity = '0';
                        setTimeout(() => {
                            fileNameElement.textContent = this.files[0].name;
                            fileNameElement.classList.add('text-primary-400');
                            fileNameElement.style.opacity = '1';
                            setTimeout(() => {
                                fileNameElement.classList.remove('text-primary-400');
                            }, 1500);
                        }, 200);
                    } else {
                        fileNameElement.textContent = 'No file chosen';
                    }
                });
            }
        }

        // Setup file inputs with validation
        setupFileInput('pdf_file', 'pdf-file-name', 10, 'application/pdf');
        setupFileInput('video_file', 'video-file-name', 100, 'video.*');

        // YouTube preview functionality
        const youtubeInput = document.getElementById('youtube_link');
        const youtubePreview = document.getElementById('youtube-preview');

        if (youtubeInput && youtubePreview) {
            youtubeInput.addEventListener('input', debounce(function() {
                const url = youtubeInput.value.trim();
                if (url && isValidYouTubeUrl(url)) {
                    const videoId = extractYouTubeVideoId(url);
                    if (videoId) {
                        youtubePreview.innerHTML = `
                            <iframe
                                width="100%"
                                height="100%"
                                src="https://www.youtube.com/embed/${videoId}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="rounded-lg"
                            ></iframe>
                        `;
                    }
                } else {
                    youtubePreview.innerHTML = `<p class="text-gray-500">Enter a valid YouTube URL to see preview</p>`;
                }
            }, 800));
        }

        // Helper functions for YouTube
        function isValidYouTubeUrl(url) {
            const pattern = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/;
            return pattern.test(url);
        }

        function extractYouTubeVideoId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this, args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    func.apply(context, args);
                }, wait);
            };
        }

        // Improved content type switching with animation
        const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
        const contentSections = document.querySelectorAll('.content-section');

        function showSelectedContentSection() {
            const selectedValue = document.querySelector('input[name="content_type"]:checked').value;

            // Hide all sections with fade out
            contentSections.forEach(section => {
                if (!section.classList.contains('hidden')) {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(10px)';

                    setTimeout(() => {
                        section.classList.add('hidden');

                        // Show selected section with fade in
                        const selectedSection = document.getElementById(`${selectedValue}_content_section`);
                        selectedSection.classList.remove('hidden');
                        selectedSection.style.opacity = '0';
                        selectedSection.style.transform = 'translateY(10px)';

                        setTimeout(() => {
                            selectedSection.style.opacity = '1';
                            selectedSection.style.transform = 'translateY(0)';
                        }, 50);
                    }, 200);
                }
            });

            // If all sections are hidden, just show the selected one
            if (document.querySelectorAll('.content-section:not(.hidden)').length === 0) {
                const selectedSection = document.getElementById(`${selectedValue}_content_section`);
                selectedSection.classList.remove('hidden');
                selectedSection.style.opacity = '0';
                selectedSection.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    selectedSection.style.opacity = '1';
                    selectedSection.style.transform = 'translateY(0)';
                }, 50);
            }
        }

        contentTypeRadios.forEach(radio => {
            radio.addEventListener('change', showSelectedContentSection);
        });

        // Initialize with the default selected content type
        showSelectedContentSection();

        // Add transition styles
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        });

        // Add smooth transition to image preview
        if (imagePreview && imagePlaceholder) {
            imagePreview.style.transition = 'opacity 0.3s ease';
            imagePlaceholder.style.transition = 'opacity 0.3s ease';
        }

        // Add transition to file names
        document.querySelectorAll('.file-name').forEach(el => {
            el.style.transition = 'opacity 0.3s ease, color 0.3s ease';
        });

        // Function to update the hidden is_published field
        window.updatePublishValue = function(checkbox) {
            document.getElementById('is_published').value = checkbox.checked ? '1' : '0';
        };

        // Form submission handling
        const form = document.getElementById('course-form');
        const submitButton = document.getElementById('submit-button');
        const loadingSpinner = document.querySelector('.loading-spinner');

        if (form && submitButton) {
            form.addEventListener('submit', function(e) {
                // Basic form validation
                const title = document.getElementById('title').value.trim();
                const description = document.getElementById('description').value.trim();
                const category = document.getElementById('category_id').value;

                let isValid = true;
                let errorMessage = '';

                if (!title) {
                    isValid = false;
                    errorMessage = 'Course title is required';
                } else if (!description) {
                    isValid = false;
                    errorMessage = 'Course description is required';
                } else if (!category) {
                    isValid = false;
                    errorMessage = 'Please select a category';
                }

                // Content type specific validation
                const selectedContentType = document.querySelector('input[name="content_type"]:checked').value;

                if (selectedContentType === 'text') {
                    const content = document.getElementById('content').value.trim();
                    if (!content) {
                        isValid = false;
                        errorMessage = 'Please enter some text content for your course';
                    }
                } else if (selectedContentType === 'pdf') {
                    const pdfFile = document.getElementById('pdf_file').files[0];
                    if (!pdfFile) {
                        isValid = false;
                        errorMessage = 'Please upload a PDF file';
                    }
                } else if (selectedContentType === 'video') {
                    const videoFile = document.getElementById('video_file').files[0];
                    if (!videoFile) {
                        isValid = false;
                        errorMessage = 'Please upload a video file';
                    }
                } else if (selectedContentType === 'youtube') {
                    const youtubeLink = document.getElementById('youtube_link').value.trim();
                    if (!youtubeLink || !isValidYouTubeUrl(youtubeLink)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid YouTube URL';
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    showError(errorMessage);
                    return;
                }

                // Show loading state
                submitButton.disabled = true;
                submitButton.classList.add('opacity-75');
                loadingSpinner.classList.remove('hidden');
            });
        }

        // Error message display
        function showError(message) {
            // Create error element if it doesn't exist
            let errorContainer = document.getElementById('form-error-container');
            if (!errorContainer) {
                errorContainer = document.createElement('div');
                errorContainer.id = 'form-error-container';
                errorContainer.className = 'bg-red-900/50 border border-red-700 text-red-300 p-4 rounded-lg mb-6 flex items-start';

                const icon = document.createElement('i');
                icon.className = 'fas fa-exclamation-triangle text-red-400 mt-1 mr-3';

                const textContainer = document.createElement('div');
                const errorText = document.createElement('p');
                errorText.id = 'form-error-message';

                textContainer.appendChild(errorText);
                errorContainer.appendChild(icon);
                errorContainer.appendChild(textContainer);

                // Insert at the top of the form
                form.insertBefore(errorContainer, form.firstChild);
            }

            // Update error message
            document.getElementById('form-error-message').textContent = message;

            // Scroll to error
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Highlight error with animation
            errorContainer.style.animation = 'none';
            setTimeout(() => {
                errorContainer.style.animation = 'pulse 2s';
            }, 10);
        }
    });
</script>
@endpush
