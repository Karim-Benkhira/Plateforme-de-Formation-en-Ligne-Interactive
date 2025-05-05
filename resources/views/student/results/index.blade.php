@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Student Menu') }}
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('student.dashboard') }}" class="d-block">
                                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('student.courses') }}" class="d-block">
                                <i class="fas fa-book me-2"></i>{{ __('My Courses') }}
                            </a>
                        </li>
                        <li class="list-group-item active bg-primary">
                            <a href="{{ route('student.results') }}" class="d-block text-white">
                                <i class="fas fa-chart-line me-2"></i>{{ __('My Results') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('courses.index') }}" class="d-block">
                                <i class="fas fa-search me-2"></i>{{ __('Browse Courses') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    {{ __('Filter Results') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('student.results') }}" method="GET">
                        <div class="mb-3">
                            <label for="course" class="form-label">{{ __('Course') }}</label>
                            <select class="form-select" id="course" name="course_id">
                                <option value="">{{ __('All Courses') }}</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="quiz_type" class="form-label">{{ __('Quiz Type') }}</label>
                            <select class="form-select" id="quiz_type" name="quiz_type">
                                <option value="">{{ __('All Types') }}</option>
                                <option value="practice" {{ request('quiz_type') == 'practice' ? 'selected' : '' }}>{{ __('Practice') }}</option>
                                <option value="exam" {{ request('quiz_type') == 'exam' ? 'selected' : '' }}>{{ __('Exam') }}</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="passed" {{ request('status') == 'passed' ? 'selected' : '' }}>{{ __('Passed') }}</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>{{ __('Filter') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('My Quiz Results') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ __('Total Quizzes') }}</h5>
                                    <h2 class="display-4">{{ $stats['total'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ __('Passed') }}</h5>
                                    <h2 class="display-4">{{ $stats['passed'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ __('Failed') }}</h5>
                                    <h2 class="display-4">{{ $stats['failed'] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Quiz') }}</th>
                                    <th>{{ __('Course') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Score') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($results as $result)
                                    <tr>
                                        <td>{{ $result->quiz->title }}</td>
                                        <td>{{ $result->quiz->lesson->module->course->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $result->quiz->type == 'practice' ? 'info' : 'warning' }}">
                                                {{ ucfirst($result->quiz->type) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($result->score, 1) }}%</td>
                                        <td>
                                            <span class="badge bg-{{ $result->passed ? 'success' : 'danger' }}">
                                                {{ $result->passed ? __('Passed') : __('Failed') }}
                                            </span>
                                        </td>
                                        <td>{{ $result->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('student.results.show', $result) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No results found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $results->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
