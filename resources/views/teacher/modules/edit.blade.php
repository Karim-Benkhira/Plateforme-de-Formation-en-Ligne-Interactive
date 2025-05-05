@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Edit Module') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.modules.update', $module) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Module Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $module->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Module Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $module->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="order" class="form-label">{{ __('Order') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $module->order) }}" min="0" required>
                            <div class="form-text">{{ __('The order in which this module appears in the course.') }}</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.courses.edit', $module->course_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Course') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Update Module') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Module Content') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>{{ __('Lessons') }}</h4>
                        <a href="{{ route('teacher.lessons.create', ['module_id' => $module->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>{{ __('Add Lesson') }}
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Quizzes') }}</th>
                                    <th>{{ __('Order') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($module->lessons->sortBy('order') as $lesson)
                                    <tr>
                                        <td>{{ $lesson->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $lesson->content_type == 'text' ? 'primary' : ($lesson->content_type == 'video' ? 'danger' : 'info') }}">
                                                {{ ucfirst($lesson->content_type) }}
                                            </span>
                                        </td>
                                        <td>{{ $lesson->quizzes->count() }}</td>
                                        <td>{{ $lesson->order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('teacher.lessons.edit', $lesson) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteLessonModal{{ $lesson->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Delete Lesson Modal -->
                                            <div class="modal fade" id="deleteLessonModal{{ $lesson->id }}" tabindex="-1" aria-labelledby="deleteLessonModalLabel{{ $lesson->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteLessonModalLabel{{ $lesson->id }}">{{ __('Delete Lesson') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this lesson?') }}
                                                            <p class="text-danger">{{ __('This will also delete all quizzes associated with this lesson.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form action="{{ route('teacher.lessons.destroy', $lesson) }}" method="POST">
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
                                        <td colspan="5" class="text-center">{{ __('No lessons found.') }}</td>
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
