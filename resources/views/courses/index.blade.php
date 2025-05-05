@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Available Courses') }}</h2>
                </div>

                <div class="card-body">
                    <div class="row">
                        @forelse($courses as $course)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="https://source.unsplash.com/random/300x200/?course" class="card-img-top" alt="{{ $course->title }}" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $course->title }}</h5>
                                        <p class="card-text text-muted">
                                            <small>
                                                <i class="fas fa-user me-1"></i> {{ $course->teacher->name }}
                                            </small>
                                        </p>
                                        <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">
                                            <i class="fas fa-info-circle me-1"></i> {{ __('View Details') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    {{ __('No courses available at the moment.') }}
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
