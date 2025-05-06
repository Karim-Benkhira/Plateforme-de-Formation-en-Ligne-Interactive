@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('sidebar-menu')
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link active">
            <span class="sidebar-menu-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="sidebar-menu-text">Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.users') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-users"></i></span>
            <span class="sidebar-menu-text">Manage Users</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.courses') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-book"></i></span>
            <span class="sidebar-menu-text">Manage Courses</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('admin.reports') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-chart-bar"></i></span>
            <span class="sidebar-menu-text">Reports</span>
        </a>
    </li>
    
    <div class="sidebar-divider"></div>
    
    <li class="sidebar-menu-item">
        <a href="{{ route('profile.edit') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-user"></i></span>
            <span class="sidebar-menu-text">My Profile</span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Admin Dashboard</h1>
            <div>
                <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </a>
                <a href="{{ route('admin.courses') }}" class="btn btn-outline-primary">
                    <i class="fas fa-book me-2"></i>Manage Courses
                </a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-primary-subtle text-primary">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalStudents }}</h3>
                        <p>Students</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-success-subtle text-success">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalTeachers }}</h3>
                        <p>Teachers</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-info-subtle text-info">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalCourses }}</h3>
                        <p>Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-warning-subtle text-warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalStudents + $totalTeachers }}</h3>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Platform Overview -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Platform Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="overviewChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">User Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="userDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.users') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-user-plus fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">Add New User</h5>
                                        <p class="card-text text-muted">Create new student or teacher accounts</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.courses') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-book-medical fa-3x text-success"></i>
                                        </div>
                                        <h5 class="card-title">Manage Courses</h5>
                                        <p class="card-text text-muted">View, edit or delete platform courses</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.reports') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-chart-line fa-3x text-info"></i>
                                        </div>
                                        <h5 class="card-title">View Reports</h5>
                                        <p class="card-text text-muted">Access detailed platform analytics</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="card h-100 border-0 shadow-sm text-decoration-none">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-cog fa-3x text-warning"></i>
                                        </div>
                                        <h5 class="card-title">Platform Settings</h5>
                                        <p class="card-text text-muted">Configure platform settings and options</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Users</h5>
                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // This is a placeholder for recent users
                                // In a real implementation, you would fetch recent users from the database
                                $recentUsers = \App\Models\User::latest()->take(5)->get();
                            @endphp
                            
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="me-3" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                            @else
                                                <div class="bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'teacher' ? 'success' : 'primary') }} text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'teacher' ? 'success' : 'primary') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($user->id != auth()->id())
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Platform Overview Chart
        const overviewCtx = document.getElementById('overviewChart').getContext('2d');
        const overviewChart = new Chart(overviewCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Students',
                        data: [50, 60, 70, 85, 95, {{ $totalStudents }}],
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Courses',
                        data: [10, 15, 20, 25, 30, {{ $totalCourses }}],
                        borderColor: '#ff5a00',
                        backgroundColor: 'rgba(255, 90, 0, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // User Distribution Chart
        const distributionCtx = document.getElementById('userDistributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Students', 'Teachers', 'Admins'],
                datasets: [{
                    data: [{{ $totalStudents }}, {{ $totalTeachers }}, 1],
                    backgroundColor: [
                        '#4361ee',
                        '#36b37e',
                        '#ff5a00'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
