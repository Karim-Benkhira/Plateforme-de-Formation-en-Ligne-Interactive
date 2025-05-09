@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Profile Settings</h1>

        @if (session('status'))
            <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Profile Information</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Update your account's profile information and email address.
                </p>

                <form action="{{ route('profile.update') }}" method="POST" class="mt-6">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->username) }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                        Save
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Update Password</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Ensure your account is using a long, random password to stay secure.
                </p>

                <form action="{{ route('profile.password.update') }}" method="POST" class="mt-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                        <input type="password" id="password" name="password" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Two-Factor Authentication</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Add additional security to your account using two-factor authentication.
                </p>

                <div class="mt-6">
                    @if (auth()->user()->hasTwoFactorEnabled())
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">You have enabled two-factor authentication.</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Your account is secured with two-factor authentication.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">You have not enabled two-factor authentication.</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication.</p>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('profile.two-factor.show') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ auth()->user()->hasTwoFactorEnabled() ? 'Manage Two-Factor Authentication' : 'Enable Two-Factor Authentication' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Activity Log</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    View a log of your recent account activity.
                </p>

                <div class="mt-6">
                    <a href="{{ route('profile.activity') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        View Activity Log
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Browser Sessions</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Manage and log out your active sessions on other browsers and devices.
                </p>

                <div class="mt-6">
                    <a href="{{ route('profile.sessions') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Manage Sessions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
