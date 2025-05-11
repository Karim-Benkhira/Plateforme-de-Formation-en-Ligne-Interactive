<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrightPath</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #111827;
        }

        .gradient-text {
            background: linear-gradient(to right, #0ea5e9, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-grid-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900">
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-1000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-2000"></div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    </div>

    <div class="relative z-10 w-full max-w-md px-4">
        <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-700">
            <div class="p-8">
                <div class="text-center mb-8">
                    <a href="/" class="inline-flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        <span class="text-2xl font-bold gradient-text">BrightPath</span>
                    </a>
                    <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
                    <p class="text-gray-400 mt-2">Sign in to your account to continue</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-500"></i>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                class="w-full pl-10 pr-3 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                required
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                            <a href="#" class="text-sm text-blue-400 hover:text-blue-300">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-500"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                class="w-full pl-10 pr-3 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                required
                            >
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-600 rounded bg-gray-700"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-300">Remember me</label>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1 flex items-center justify-center"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </div>

                    @if (session('success'))
                        <div class="p-4 bg-green-900 bg-opacity-40 border border-green-700 text-green-300 rounded-lg flex items-start">
                            <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Success!</h4>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('logout_success'))
                        <div class="p-4 bg-blue-900 bg-opacity-40 border border-blue-700 text-blue-300 rounded-lg flex items-start">
                            <i class="fas fa-sign-out-alt text-blue-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Logged Out</h4>
                                <p>{{ session('logout_success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 bg-red-900 bg-opacity-40 border border-red-700 text-red-300 rounded-lg flex items-start">
                            <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Error</h4>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="p-4 bg-red-900 bg-opacity-40 border border-red-700 text-red-300 rounded-lg">
                            <div class="flex items-start mb-2">
                                <i class="fas fa-exclamation-triangle text-red-400 mt-1 mr-3"></i>
                                <h4 class="font-semibold">Please fix the following errors:</h4>
                            </div>
                            <ul class="list-disc pl-10 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>

            <div class="py-4 px-8 bg-gray-900 border-t border-gray-700">
                <p class="text-center text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium">
                        Create an account
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>