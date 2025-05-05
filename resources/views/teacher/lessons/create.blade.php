@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Add New Lesson') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.lessons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="module_id" value="{{ request('module_id') }}">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Lesson Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content_type" class="form-label">{{ __('Content Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('content_type') is-invalid @enderror" id="content_type" name="content_type" required>
                                <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>{{ __('Video') }}</option>
                                <option value="file" {{ old('content_type') == 'file' ? 'selected' : '' }}>{{ __('File') }}</option>
                            </select>
                            @error('content_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="contentTextGroup">
                            <label for="content" class="form-label">{{ __('Lesson Content') }}</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="contentUrlGroup" style="display: none;">
                            <label for="content_url" class="form-label">{{ __('Content URL') }}</label>
                            <input type="text" class="form-control @error('content_url') is-invalid @enderror" id="content_url" name="content_url" value="{{ old('content_url') }}">
                            <div class="form-text" id="urlHelpText">{{ __('Enter the URL of the video (YouTube, Vimeo, etc.)') }}</div>
                            @error('content_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="contentFileGroup" style="display: none;">
                            <label for="content_file" class="form-label">{{ __('Content File') }}</label>
                            <input type="file" class="form-control @error('content_file') is-invalid @enderror" id="content_file" name="content_file">
                            <div class="form-text">{{ __('Upload a file (PDF, DOCX, etc.)') }}</div>
                            @error('content_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="order" class="form-label">{{ __('Order') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}" min="0" required>
                            <div class="form-text">{{ __('The order in which this lesson appears in the module.') }}</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.modules.edit', request('module_id')) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Lesson') }}
                            </button>
                        </div>
                    </form>
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
