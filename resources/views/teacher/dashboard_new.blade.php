@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('sidebar-menu')
    <li class="sidebar-menu-item">
        <a href="{{ route('teacher.dashboard') }}" class="sidebar-menu-link active">
            <span class="sidebar-menu-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="sidebar-menu-text">Dashboard</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('teacher.courses.create') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-plus-circle"></i></span>
            <span class="sidebar-menu-text">Create Course</span>
        </a>
    </li>
    <li class="sidebar-menu-item">
        <a href="{{ route('teacher.students') }}" class="sidebar-menu-link">
            <span class="sidebar-menu-icon"><i class="fas fa-user-graduate"></i></span>
            <span class="sidebar-menu-text">My Students</span>
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
            <h1 class="h3 mb-0 text-gray-800">Teacher Dashboard</h1>
            <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Create New Course
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-primary-subtle text-primary">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalCourses }}</h3>
                        <p>My Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-success-subtle text-success">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $totalStudents }}</h3>
                        <p>Enrolled Students</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-info-subtle text-info">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $courses->where('status', 'active')->count() }}</h3>
                        <p>Active Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-card-icon bg-warning-subtle text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3>{{ $courses->where('status', 'upcoming')->count() }}</h3>
                        <p>Upcoming Courses</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- My Courses Section -->
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Courses</h5>
                <a href="{{ route('teacher.courses.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Create New Course
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Students</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($course->image)
                                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="me-3" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; border-radius: 5px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $course->title }}</h6>
                                                <small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $course->status == 'active' ? 'success' : ($course->status == 'upcoming' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $course->enrollments->count() }}</td>
                                    <td>{{ $course->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCourseModal{{ $course->id }}" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Delete Course Modal -->
                                        <div class="modal fade" id="deleteCourseModal{{ $course->id }}" tabindex="-1" aria-labelledby="deleteCourseModalLabel{{ $course->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteCourseModalLabel{{ $course->id }}">Delete Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this course?
                                                        <p class="text-danger">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No courses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Student Activity</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @php
                        // This is a placeholder for recent activity
                        // In a real implementation, you would fetch recent enrollments, quiz completions, etc.
                        $recentActivities = collect([
                            [
                                'type' => 'enrollment',
                                'student' => 'John Doe',
                                'course' => 'Introduction to Web Development',
                                'time' => now()->subHours(2)
                            ],
                            [
                                'type' => 'quiz',
                                'student' => 'Jane Smith',
                                'quiz' => 'HTML Basics Quiz',
                                'score' => 85,
                                'time' => now()->subHours(5)
                            ],
                            [
                                'type' => 'lesson',
                                'student' => 'Mike Johnson',
                                'lesson' => 'CSS Fundamentals',
                                'time' => now()->subHours(8)
                            ],
                        ]);
                    @endphp
                    
                    @if($recentActivities->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                                <li class="list-group-item px-0">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            @if($activity['type'] == 'enrollment')
                                                <div class="bg-success text-white rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                            @elseif($activity['type'] == 'quiz')
                                                <div class="bg-primary text-white rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-clipboard-check"></i>
                                                </div>
                                            @elseif($activity['type'] == 'lesson')
                                                <div class="bg-info text-white rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-book-reader"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">
                                                    @if($activity['type'] == 'enrollment')
                                                        {{ $activity['student'] }} enrolled in <strong>{{ $activity['course'] }}</strong>
                                                    @elseif($activity['type'] == 'quiz')
                                                        {{ $activity['student'] }} completed <strong>{{ $activity['quiz'] }}</strong> with a score of {{ $activity['score'] }}%
                                                    @elseif($activity['type'] == 'lesson')
                                                        {{ $activity['student'] }} completed the lesson <strong>{{ $activity['lesson'] }}</strong>
                                                    @endif
                                                </h6>
                                                <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info">
                            No recent activity found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
