@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Edit Lesson') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Lesson Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content_type" class="form-label">{{ __('Content Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('content_type') is-invalid @enderror" id="content_type" name="content_type" required>
                                <option value="text" {{ old('content_type', $lesson->content_type) == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                <option value="video" {{ old('content_type', $lesson->content_type) == 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                                <option value="file" {{ old('content_type', $lesson->content_type) == 'file' ? 'selected' : '' }}>{{ __('File') }}</option>
                            </select>
                            @error('content_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="contentTextGroup">
                            <label for="content" class="form-label">{{ __('Lesson Content') }}</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $lesson->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="contentUrlGroup" style="display: none;">
                            <label for="content_url" class="form-label">{{ __('Content URL') }}</label>
                            <input type="text" class="form-control @error('content_url') is-invalid @enderror" id="content_url" name="content_url" value="{{ old('content_url', $lesson->content_url) }}">
                            <div class="form-text" id="urlHelpText">{{ __('Enter the URL of the video (YouTube, Vimeo, etc.)') }}</div>
                            @error('content_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="contentFileGroup" style="display: none;">
                            <label for="content_file" class="form-label">{{ __('Content File') }}</label>
                            @if($lesson->content_type == 'file' && $lesson->content_url)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $lesson->content_url) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file me-1"></i>{{ __('View Current File') }}
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('content_file') is-invalid @enderror" id="content_file" name="content_file">
                            <div class="form-text">{{ __('Upload a new file to replace the current one (PDF, DOCX, etc.)') }}</div>
                            @error('content_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="order" class="form-label">{{ __('Order') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $lesson->order) }}" min="0" required>
                            <div class="form-text">{{ __('The order in which this lesson appears in the module.') }}</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.modules.edit', $lesson->module_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Module') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Update Lesson') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Lesson Quizzes') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>{{ __('Quizzes') }}</h4>
                        <a href="{{ route('teacher.quizzes.create', ['lesson_id' => $lesson->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>{{ __('Add Quiz') }}
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Questions') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lesson->quizzes as $quiz)
                                    <tr>
                                        <td>{{ $quiz->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $quiz->type == 'practice' ? 'success' : 'danger' }}">
                                                {{ ucfirst($quiz->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $quiz->questions->count() }}</td>
                                        <td>
                                            <span class="badge bg-{{ $quiz->status == 'open' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($quiz->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQuizModal{{ $quiz->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Delete Quiz Modal -->
                                            <div class="modal fade" id="deleteQuizModal{{ $quiz->id }}" tabindex="-1" aria-labelledby="deleteQuizModalLabel{{ $quiz->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteQuizModalLabel{{ $quiz->id }}">{{ __('Delete Quiz') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this quiz?') }}
                                                            <p class="text-danger">{{ __('This will also delete all questions and student results associated with this quiz.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form action="{{ route('teacher.quizzes.destroy', $quiz) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('No quizzes found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentTypeSelect = document.getElementById('content_type');
        const contentTextGroup = document.getElementById('contentTextGroup');
        const contentUrlGroup = document.getElementById('contentUrlGroup');
        const contentFileGroup = document.getElementById('contentFileGroup');
        const urlHelpText = document.getElementById('urlHelpText');
        
        function updateContentFields() {
            const contentType = contentTypeSelect.value;
            
            contentTextGroup.style.display = contentType === 'text' ? 'block' : 'none';
            contentUrlGroup.style.display = contentType === 'text' ? 'none' : 'block';
            contentFileGroup.style.display = contentType === 'file' ? 'block' : 'none';
            
            if (contentType === 'video') {
                urlHelpText.textContent = '{{ __("Enter the URL of the video (YouTube, Vimeo, etc.)") }}';
            } else if (contentType === 'file') {
                urlHelpText.textContent = '{{ __("Enter an optional URL for the file or upload a file below") }}';
            }
        }
        
        contentTypeSelect.addEventListener('change', updateContentFields);
        
        // Initialize fields based on the selected content type
        updateContentFields();
    });
</script>
@endpush
