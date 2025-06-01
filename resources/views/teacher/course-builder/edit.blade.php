@extends('layouts.teacher')

@section('title', 'Edit Course - ' . $course->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/course-builder.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('teacher.course-builder.index') }}" class="mr-4 text-white hover:text-blue-100 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">{{ $course->title }}</h1>
                <p class="text-blue-100">Course Builder - Add sections and lessons</p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $course->is_published ? 'bg-green-500 text-white' : 'bg-yellow-500 text-black' }}">
                {{ $course->status_label }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-3">
        <!-- Course Curriculum -->
        <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-list mr-3"></i>
                    Course Curriculum
                </h2>
                <button onclick="addSection()" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-all">
                    <i class="fas fa-plus mr-2"></i>
                    Add Section
                </button>
            </div>

            <div class="p-6" id="curriculum-container">
                @if($course->sections->count() > 0)
                    @foreach($course->sections as $section)
                        <div class="section-item mb-6 bg-gray-800 rounded-lg border border-gray-700" data-section-id="{{ $section->id }}">
                            <!-- Section Header -->
                            <div class="section-header p-4 bg-gray-700 rounded-t-lg flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <i class="fas fa-grip-vertical text-gray-400 mr-3 cursor-move"></i>
                                    <div class="flex-1">
                                        <h3 class="text-white font-semibold">{{ $section->title }}</h3>
                                        <p class="text-gray-400 text-sm">
                                            {{ $section->lessons->count() }} lessons
                                            @if($section->description)
                                                • {{ Str::limit($section->description, 50) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 rounded text-xs {{ $section->is_published ? 'bg-green-600 text-white' : 'bg-yellow-600 text-black' }}">
                                        {{ $section->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                    <button onclick="toggleSection({{ $section->id }})"
                                        class="text-gray-400 hover:text-white transition-colors">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <button onclick="toggleSectionPublish({{ $section->id }})"
                                        class="text-yellow-400 hover:text-yellow-300 transition-colors"
                                        title="{{ $section->is_published ? 'Unpublish Section' : 'Publish Section' }}">
                                        <i class="fas {{ $section->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                    <button onclick="editSection({{ $section->id }})"
                                        class="text-blue-400 hover:text-blue-300 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteSection({{ $section->id }})"
                                        class="text-red-400 hover:text-red-300 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Section Content -->
                            <div class="section-content p-4" id="section-content-{{ $section->id }}">
                                <!-- Lessons -->
                                <div class="lessons-container mb-4" data-section-id="{{ $section->id }}">
                                    @foreach($section->lessons as $lesson)
                                        <div class="lesson-item mb-3 p-3 bg-gray-900 rounded-lg border border-gray-600 flex items-center justify-between" data-lesson-id="{{ $lesson->id }}">
                                            <div class="flex items-center flex-1">
                                                <i class="fas fa-grip-vertical text-gray-500 mr-3 cursor-move"></i>
                                                <i class="{{ $lesson->content_type_icon }} text-blue-400 mr-3"></i>
                                                <div class="flex-1">
                                                    <h4 class="text-white font-medium">{{ $lesson->title }}</h4>
                                                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                                                        <span>{{ $lesson->content_type_label }}</span>
                                                        @if($lesson->duration)
                                                            <span>{{ $lesson->formatted_duration }}</span>
                                                        @endif
                                                        @if($lesson->is_free)
                                                            <span class="text-green-400">Free Preview</span>
                                                        @endif
                                                        <span class="px-2 py-1 rounded text-xs {{ $lesson->is_published ? 'bg-green-600 text-white' : 'bg-yellow-600 text-black' }}">
                                                            {{ $lesson->is_published ? 'Published' : 'Draft' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button onclick="editLesson({{ $section->id }}, {{ $lesson->id }})"
                                                    class="text-blue-400 hover:text-blue-300 transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button onclick="toggleLessonPublish({{ $section->id }}, {{ $lesson->id }})"
                                                    class="text-yellow-400 hover:text-yellow-300 transition-colors">
                                                    <i class="fas {{ $lesson->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </button>
                                                <button onclick="deleteLesson({{ $section->id }}, {{ $lesson->id }})"
                                                    class="text-red-400 hover:text-red-300 transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add Lesson Button -->
                                <button onclick="addLesson({{ $section->id }})"
                                    class="w-full py-3 border-2 border-dashed border-gray-600 rounded-lg text-gray-400 hover:text-white hover:border-blue-500 transition-all">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Lesson
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-layer-group text-6xl text-gray-600 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-400 mb-2">No Sections Yet</h3>
                        <p class="text-gray-500 mb-6">Start building your course by adding sections</p>
                        <button onclick="addSection()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-all">
                            <i class="fas fa-plus mr-2"></i>
                            Add Your First Section
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Course Stats -->
        <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-600 to-blue-600 px-4 py-3">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Course Stats
                </h3>
            </div>
            <div class="p-4 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Sections</span>
                    <span class="text-white font-semibold stats-sections">{{ $course->sections->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Lessons</span>
                    <span class="text-white font-semibold stats-lessons">{{ $course->total_lessons }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Duration</span>
                    <span class="text-white font-semibold stats-duration">{{ $course->formatted_total_duration }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Published</span>
                    <span class="text-white font-semibold stats-published">{{ $course->published_lessons_count }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-400 text-sm">Course Progress</span>
                        <span class="text-white text-sm font-semibold">
                            {{ $course->sections->count() > 0 ? round(($course->published_lessons_count / max($course->total_lessons, 1)) * 100) : 0 }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300"
                             style="width: {{ $course->sections->count() > 0 ? round(($course->published_lessons_count / max($course->total_lessons, 1)) * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-4 py-3">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-bolt mr-2"></i>
                    Quick Actions
                </h3>
            </div>
            <div class="p-4 space-y-3">
                <button onclick="editCourseInfo()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-all">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Course Info
                </button>
                <button onclick="previewCourse()" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-all">
                    <i class="fas fa-eye mr-2"></i>
                    Preview Course
                </button>
                <button onclick="publishAllContent()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg transition-all">
                    <i class="fas fa-rocket mr-2"></i>
                    Publish All Content
                </button>
                <button onclick="toggleCoursePublish()" class="w-full {{ $course->is_published ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-purple-600 hover:bg-purple-700' }} text-white py-2 px-4 rounded-lg transition-all">
                    <i class="fas {{ $course->is_published ? 'fa-eye-slash' : 'fa-rocket' }} mr-2"></i>
                    {{ $course->is_published ? 'Unpublish' : 'Publish' }} Course
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modals will be added here -->
@include('teacher.course-builder.modals.section-modal')
@include('teacher.course-builder.modals.lesson-modal')

@endsection

@push('styles')
<style>
.sortable-ghost {
    opacity: 0.4;
    background: #374151;
}

.sortable-chosen {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.sortable-drag {
    transform: rotate(5deg);
}

.fa-grip-vertical {
    cursor: grab;
}

.fa-grip-vertical:active {
    cursor: grabbing;
}
</style>
@endpush

@push('scripts')
<!-- SortableJS for drag and drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
// Set current course ID for JavaScript
var currentCourseId = {{ $course->id }};
var currentSectionId = null;
var currentLessonId = null;

console.log('Course ID set to:', currentCourseId);

// Ensure functions are available globally
window.currentCourseId = currentCourseId;
window.currentSectionId = currentSectionId;
window.currentLessonId = currentLessonId;
</script>
<script src="{{ asset('js/course-builder.js') }}"></script>
<script>
// Inline functions as backup
function addSection() {
    console.log('Inline addSection called');
    showSectionModal(false);
}

function showSectionModal(isEdit = false, sectionData = null) {
    console.log('Inline showSectionModal called');
    const modal = document.getElementById('sectionModal');

    if (!modal) {
        alert('Modal not found. Please refresh the page.');
        return;
    }

    const title = document.getElementById('sectionModalTitle');
    const submitText = document.getElementById('sectionSubmitText');

    if (isEdit && sectionData) {
        title.textContent = 'Edit Section';
        submitText.textContent = 'Update Section';
        document.getElementById('sectionTitle').value = sectionData.title || '';
        document.getElementById('sectionDescription').value = sectionData.description || '';
    } else {
        title.textContent = 'Add Section';
        submitText.textContent = 'Create Section';
        document.getElementById('sectionTitle').value = '';
        document.getElementById('sectionDescription').value = '';
    }

    modal.classList.remove('hidden');
}

function closeSectionModal() {
    const modal = document.getElementById('sectionModal');
    modal.classList.add('hidden');
}

// Lesson functions
function addLesson(sectionId) {
    console.log('Inline addLesson called for section:', sectionId);
    currentSectionId = sectionId;
    currentLessonId = null;
    showLessonModal(false);
}

function showLessonModal(isEdit = false, lessonData = null) {
    console.log('Inline showLessonModal called');
    const modal = document.getElementById('lessonModal');

    if (!modal) {
        alert('Lesson modal not found. Please refresh the page.');
        return;
    }

    const title = document.getElementById('lessonModalTitle');
    const submitText = document.getElementById('lessonSubmitText');

    if (isEdit && lessonData) {
        title.textContent = 'Edit Lesson';
        submitText.textContent = 'Update Lesson';
        document.getElementById('lessonTitle').value = lessonData.title || '';
        document.getElementById('lessonDescription').value = lessonData.description || '';
        document.getElementById('contentType').value = lessonData.content_type || 'video';
        document.getElementById('contentUrl').value = lessonData.content_url || '';
        document.getElementById('contentText').value = lessonData.content_text || '';
        document.getElementById('duration').value = lessonData.duration || '';
        document.getElementById('isFree').checked = lessonData.is_free == 1 || lessonData.is_free === true;
    } else {
        title.textContent = 'Add Lesson';
        submitText.textContent = 'Create Lesson';
        document.getElementById('lessonTitle').value = '';
        document.getElementById('lessonDescription').value = '';
        document.getElementById('contentType').value = 'video';
        document.getElementById('contentUrl').value = '';
        document.getElementById('contentText').value = '';
        document.getElementById('duration').value = '';
        document.getElementById('isFree').checked = false;
    }

    toggleContentFields();
    modal.classList.remove('hidden');
}

function closeLessonModal() {
    const modal = document.getElementById('lessonModal');
    modal.classList.add('hidden');
}

function toggleContentFields() {
    const contentType = document.getElementById('contentType').value;

    const videoFields = document.getElementById('videoFields');
    const fileFields = document.getElementById('fileFields');
    const textFields = document.getElementById('textFields');

    if (videoFields) videoFields.style.display = contentType === 'video' ? 'block' : 'none';
    if (fileFields) fileFields.style.display = contentType === 'pdf' ? 'block' : 'none';
    if (textFields) textFields.style.display = contentType === 'text' ? 'block' : 'none';
}

function switchVideoSource(source) {
    const urlBtn = document.getElementById('urlSourceBtn');
    const uploadBtn = document.getElementById('uploadSourceBtn');
    const urlInput = document.getElementById('urlVideoInput');
    const uploadInput = document.getElementById('uploadVideoInput');

    if (source === 'url') {
        urlBtn.classList.add('active', 'bg-blue-600', 'text-white');
        urlBtn.classList.remove('bg-gray-700', 'text-gray-300');
        uploadBtn.classList.remove('active', 'bg-blue-600', 'text-white');
        uploadBtn.classList.add('bg-gray-700', 'text-gray-300');

        urlInput.style.display = 'block';
        uploadInput.style.display = 'none';
    } else {
        uploadBtn.classList.add('active', 'bg-blue-600', 'text-white');
        uploadBtn.classList.remove('bg-gray-700', 'text-gray-300');
        urlBtn.classList.remove('active', 'bg-blue-600', 'text-white');
        urlBtn.classList.add('bg-gray-700', 'text-gray-300');

        urlInput.style.display = 'none';
        uploadInput.style.display = 'block';
    }
}

function handleVideoFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    // Check file size (500MB limit)
    const maxSize = 500 * 1024 * 1024; // 500MB in bytes
    if (file.size > maxSize) {
        alert('File size must be less than 500MB');
        input.value = '';
        return;
    }

    // Show upload progress
    const uploadArea = document.getElementById('uploadArea');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadSuccess = document.getElementById('uploadSuccess');
    const uploadedFileName = document.getElementById('uploadedFileName');

    uploadArea.style.display = 'none';
    uploadProgress.style.display = 'block';
    uploadSuccess.style.display = 'none';

    // Simulate upload progress (in real implementation, this would be actual upload)
    let progress = 0;
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 100) progress = 100;

        progressBar.style.width = progress + '%';
        progressText.textContent = `Uploading... ${Math.round(progress)}%`;

        if (progress >= 100) {
            clearInterval(interval);
            uploadProgress.style.display = 'none';
            uploadSuccess.style.display = 'block';
            uploadedFileName.textContent = file.name;

            // Set the content URL to the file name (in real implementation, this would be the uploaded file URL)
            document.getElementById('contentUrl').value = 'uploaded:' + file.name;
        }
    }, 100);
}

// Quick Actions functions
function editCourseInfo() {
    console.log('Edit course info clicked');
    // Redirect to course edit page or open modal
    window.location.href = `/teacher/courses/create?edit=${currentCourseId}`;
}

function previewCourse() {
    console.log('Preview course clicked');
    // Open course preview in new tab
    window.open(`/courses/${currentCourseId}`, '_blank');
}

function toggleCoursePublish() {
    console.log('Toggle course publish clicked');
    console.log('Current course ID:', currentCourseId);

    if (!confirm('Are you sure you want to change the publish status of this course?')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page.');
        return;
    }

    const url = `/teacher/course-builder/${currentCourseId}`;
    console.log('Request URL:', url);

    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
    button.disabled = true;

    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            toggle_publish: true
        })
    })
    .then(response => {
        console.log('Response status:', response.status);

        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }

        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);

        if (data.success) {
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.innerHTML = `<i class="fas fa-check mr-2"></i>${data.message}`;
            document.body.appendChild(successMsg);

            // Auto remove message after 3 seconds
            setTimeout(() => {
                if (successMsg.parentNode) {
                    successMsg.parentNode.removeChild(successMsg);
                }
            }, 3000);

            // Reload page after 1.5 seconds
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);

        // Show error message
        const errorMsg = document.createElement('div');
        errorMsg.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        errorMsg.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>Error: ${error.message}`;
        document.body.appendChild(errorMsg);

        // Auto remove error message after 5 seconds
        setTimeout(() => {
            if (errorMsg.parentNode) {
                errorMsg.parentNode.removeChild(errorMsg);
            }
        }, 5000);
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Publish all content function
function publishAllContent() {
    console.log('Publish all content clicked');

    if (!confirm('Are you sure you want to publish ALL sections and lessons in this course? This will make all content visible to students.')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page.');
        return;
    }

    const url = `/teacher/course-builder/${currentCourseId}/publish-all`;
    console.log('Request URL:', url);

    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Publishing...';
    button.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => {
        console.log('Response status:', response.status);

        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }

        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);

        if (data.success) {
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.innerHTML = `<i class="fas fa-check mr-2"></i>${data.message}`;
            document.body.appendChild(successMsg);

            // Auto remove message after 3 seconds
            setTimeout(() => {
                if (successMsg.parentNode) {
                    successMsg.parentNode.removeChild(successMsg);
                }
            }, 3000);

            // Reload page after 1.5 seconds
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);

        // Show error message
        const errorMsg = document.createElement('div');
        errorMsg.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        errorMsg.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>Error: ${error.message}`;
        document.body.appendChild(errorMsg);

        // Auto remove error message after 5 seconds
        setTimeout(() => {
            if (errorMsg.parentNode) {
                errorMsg.parentNode.removeChild(errorMsg);
            }
        }, 5000);
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Toggle section publish status
function toggleSectionPublish(sectionId) {
    console.log('Toggle section publish clicked for section:', sectionId);

    if (!confirm('Are you sure you want to change the publish status of this section?')) {
        return;
    }

    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/toggle-publish`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.innerHTML = `<i class="fas fa-check mr-2"></i>${data.message}`;
            document.body.appendChild(successMsg);

            // Auto remove message after 3 seconds
            setTimeout(() => {
                if (successMsg.parentNode) {
                    successMsg.parentNode.removeChild(successMsg);
                }
            }, 3000);

            // Reload page after 1 second
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('Error updating section status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating section status');
    });
}

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const sectionForm = document.getElementById('sectionForm');
    if (sectionForm) {
        sectionForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const title = document.getElementById('sectionTitle').value;
            const description = document.getElementById('sectionDescription').value;

            if (!title.trim()) {
                alert('Please enter a section title');
                return;
            }

            // Create section
            fetch(`/teacher/course-builder/${currentCourseId}/sections`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    title: title,
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeSectionModal();
                    location.reload();
                } else {
                    alert('Error creating section');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating section');
            });
        });
    }

    // Lesson form handler
    const lessonForm = document.getElementById('lessonForm');
    if (lessonForm) {
        lessonForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const title = document.getElementById('lessonTitle').value;
            const description = document.getElementById('lessonDescription').value;
            const contentType = document.getElementById('contentType').value;
            const contentUrl = document.getElementById('contentUrl').value;
            const contentText = document.getElementById('contentText').value;
            const duration = document.getElementById('duration').value;
            const isFree = document.getElementById('isFree').checked;

            if (!title.trim()) {
                alert('Please enter a lesson title');
                return;
            }

            if (contentType === 'video' && !contentUrl.trim()) {
                alert('Please enter a video URL or upload a video file');
                return;
            }

            if (contentType === 'text' && !contentText.trim()) {
                alert('Please enter lesson content');
                return;
            }

            if (contentType === 'pdf' && !document.getElementById('contentFile').files.length) {
                alert('Please upload a PDF file');
                return;
            }

            // Create lesson
            fetch(`/teacher/course-builder/${currentCourseId}/sections/${currentSectionId}/lessons`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    title: title,
                    description: description,
                    content_type: contentType,
                    content_url: contentUrl,
                    content_text: contentText,
                    duration: duration,
                    is_free: isFree
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeLessonModal();
                    // Show success message before reload
                    const successMsg = document.createElement('div');
                    successMsg.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    successMsg.innerHTML = '<i class="fas fa-check mr-2"></i>Lesson created successfully!';
                    document.body.appendChild(successMsg);

                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('Error creating lesson: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating lesson');
            });
        });
    }

    // Content type change handler
    const contentTypeSelect = document.getElementById('contentType');
    if (contentTypeSelect) {
        contentTypeSelect.addEventListener('change', toggleContentFields);
    }
});
</script>
@endpush
