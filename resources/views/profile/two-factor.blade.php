@extends('layouts.admin')

@section('title', 'Two-Factor Authentication')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-shield-alt mr-3 text-blue-300"></i>
                Two-Factor Authentication
            </h1>
            <p class="text-blue-100 opacity-90">Secure your account with an additional layer of protection.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('profile.edit') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Profile
            </a>
        </div>
    </div>
</div>

@if (session('status'))
    <div class="mb-6 bg-green-900/40 border border-green-700/50 text-green-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-green-600/5"></div>
        <div class="relative flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-2 text-xl"></i>
            <span>{{ session('status') }}</span>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="mb-6 bg-red-900/40 border border-red-700/50 text-red-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-red-600/5"></div>
        <div class="relative flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-2 text-xl"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
    <div class="relative">
        <div class="mb-6">
            <p class="text-gray-300 flex items-start">
                <i class="fas fa-info-circle text-blue-400 mr-2 mt-1"></i>
                Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to sign in.
            </p>
            
            @if ($enabled)
                <div class="flex items-center mt-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-800 to-green-900 rounded-full flex items-center justify-center mr-4 text-green-400 shadow-lg border border-green-700/50">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Two-factor authentication is enabled</h3>
                        <p class="text-green-300">Your account has an extra layer of security.</p>
                    </div>
                </div>
            @else
                <div class="flex items-center mt-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-800 to-yellow-900 rounded-full flex items-center justify-center mr-4 text-yellow-400 shadow-lg border border-yellow-700/50">
                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Two-factor authentication is not enabled</h3>
                        <p class="text-yellow-300">Add an extra layer of security to your account.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if ($enabled)
    <!-- Recovery Codes Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-purple-800/5"></div>
        <div class="relative">
            <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                    <i class="fas fa-key"></i>
                </div>
                <span>Recovery Codes</span>
            </h2>
            <p class="text-gray-300 mb-6 flex items-start">
                <i class="fas fa-info-circle text-purple-400 mr-2 mt-1"></i>
                Recovery codes can be used to access your account if you lose your two-factor authentication device. Keep these codes in a secure place; like a password manager or a safe.
            </p>
            
            <div class="bg-gray-800/50 p-4 rounded-lg mb-6 border border-gray-700/50 shadow-inner">
                <div class="grid grid-cols-2 gap-3">
                    @if (session('recoveryCodes'))
                        @foreach (session('recoveryCodes') as $code)
                            <div class="font-mono text-sm bg-gray-900/50 p-2 rounded border border-gray-700/50 text-gray-300">{{ $code }}</div>
                        @endforeach
                    @else
                        @foreach ($recoveryCodes as $code)
                            <div class="font-mono text-sm bg-gray-900/50 p-2 rounded border border-gray-700/50 text-gray-300">{{ $code }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <form action="{{ route('profile.two-factor.regenerate-recovery-codes') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-500 hover:to-purple-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-sync-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Regenerate Recovery Codes
                </button>
            </form>
        </div>
    </div>
    
    <!-- Disable 2FA Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-red-800/5"></div>
        <div class="relative">
            <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                <div class="bg-red-900/70 text-red-400 rounded-lg p-2 mr-3 shadow-inner shadow-red-950/50">
                    <i class="fas fa-ban"></i>
                </div>
                <span>Disable Two-Factor Authentication</span>
            </h2>
            <p class="text-gray-300 mb-6 flex items-start">
                <i class="fas fa-exclamation-triangle text-red-400 mr-2 mt-1"></i>
                If you would like to disable two-factor authentication, please confirm your password.
            </p>
            
            <form action="{{ route('profile.two-factor.disable') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-300 font-medium mb-2">Password <span class="text-red-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-hover:text-red-400 transition-colors duration-200"></i>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200" placeholder="Enter your current password" />
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-shield-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Disable Two-Factor Authentication
                </button>
            </form>
        </div>
    </div>
@else
    <!-- Enable 2FA Section -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-green-600/5 to-green-800/5"></div>
        <div class="relative">
            <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                <div class="bg-green-900/70 text-green-400 rounded-lg p-2 mr-3 shadow-inner shadow-green-950/50">
                    <i class="fas fa-cog"></i>
                </div>
                <span>Setup Instructions</span>
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <ol class="list-decimal list-inside space-y-3 text-gray-300">
                        <li>Download a two-factor authentication app like Google Authenticator, Microsoft Authenticator, or Authy.</li>
                        <li>Scan the QR code with your app, or manually enter the setup key.</li>
                        <li>Enter the 6-digit code from your app and your current password to enable two-factor authentication.</li>
                    </ol>
                    
                    <div class="mt-6 bg-gray-800/50 p-4 rounded-lg border border-gray-700/50 shadow-inner">
                        <p class="text-sm text-gray-400 mb-2">Setup Key:</p>
                        <div class="font-mono text-sm bg-gray-900/50 p-3 rounded border border-gray-700/50 text-blue-300">{{ $secretKey }}</div>
                    </div>
                </div>
                
                <div class="flex justify-center items-center">
                    <div class="bg-white p-3 rounded-lg shadow-lg">
                        {!! $qrCode !!}
                    </div>
                </div>
            </div>
            
            <form action="{{ route('profile.two-factor.enable') }}" method="POST" class="border-t border-gray-700/50 pt-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="code" class="block text-gray-300 font-medium mb-2">Authentication Code <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-500 group-hover:text-green-400 transition-colors duration-200"></i>
                            </div>
                            <input type="text" id="code" name="code" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" placeholder="Enter the 6-digit code" />
                        </div>
                        @error('code')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-gray-300 font-medium mb-2">Current Password <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-500 group-hover:text-green-400 transition-colors duration-200"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" placeholder="Enter your current password" />
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                        <i class="fas fa-shield-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Enable Two-Factor Authentication
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
@endsection
