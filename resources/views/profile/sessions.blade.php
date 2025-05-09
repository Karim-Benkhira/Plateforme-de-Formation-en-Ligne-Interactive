@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Profile
            </a>
        </div>
        
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Browser Sessions</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage and log out your active sessions on other browsers and devices.
                </p>
            </div>
            
            @if (session('status'))
                <div class="px-6 py-4 bg-green-100 dark:bg-green-900 border-b border-green-200 dark:border-green-800 text-green-700 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="p-6">
                <div class="space-y-6">
                    <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                        <p>
                            If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.
                        </p>
                    </div>
                    
                    @if (count($sessions) > 0)
                        <div class="mt-5 space-y-6">
                            @foreach ($sessions as $session)
                                <div class="flex items-center">
                                    <div>
                                        @if ($session->agent->is_desktop)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    
                                    <div class="ml-3">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $session->agent->platform }} - {{ $session->agent->browser }}
                                        </div>
                                        
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ $session->ip_address }},
                                                
                                                @if ($session->is_current_device)
                                                    <span class="text-green-500 font-semibold">This device</span>
                                                @else
                                                    <span>Last active {{ $session->last_active }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="flex items-center mt-5">
                        <button type="button" id="logoutOtherSessionsButton" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Log Out Other Browser Sessions
                        </button>
                        
                        <div id="logoutOtherSessionsSpinner" class="ml-3 hidden">
                            <svg class="animate-spin h-5 w-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Log Out Other Devices Confirmation Modal -->
                    <div id="logoutOtherSessionsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                                Log Out Other Browser Sessions
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.
                                                </p>
                                                
                                                <div class="mt-4">
                                                    <form id="logoutOtherSessionsForm" action="{{ route('profile.sessions.destroy') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        
                                                        <div>
                                                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                                            <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                            
                                                            <div id="passwordError" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" id="confirmLogoutOtherSessions" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Log Out Other Browser Sessions
                                    </button>
                                    <button type="button" id="cancelLogoutOtherSessions" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutOtherSessionsButton = document.getElementById('logoutOtherSessionsButton');
        const logoutOtherSessionsModal = document.getElementById('logoutOtherSessionsModal');
        const cancelLogoutOtherSessions = document.getElementById('cancelLogoutOtherSessions');
        const confirmLogoutOtherSessions = document.getElementById('confirmLogoutOtherSessions');
        const logoutOtherSessionsForm = document.getElementById('logoutOtherSessionsForm');
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');
        const logoutOtherSessionsSpinner = document.getElementById('logoutOtherSessionsSpinner');
        
        // Show modal
        logoutOtherSessionsButton.addEventListener('click', function() {
            logoutOtherSessionsModal.classList.remove('hidden');
            passwordInput.focus();
        });
        
        // Hide modal
        cancelLogoutOtherSessions.addEventListener('click', function() {
            logoutOtherSessionsModal.classList.add('hidden');
            passwordInput.value = '';
            passwordError.classList.add('hidden');
            passwordError.textContent = '';
        });
        
        // Submit form
        confirmLogoutOtherSessions.addEventListener('click', function() {
            if (passwordInput.value === '') {
                passwordError.textContent = 'Please enter your password.';
                passwordError.classList.remove('hidden');
                return;
            }
            
            logoutOtherSessionsSpinner.classList.remove('hidden');
            logoutOtherSessionsForm.submit();
        });
        
        // Close modal when clicking outside
        logoutOtherSessionsModal.addEventListener('click', function(event) {
            if (event.target === logoutOtherSessionsModal) {
                logoutOtherSessionsModal.classList.add('hidden');
                passwordInput.value = '';
                passwordError.classList.add('hidden');
                passwordError.textContent = '';
            }
        });
        
        // Handle escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !logoutOtherSessionsModal.classList.contains('hidden')) {
                logoutOtherSessionsModal.classList.add('hidden');
                passwordInput.value = '';
                passwordError.classList.add('hidden');
                passwordError.textContent = '';
            }
        });
    });
</script>
@endsection
