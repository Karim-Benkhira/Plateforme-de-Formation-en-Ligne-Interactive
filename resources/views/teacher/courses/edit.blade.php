@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Teacher Menu') }}
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('teacher.dashboard') }}" class="d-block">
                                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('teacher.courses.create') }}" class="d-block">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Create Course') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('teacher.students') }}" class="d-block">
                                <i class="fas fa-user-graduate me-2"></i>{{ __('My Students') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ __('Edit Course') }}</h2>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-eye me-1"></i>{{ __('View Course') }}
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Course Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Course Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $course->start_date ? $course->start_date->format('Y-m-d') : '') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $course->end_date ? $course->end_date->format('Y-m-d') : '') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Course Status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="upcoming" {{ old('status', $course->status) == 'upcoming' ? 'selected' : '' }}>{{ __('Upcoming') }}</option>
                                <option value="active" {{ old('status', $course->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="completed" {{ old('status', $course->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Course Image') }}</label>
                            @if($course->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            <div class="form-text">{{ __('Recommended size: 1200x800 pixels. Max size: 2MB. Leave empty to keep the current image.') }}</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Dashboard') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Update Course') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Course Content') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>{{ __('Modules') }}</h4>
                        <a href="{{ route('teacher.modules.create', ['course_id' => $course->id]) }}" class="btn btn-success">
                            <i class="fas fa-plus-circle me-2"></i>{{ __('Add Module') }}
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Lessons') }}</th>
                                    <th>{{ __('Order') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($course->modules->sortBy('order') as $module)
                                    <tr>
                                        <td>{{ $module->title }}</td>
                                        <td>{{ $module->lessons->count() }}</td>
                                        <td>{{ $module->order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('teacher.modules.edit', $module) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModuleModal{{ $module->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Delete Module Modal -->
                                            <div class="modal fade" id="deleteModuleModal{{ $module->id }}" tabindex="-1" aria-labelledby="deleteModuleModalLabel{{ $module->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModuleModalLabel{{ $module->id }}">{{ __('Delete Module') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this module?') }}
                                                            <p class="text-danger">{{ __('This will also delete all lessons and quizzes associated with this module.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form action="{{ route('teacher.modules.destroy', $module) }}" method="POST">
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
                                        <td colspan="4" class="text-center">{{ __('No modules found.') }}</td>
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
