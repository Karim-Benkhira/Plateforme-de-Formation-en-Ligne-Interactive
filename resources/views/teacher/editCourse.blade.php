@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.courses') }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Course</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Course Basic Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>Basic Information
                </h2>

                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Course Title</label>
                    <input type="text" name="title" id="title" value="{{ $course->title }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>{{ $course->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Difficulty Level</label>
                        <select name="level" id="level" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="beginner" {{ $course->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ $course->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ $course->level == 'advanced' ? 'selected' : '' }}>Advanced</option>
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
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty to keep the current image. Recommended size: 1280x720 pixels (16:9 ratio)</p>
                        </div>
                        <div class="ml-4 w-32 h-32 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($course->image)
                                <img id="image-preview" src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="max-w-full max-h-full object-cover">
                            @else
                                <div id="image-placeholder" class="text-gray-400 dark:text-gray-500">
                                    <i class="fas fa-image text-3xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>
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
                        @php
                            $contentType = 'text';
                            if ($course->contents && $course->contents->count() > 0) {
                                $contentType = $course->contents->first()->type;
                            }
                        @endphp
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_text" value="text" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ $contentType == 'text' ? 'checked' : '' }}>
                            <label for="content_type_text" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Text</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_pdf" value="pdf" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ $contentType == 'pdf' ? 'checked' : '' }}>
                            <label for="content_type_pdf" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">PDF Document</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_video" value="video" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ $contentType == 'video' ? 'checked' : '' }}>
                            <label for="content_type_video" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Video File</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="content_type" id="content_type_youtube" value="youtube" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ $contentType == 'youtube' ? 'checked' : '' }}>
                            <label for="content_type_youtube" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">YouTube Link</label>
                        </div>
                    </div>
                </div>

                <!-- Text Content -->
                <div id="text_content_section" class="content-section mb-6 {{ $contentType != 'text' ? 'hidden' : '' }}">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Text Content</label>
                    <textarea name="content" id="content" rows="10" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ $course->contents && $course->contents->first() && $course->contents->first()->type == 'text' ? $course->contents->first()->content : '' }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can use Markdown formatting</p>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PDF Upload -->
                <div id="pdf_content_section" class="content-section mb-6 {{ $contentType != 'pdf' ? 'hidden' : '' }}">
                    <label for="pdf_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PDF Document</label>
                    @if($course->contents && $course->contents->first() && $course->contents->first()->type == 'pdf')
                        <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-red-500 text-xl mr-2"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Current PDF: </span>
                                <a href="{{ asset('storage/' . $course->contents->first()->file) }}" target="_blank" class="ml-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                    View PDF
                                </a>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maximum file size: 10MB. Leave empty to keep the current PDF.</p>
                    @error('pdf_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Video Upload -->
                <div id="video_content_section" class="content-section mb-6 {{ $contentType != 'video' ? 'hidden' : '' }}">
                    <label for="video_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Video File</label>
                    @if($course->contents && $course->contents->first() && $course->contents->first()->type == 'video')
                        <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-video text-purple-500 text-xl mr-2"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Current Video: </span>
                                <a href="{{ asset('storage/' . $course->contents->first()->file) }}" target="_blank" class="ml-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                    View Video
                                </a>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="video_file" id="video_file" accept="video/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Supported formats: MP4, WebM, Ogg (max 100MB). Leave empty to keep the current video.</p>
                    @error('video_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- YouTube Link -->
                <div id="youtube_content_section" class="content-section mb-6 {{ $contentType != 'youtube' ? 'hidden' : '' }}">
                    <label for="youtube_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">YouTube Video URL</label>
                    <input type="url" name="youtube_link" id="youtube_link" placeholder="https://www.youtube.com/watch?v=..." value="{{ $course->contents && $course->contents->first() && $course->contents->first()->type == 'youtube' ? $course->contents->first()->file : '' }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
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
                    <input type="checkbox" name="is_published" id="is_published" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ $course->is_published ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Publish course</label>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('teacher.courses') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg mr-2 transition duration-300">
                    Cancel
                </a>
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-6 rounded-lg transition duration-300 shadow-md">
                    <i class="fas fa-save mr-2"></i>Update Course
                </button>
            </div>
        </form>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Course Quizzes</h2>
            <a href="{{ route('teacher.quizzes.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Quiz
            </a>
        </div>

        @if($course->quizzes && $course->quizzes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Questions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($course->quizzes as $quiz)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $quiz->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $quiz->questions->count() }} questions</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($quiz->is_published)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Published</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Draft</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">Edit</a>
                                    <a href="{{ route('teacher.quizQuestions', $quiz->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">Questions</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 dark:text-gray-500 mb-4">
                    <i class="fas fa-clipboard-list text-5xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No Quizzes Yet</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">This course doesn't have any quizzes yet.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('teacher.quizzes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i> Create Quiz
                    </a>
                    <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <i class="fas fa-magic mr-2"></i> Generate AI Quiz
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-red-600 dark:text-red-400">Danger Zone</h2>
        </div>
        <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 rounded-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-red-800 dark:text-red-300">Delete this course</h3>
                    <p class="text-sm text-red-700 dark:text-red-400">Once you delete a course, there is no going back. Please be certain.</p>
                </div>
                <form action="{{ route('teacher.courses.delete', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Course
                    </button>
                </form>
            </div>
        </div>
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

        if (imageInput) {
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (imagePreview) {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                            if (imagePlaceholder) {
                                imagePlaceholder.classList.add('hidden');
                            }
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

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
    });
</script>
@endpush
