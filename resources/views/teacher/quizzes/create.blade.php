@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Add New Quiz') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.quizzes.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="lesson_id" value="{{ request('lesson_id') }}">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Quiz Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Quiz Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="duration" class="form-label">{{ __('Duration (minutes)') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', 30) }}" min="1" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Quiz Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="practice" {{ old('type') == 'practice' ? 'selected' : '' }}>{{ __('Practice Quiz') }}</option>
                                <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>{{ __('Exam') }}</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Quiz Status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>{{ __('Open') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('requires_face_recognition') is-invalid @enderror" id="requires_face_recognition" name="requires_face_recognition" value="1" {{ old('requires_face_recognition') ? 'checked' : '' }}>
                            <label class="form-check-label" for="requires_face_recognition">{{ __('Require Face Recognition') }}</label>
                            <div class="form-text">{{ __('If checked, students will need to verify their identity using face recognition before taking the quiz.') }}</div>
                            @error('requires_face_recognition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.lessons.edit', request('lesson_id')) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Quiz') }}
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
        const typeSelect = document.getElementById('type');
        const faceRecognitionCheck = document.getElementById('requires_face_recognition');
        
        typeSelect.addEventListener('change', function() {
            if (this.value === 'exam') {
                faceRecognitionCheck.checked = true;
            }
        });
    });
</script>
@endpush
