@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Admin Menu') }}
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('admin.dashboard') }}" class="d-block">
                                <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('admin.users') }}" class="d-block">
                                <i class="fas fa-users me-2"></i>{{ __('Manage Users') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('admin.courses') }}" class="d-block">
                                <i class="fas fa-book me-2"></i>{{ __('Manage Courses') }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('admin.reports') }}" class="d-block">
                                <i class="fas fa-chart-bar me-2"></i>{{ __('Reports') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ __('Admin Dashboard') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4">{{ $totalStudents }}</h1>
                                    <p class="lead">{{ __('Students') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4">{{ $totalTeachers }}</h1>
                                    <p class="lead">{{ __('Teachers') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white mb-3">
                                <div class="card-body text-center">
                                    <h1 class="display-4">{{ $totalCourses }}</h1>
                                    <p class="lead">{{ __('Courses') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h4>{{ __('Quick Actions') }}</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-lg d-block mb-3">
                                    <i class="fas fa-user-plus me-2"></i>{{ __('Add New User') }}
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.courses') }}" class="btn btn-outline-success btn-lg d-block mb-3">
                                    <i class="fas fa-book-medical me-2"></i>{{ __('View All Courses') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
