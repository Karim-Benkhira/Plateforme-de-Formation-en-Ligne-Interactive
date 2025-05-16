@extends('layouts.teacher')

@section('title', 'Teacher Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row items-center">
            <div class="relative mb-6 md:mb-0 md:mr-8">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->username }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                            <span class="text-4xl text-white font-bold">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="document.getElementById('profile-image-modal').classList.remove('hidden')" class="absolute bottom-0 right-0 bg-blue-500 hover:bg-blue-600 text-white rounded-full p-2 shadow-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </button>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold text-white mb-2">{{ $user->username }}</h1>
                <p class="text-blue-100 mb-4">{{ $user->email }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <div class="bg-white/20 rounded-lg px-4 py-2 text-white">
                        <span class="font-bold text-xl">{{ $coursesCount }}</span>
                        <span class="block text-sm">Courses</span>
                    </div>
                    <div class="bg-white/20 rounded-lg px-4 py-2 text-white">
                        <span class="font-bold text-xl">{{ $quizzesCount }}</span>
                        <span class="block text-sm">Quizzes</span>
                    </div>
                    <div class="bg-white/20 rounded-lg px-4 py-2 text-white">
                        <span class="font-bold text-xl">{{ $studentCount }}</span>
                        <span class="block text-sm">Students</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Profile Information -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Information -->
            <div class="section-card">
                <div class="section-header">
                    <i class="fas fa-user-circle mr-2"></i> Profile Information
                </div>
                <div class="section-content">
                    <form action="{{ route('teacher.profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
                                @error('username')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="specialization" class="block text-sm font-medium text-gray-300 mb-1">Specialization</label>
                            <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $user->specialization) }}" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">
                            @error('specialization')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-300 mb-1">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Password Update -->
        <div class="space-y-8">
            <!-- Password Update -->
            <div id="password" class="section-card">
                <div class="section-header">
                    <i class="fas fa-lock mr-2"></i> Update Password
                </div>
                <div class="section-content">
                    <form action="{{ route('teacher.profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-300 mb-1">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-white">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-1">New Password</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-white">
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-white">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="btn-secondary">
                                <i class="fas fa-key mr-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="section-card">
                <div class="section-header">
                    <i class="fas fa-link mr-2"></i> Quick Links
                </div>
                <div class="section-content">
                    <div class="space-y-4">
                        <a href="{{ route('teacher.courses') }}" class="action-card">
                            <div class="action-icon primary">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <h3 class="action-title">My Courses</h3>
                                <p class="action-description">Manage your courses</p>
                            </div>
                        </a>
                        <a href="{{ route('teacher.quizzes') }}" class="action-card">
                            <div class="action-icon secondary">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div>
                                <h3 class="action-title">My Quizzes</h3>
                                <p class="action-description">Manage your quizzes</p>
                            </div>
                        </a>
                        <a href="{{ route('teacher.analytics') }}" class="action-card">
                            <div class="action-icon primary">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h3 class="action-title">Analytics</h3>
                                <p class="action-description">View student performance</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Image Modal -->
<div id="profile-image-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-gray-800 rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Update Profile Image</h3>
            <button type="button" onclick="document.getElementById('profile-image-modal').classList.add('hidden')" class="text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            <form action="{{ route('teacher.profile.image') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-700 mb-4">
                        <div id="image-preview" class="w-full h-full bg-gray-700 flex items-center justify-center">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->username }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl text-white font-bold">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                            @endif
                        </div>
                    </div>
                    <label for="profile_image" class="btn-primary cursor-pointer">
                        <i class="fas fa-upload mr-2"></i> Choose Image
                    </label>
                    <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <p class="text-sm text-gray-400 mt-2">Recommended: Square image, max 2MB</p>
                    @error('profile_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('profile-image-modal').classList.add('hidden')" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md shadow-md transition-colors mr-3">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
