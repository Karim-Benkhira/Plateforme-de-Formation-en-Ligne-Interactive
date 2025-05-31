// Course Builder JavaScript

// Global variables
let currentCourseId = null;
let currentSectionId = null;
let currentLessonId = null;

console.log('Course Builder JS loaded');

// Test function to make sure JS is working
function testJS() {
    alert('JavaScript is working!');
}

function testFunction() {
    console.log('Test function called');
    alert('Test function works! currentCourseId: ' + currentCourseId);
}



// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // currentCourseId is now set in the blade template

    // Initialize sortable for sections and lessons
    initializeSortable();

    // Initialize form event listeners
    initializeFormListeners();

    // Initialize auto-save
    initializeAutoSave();
});

function initializeFormListeners() {
    // Section form listener
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

            // Call the appropriate function based on whether we're editing or creating
            if (currentSectionId) {
                updateSection(currentSectionId, title, description);
            } else {
                createSection(title, description);
            }
        });
    }

    // Lesson form listener
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
            const contentFile = document.getElementById('contentFile').files[0];

            if (!title.trim()) {
                alert('Please enter a lesson title');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('content_type', contentType);
            formData.append('content_url', contentUrl);
            formData.append('content_text', contentText);
            formData.append('duration', duration);
            formData.append('is_free', isFree ? '1' : '0');

            if (contentFile) {
                formData.append('content_file', contentFile);
            }

            // Call the appropriate function based on whether we're editing or creating
            if (currentLessonId) {
                updateLesson(currentSectionId, currentLessonId, formData);
            } else {
                createLesson(currentSectionId, formData);
            }
        });
    }
}

function initializeAutoSave() {
    // Auto-save form data every 30 seconds
    setInterval(() => {
        autoSaveFormData();
    }, 30000);

    // Save on form input changes
    document.addEventListener('input', function(e) {
        if (e.target.closest('#sectionForm') || e.target.closest('#lessonForm')) {
            clearTimeout(window.autoSaveTimeout);
            window.autoSaveTimeout = setTimeout(() => {
                autoSaveFormData();
            }, 2000);
        }
    });
}

function autoSaveFormData() {
    // Save section form data
    const sectionForm = document.getElementById('sectionForm');
    if (sectionForm && !sectionForm.closest('.hidden')) {
        const title = document.getElementById('sectionTitle').value;
        const description = document.getElementById('sectionDescription').value;

        if (title.trim()) {
            localStorage.setItem('courseBuilder_sectionDraft', JSON.stringify({
                title: title,
                description: description,
                timestamp: Date.now()
            }));
        }
    }

    // Save lesson form data
    const lessonForm = document.getElementById('lessonForm');
    if (lessonForm && !lessonForm.closest('.hidden')) {
        const title = document.getElementById('lessonTitle').value;
        const description = document.getElementById('lessonDescription').value;
        const contentType = document.getElementById('contentType').value;
        const contentUrl = document.getElementById('contentUrl').value;
        const contentText = document.getElementById('contentText').value;

        if (title.trim()) {
            localStorage.setItem('courseBuilder_lessonDraft', JSON.stringify({
                title: title,
                description: description,
                contentType: contentType,
                contentUrl: contentUrl,
                contentText: contentText,
                timestamp: Date.now()
            }));
        }
    }
}

function loadDraftData(formType) {
    const draftKey = `courseBuilder_${formType}Draft`;
    const draft = localStorage.getItem(draftKey);

    if (draft) {
        const data = JSON.parse(draft);
        const age = Date.now() - data.timestamp;

        // Only load drafts less than 1 hour old
        if (age < 3600000) {
            return data;
        } else {
            localStorage.removeItem(draftKey);
        }
    }

    return null;
}

function clearDraftData(formType) {
    localStorage.removeItem(`courseBuilder_${formType}Draft`);
}

// Section Management
function addSection() {
    console.log('addSection called - currentCourseId:', currentCourseId);
    currentSectionId = null; // Reset for new section
    showSectionModal(false);
}

function editSection(sectionId) {
    currentSectionId = sectionId;

    // Fetch section data from backend
    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSectionModal(true, data.section);
            } else {
                alert('Error loading section data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading section data');
        });
}

function deleteSection(sectionId) {
    if (!confirm('Are you sure you want to delete this section? All lessons in this section will also be deleted.')) {
        return;
    }

    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error deleting section');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting section');
    });
}

function toggleSection(sectionId) {
    const content = document.getElementById(`section-content-${sectionId}`);
    const icon = document.querySelector(`[onclick="toggleSection(${sectionId})"] i`);

    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.className = 'fas fa-chevron-down';
    } else {
        content.style.display = 'none';
        icon.className = 'fas fa-chevron-right';
    }
}

// Lesson Management
function addLesson(sectionId) {
    console.log('addLesson called with sectionId:', sectionId);
    currentSectionId = sectionId;
    currentLessonId = null; // Reset for new lesson
    showLessonModal(false);
}

function editLesson(sectionId, lessonId) {
    currentSectionId = sectionId;
    currentLessonId = lessonId;

    // Fetch lesson data from backend
    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/lessons/${lessonId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showLessonModal(true, data.lesson);
            } else {
                alert('Error loading lesson data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading lesson data');
        });
}

function deleteLesson(sectionId, lessonId) {
    if (!confirm('Are you sure you want to delete this lesson?')) {
        return;
    }

    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/lessons/${lessonId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error deleting lesson');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting lesson');
    });
}

function toggleLessonPublish(sectionId, lessonId) {
    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/lessons/${lessonId}/toggle-publish`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating lesson status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating lesson status');
    });
}

// Modal Management
function showSectionModal(isEdit = false, sectionData = null) {
    console.log('showSectionModal called', isEdit, sectionData);
    const modal = document.getElementById('sectionModal');
    console.log('Modal element found:', modal);

    if (!modal) {
        console.error('Section modal not found!');
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
    console.log('Modal should be visible now');
}

function closeSectionModal() {
    const modal = document.getElementById('sectionModal');
    modal.classList.add('hidden');
}

function showLessonModal(isEdit = false, lessonData = null) {
    const modal = document.getElementById('lessonModal');
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

    document.getElementById('videoFields').style.display = contentType === 'video' ? 'block' : 'none';
    document.getElementById('fileFields').style.display = contentType === 'pdf' ? 'block' : 'none';
    document.getElementById('textFields').style.display = contentType === 'text' ? 'block' : 'none';
}

// Video Source Management
function switchVideoSource(source) {
    const urlBtn = document.getElementById('urlSourceBtn');
    const uploadBtn = document.getElementById('uploadSourceBtn');
    const urlInput = document.getElementById('urlVideoInput');
    const uploadInput = document.getElementById('uploadVideoInput');

    if (source === 'url') {
        urlBtn.className = 'video-source-btn active bg-blue-600 text-white py-2 px-4 rounded-lg text-sm';
        uploadBtn.className = 'video-source-btn bg-gray-700 text-gray-300 py-2 px-4 rounded-lg text-sm';
        urlInput.style.display = 'block';
        uploadInput.style.display = 'none';

        // Clear upload data
        document.getElementById('videoFile').value = '';
        document.getElementById('uploadSuccess').style.display = 'none';
        document.getElementById('uploadProgress').style.display = 'none';
    } else {
        urlBtn.className = 'video-source-btn bg-gray-700 text-gray-300 py-2 px-4 rounded-lg text-sm';
        uploadBtn.className = 'video-source-btn active bg-blue-600 text-white py-2 px-4 rounded-lg text-sm';
        urlInput.style.display = 'none';
        uploadInput.style.display = 'block';

        // Clear URL data
        document.getElementById('contentUrl').value = '';
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

    // Check file type
    const allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/mkv', 'video/webm'];
    if (!allowedTypes.includes(file.type)) {
        alert('Please select a valid video file (MP4, AVI, MOV, MKV, WebM)');
        input.value = '';
        return;
    }

    // Show upload progress
    document.getElementById('uploadArea').style.display = 'none';
    document.getElementById('uploadProgress').style.display = 'block';
    document.getElementById('uploadSuccess').style.display = 'none';

    // Simulate upload progress (replace with actual upload logic)
    uploadVideoFile(file);
}

function uploadVideoFile(file) {
    const formData = new FormData();
    formData.append('video', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    const xhr = new XMLHttpRequest();

    // Track upload progress
    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percentComplete = (e.loaded / e.total) * 100;
            document.getElementById('progressBar').style.width = percentComplete + '%';
            document.getElementById('progressText').textContent = `Uploading... ${Math.round(percentComplete)}%`;
        }
    });

    // Handle completion
    xhr.addEventListener('load', function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Show success
                document.getElementById('uploadProgress').style.display = 'none';
                document.getElementById('uploadSuccess').style.display = 'block';
                document.getElementById('uploadedFileName').textContent = file.name;

                // Store the uploaded file path for form submission
                document.getElementById('contentUrl').value = response.file_path;
            } else {
                alert('Upload failed: ' + response.message);
                resetUploadArea();
            }
        } else {
            alert('Upload failed. Please try again.');
            resetUploadArea();
        }
    });

    // Handle errors
    xhr.addEventListener('error', function() {
        alert('Upload failed. Please check your connection and try again.');
        resetUploadArea();
    });

    // Send the request
    xhr.open('POST', '/teacher/upload-video');
    xhr.send(formData);
}

function resetUploadArea() {
    document.getElementById('uploadArea').style.display = 'block';
    document.getElementById('uploadProgress').style.display = 'none';
    document.getElementById('uploadSuccess').style.display = 'none';
    document.getElementById('videoFile').value = '';
}

// CRUD Functions
function createSection(title, description) {
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
            showSuccessMessage('Section created successfully!');
            closeSectionModal();
            updateCourseStats();
            setTimeout(() => location.reload(), 1000);
        } else {
            showErrorMessage('Error creating section');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating section');
    });
}

function updateSection(sectionId, title, description) {
    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}`, {
        method: 'PUT',
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
            alert('Error updating section');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating section');
    });
}

function createLesson(sectionId, formData) {
    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/lessons`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeLessonModal();
            location.reload();
        } else {
            alert('Error creating lesson');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating lesson');
    });
}

function updateLesson(sectionId, lessonId, formData) {
    // Add method override for PUT request
    formData.append('_method', 'PUT');

    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/lessons/${lessonId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeLessonModal();
            location.reload();
        } else {
            alert('Error updating lesson');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating lesson');
    });
}

// Initialize sortable functionality
function initializeSortable() {
    // Initialize sortable for sections
    const sectionsContainer = document.getElementById('curriculum-container');
    if (sectionsContainer && typeof Sortable !== 'undefined') {
        new Sortable(sectionsContainer, {
            handle: '.fa-grip-vertical',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                updateSectionOrder();
            }
        });

        // Initialize sortable for lessons in each section
        document.querySelectorAll('.lessons-container').forEach(container => {
            new Sortable(container, {
                handle: '.fa-grip-vertical',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    const sectionId = container.getAttribute('data-section-id');
                    updateLessonOrder(sectionId);
                }
            });
        });
    }
}

function updateSectionOrder() {
    const sections = [];
    document.querySelectorAll('.section-item').forEach((section, index) => {
        sections.push({
            id: section.getAttribute('data-section-id'),
            order_index: index + 1
        });
    });

    fetch(`/teacher/course-builder/${currentCourseId}/sections/order`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ sections: sections })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage('Section order updated!');
        }
    })
    .catch(error => {
        console.error('Error updating section order:', error);
        showErrorMessage('Error updating section order');
    });
}

function updateLessonOrder(sectionId) {
    const lessons = [];
    document.querySelectorAll(`[data-section-id="${sectionId}"] .lesson-item`).forEach((lesson, index) => {
        lessons.push({
            id: lesson.getAttribute('data-lesson-id'),
            order_index: index + 1
        });
    });

    fetch(`/teacher/course-builder/${currentCourseId}/sections/${sectionId}/lessons/order`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ lessons: lessons })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage('Lesson order updated!');
        }
    })
    .catch(error => {
        console.error('Error updating lesson order:', error);
        showErrorMessage('Error updating lesson order');
    });
}

// Course Management
function editCourseInfo() {
    // Redirect to course edit page
    window.location.href = `/teacher/courses/${currentCourseId}/edit`;
}

function previewCourse() {
    window.open(`/courses/${currentCourseId}`, '_blank');
}

function toggleCoursePublish() {
    if (!confirm('Are you sure you want to change the publish status of this course?')) {
        return;
    }

    fetch(`/teacher/course-builder/${currentCourseId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            toggle_publish: true
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating course status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating course status');
    });
}

// Utility Functions
function showSuccessMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(alertDiv);

    // Animate in
    setTimeout(() => {
        alertDiv.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        alertDiv.classList.add('translate-x-full');
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 300);
    }, 3000);
}

function showErrorMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(alertDiv);

    // Animate in
    setTimeout(() => {
        alertDiv.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        alertDiv.classList.add('translate-x-full');
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 300);
    }, 3000);
}

function updateCourseStats() {
    fetch(`/teacher/course-builder/${currentCourseId}/stats`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update stats in sidebar
            const stats = data.stats;
            document.querySelector('.stats-sections').textContent = stats.sections_count || 0;
            document.querySelector('.stats-lessons').textContent = stats.lessons_count || 0;
            document.querySelector('.stats-duration').textContent = stats.formatted_duration || '0m';
            document.querySelector('.stats-published').textContent = stats.published_lessons_count || 0;
        }
    })
    .catch(error => {
        console.error('Error updating stats:', error);
    });
}

// Make functions globally available
window.addSection = addSection;
window.addLesson = addLesson;
window.editSection = editSection;
window.editLesson = editLesson;
window.deleteSection = deleteSection;
window.deleteLesson = deleteLesson;
window.toggleSection = toggleSection;
window.toggleSectionPublish = toggleSectionPublish;
window.toggleLessonPublish = toggleLessonPublish;
window.showSectionModal = showSectionModal;
window.showLessonModal = showLessonModal;
window.closeSectionModal = closeSectionModal;
window.closeLessonModal = closeLessonModal;
window.toggleContentFields = toggleContentFields;
window.editCourseInfo = editCourseInfo;
window.previewCourse = previewCourse;
window.toggleCoursePublish = toggleCoursePublish;
window.testJS = testJS;
window.testFunction = testFunction;
window.switchVideoSource = switchVideoSource;
window.handleVideoFileSelect = handleVideoFileSelect;
