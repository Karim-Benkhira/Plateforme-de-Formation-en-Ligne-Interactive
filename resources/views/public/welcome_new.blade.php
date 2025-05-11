<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrightPath - Interactive Learning Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
                        'bounce-slow': 'bounce 3s infinite',
                        'blob': 'blob 7s infinite',
                        'floating': 'floating 3s ease-in-out infinite',
                        'slide-in-left': 'slideInLeft 1s ease-out',
                        'slide-in-right': 'slideInRight 1s ease-out',
                        'fade-in': 'fadeIn 1.5s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'pulse-slow': 'pulseSlow 3s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' }
                        },
                        floating: {
                            '0%': { transform: 'translateY(0px) rotate(-2deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(0deg)' },
                            '100%': { transform: 'translateY(0px) rotate(-2deg)' }
                        },
                        slideInLeft: {
                            '0%': { transform: 'translateX(-100px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(100px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.8)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        pulseSlow: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Styles */
        .bg-grid-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .gradient-text {
            background: linear-gradient(to right, #0ea5e9, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stats-card {
            @apply bg-gray-800 rounded-lg p-6 flex items-center transition-all duration-300 hover:bg-gray-700 hover:shadow-lg;
        }

        .stats-icon {
            @apply w-12 h-12 rounded-full flex items-center justify-center mr-4 text-white text-xl;
        }

        .stats-icon.primary {
            @apply bg-blue-600;
        }

        .stats-icon.success {
            @apply bg-green-600;
        }

        .stats-icon.warning {
            @apply bg-yellow-600;
        }

        .stats-icon.danger {
            @apply bg-red-600;
        }

        .stats-label {
            @apply text-gray-400 text-sm;
        }

        .stats-value {
            @apply text-white text-2xl font-bold;
        }

        .section-title {
            @apply text-xl font-bold text-white mb-6;
        }

        .data-card {
            @apply bg-gray-800 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-200 bg-gray-900 overflow-x-hidden">

    <!-- Header -->
    <header class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        <span class="text-blue-500 text-2xl font-bold">BrightPath</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150" href="/">Home</a>
                    <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150" href="/about">About</a>
                    <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150" href="/courses">Courses</a>
                    <a class="px-4 py-2 rounded-md text-sm font-medium text-blue-500 border border-blue-500 hover:bg-blue-900 transition duration-150 ml-2" href="{{ route('login') }}">Login</a>
                    <a class="px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150" href="{{ route('register') }}">Register</a>
                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-400 hover:text-blue-500 focus:outline-none focus:text-blue-500" aria-label="Toggle menu">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900">
        <!-- Hero Section -->
        <section class="relative overflow-hidden min-h-screen flex items-center">
            <!-- Background Elements -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
                <div class="absolute top-40 right-10 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-1000"></div>
                <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-2000"></div>

                <!-- Decorative Elements -->
                <div class="hidden lg:block absolute top-40 left-20 transform rotate-12">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-500 opacity-50">
                        <circle cx="20" cy="20" r="8" stroke="currentColor" stroke-width="2"/>
                        <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                    </svg>
                </div>
                <div class="hidden lg:block absolute bottom-40 right-20 transform -rotate-12">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-purple-500 opacity-50">
                        <rect x="10" y="10" width="20" height="20" stroke="currentColor" stroke-width="2"/>
                        <rect x="4" y="4" width="32" height="32" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                    </svg>
                </div>

                <!-- Grid Pattern -->
                <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            </div>

            <!-- Hero Content -->
            <div class="container mx-auto px-4 py-20 relative z-10">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-10 md:mb-0 animate-slide-in-left">
                        <div class="inline-flex items-center px-3 py-1 bg-blue-900 text-blue-300 rounded-full text-sm font-semibold mb-4 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Next-Gen Learning Platform</span>
                        </div>
                        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 text-white">
                            Transform Your <span class="gradient-text">Learning Experience</span>
                        </h1>
                        <p class="text-xl text-gray-300 mb-8 max-w-lg">
                            BrightPath offers an interactive learning platform with AI-generated quizzes and secure exam environments powered by facial recognition.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="/courses" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1 animate-scale-in">
                                <span class="flex items-center">
                                    <span>Explore Courses</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </a>
                            <a href="/register" class="px-6 py-3 bg-gray-800 text-blue-400 font-semibold rounded-lg shadow-md border border-blue-500 hover:bg-gray-700 transition duration-300 transform hover:-translate-y-1 animate-scale-in" style="animation-delay: 0.2s">
                                <span class="flex items-center">
                                    <span>Join Now</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Features Section -->
    <section class="py-20 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Powerful Features for Modern Learning</h2>
                <p class="text-xl text-gray-400">Our platform combines cutting-edge technology with proven educational methods to deliver an exceptional learning experience.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.1s">
                    <div class="w-16 h-16 bg-blue-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-brain text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">AI-Generated Quizzes</h3>
                    <p class="text-gray-400 mb-6">Our AI analyzes course content to create personalized quizzes that adapt to your learning style and progress.</p>
                    <a href="#" class="text-blue-400 hover:text-blue-300 flex items-center font-medium">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-purple-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Secure Exam Environment</h3>
                    <p class="text-gray-400 mb-6">Our facial recognition technology ensures exam integrity while providing a comfortable testing experience.</p>
                    <a href="#" class="text-purple-400 hover:text-purple-300 flex items-center font-medium">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.3s">
                    <div class="w-16 h-16 bg-pink-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-pink-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Progress Tracking</h3>
                    <p class="text-gray-400 mb-6">Detailed analytics and visualizations help you understand your strengths and areas for improvement.</p>
                    <a href="#" class="text-pink-400 hover:text-pink-300 flex items-center font-medium">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.4s">
                    <div class="w-16 h-16 bg-green-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-users text-green-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Interactive Learning</h3>
                    <p class="text-gray-400 mb-6">Engage with course materials through interactive exercises, discussions, and collaborative projects.</p>
                    <a href="#" class="text-green-400 hover:text-green-300 flex items-center font-medium">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.5s">
                    <div class="w-16 h-16 bg-yellow-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-certificate text-yellow-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Certifications</h3>
                    <p class="text-gray-400 mb-6">Earn recognized certificates upon course completion to showcase your skills and knowledge.</p>
                    <a href="#" class="text-yellow-400 hover:text-yellow-300 flex items-center font-medium">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.6s">
                    <div class="w-16 h-16 bg-red-900 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-red-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Mobile Learning</h3>
                    <p class="text-gray-400 mb-6">Access your courses anytime, anywhere with our responsive platform optimized for all devices.</p>
                    <a href="#" class="text-red-400 hover:text-red-300 flex items-center font-medium">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">How BrightPath Works</h2>
                <p class="text-xl text-gray-400">Our simple process helps you start learning effectively in just a few steps.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative animate-fade-in" style="animation-delay: 0.1s">
                    <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative z-10">
                        <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">1</div>
                        <h3 class="text-xl font-bold mb-4 text-white mt-4">Create Your Account</h3>
                        <p class="text-gray-400">Sign up for a free account to browse our course catalog and explore the platform features.</p>
                    </div>
                    <div class="hidden md:block absolute top-1/2 left-full w-24 h-2 bg-gradient-to-r from-blue-600 to-transparent transform -translate-y-1/2 z-0"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative animate-fade-in" style="animation-delay: 0.2s">
                    <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative z-10">
                        <div class="absolute -top-4 -left-4 w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">2</div>
                        <h3 class="text-xl font-bold mb-4 text-white mt-4">Enroll in Courses</h3>
                        <p class="text-gray-400">Choose from a wide range of courses designed by expert educators and industry professionals.</p>
                    </div>
                    <div class="hidden md:block absolute top-1/2 left-full w-24 h-2 bg-gradient-to-r from-purple-600 to-transparent transform -translate-y-1/2 z-0"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative animate-fade-in" style="animation-delay: 0.3s">
                    <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative z-10">
                        <div class="absolute -top-4 -left-4 w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">3</div>
                        <h3 class="text-xl font-bold mb-4 text-white mt-4">Learn & Earn Certificates</h3>
                        <p class="text-gray-400">Complete courses at your own pace, take assessments, and earn certificates to showcase your skills.</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center animate-fade-in" style="animation-delay: 0.4s">
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <span>Get Started Today</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card animate-fade-in" style="animation-delay: 0.1s">
                    <div class="stats-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="stats-label">Active Students</div>
                        <div class="stats-value">10,000+</div>
                    </div>
                </div>

                <div class="stats-card animate-fade-in" style="animation-delay: 0.2s">
                    <div class="stats-icon success">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <div class="stats-label">Courses</div>
                        <div class="stats-value">500+</div>
                    </div>
                </div>

                <div class="stats-card animate-fade-in" style="animation-delay: 0.3s">
                    <div class="stats-icon warning">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div>
                        <div class="stats-label">Certificates Issued</div>
                        <div class="stats-value">25,000+</div>
                    </div>
                </div>

                <div class="stats-card animate-fade-in" style="animation-delay: 0.4s">
                    <div class="stats-icon danger">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div>
                        <div class="stats-label">Countries</div>
                        <div class="stats-value">150+</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">What Our Students Say</h2>
                <p class="text-xl text-gray-400">Hear from students who have transformed their learning experience with BrightPath.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative animate-fade-in" style="animation-delay: 0.1s">
                    <div class="absolute -top-5 -left-5">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-500">
                            <path d="M16.6667 6.66666H6.66669V16.6667H16.6667V6.66666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.3333 6.66666H23.3333V16.6667H33.3333V6.66666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.6667 23.3333H6.66669V33.3333H16.6667V23.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.3333 23.3333H23.3333V33.3333H33.3333V23.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="mb-6 pt-4">
                        <div class="flex mb-4">
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                        </div>
                        <p class="text-gray-300 italic">"BrightPath has completely transformed how I approach learning. The AI-generated quizzes helped me identify my weak areas and focus my studies effectively."</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-900 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold">SM</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold">Sarah Mitchell</h4>
                            <p class="text-gray-400 text-sm">Computer Science Student</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative animate-fade-in" style="animation-delay: 0.2s">
                    <div class="absolute -top-5 -left-5">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-purple-500">
                            <path d="M16.6667 6.66666H6.66669V16.6667H16.6667V6.66666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.3333 6.66666H23.3333V16.6667H33.3333V6.66666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.6667 23.3333H6.66669V33.3333H16.6667V23.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.3333 23.3333H23.3333V33.3333H33.3333V23.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="mb-6 pt-4">
                        <div class="flex mb-4">
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                        </div>
                        <p class="text-gray-300 italic">"The secure exam environment gave me confidence that my hard work would be recognized fairly. I've earned three certificates that have already helped me in my job search."</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-900 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold">JD</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold">James Davis</h4>
                            <p class="text-gray-400 text-sm">Business Analytics Graduate</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative animate-fade-in" style="animation-delay: 0.3s">
                    <div class="absolute -top-5 -left-5">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-pink-500">
                            <path d="M16.6667 6.66666H6.66669V16.6667H16.6667V6.66666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.3333 6.66666H23.3333V16.6667H33.3333V6.66666Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.6667 23.3333H6.66669V33.3333H16.6667V23.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M33.3333 23.3333H23.3333V33.3333H33.3333V23.3333Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="mb-6 pt-4">
                        <div class="flex mb-4">
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star text-yellow-500"></i>
                            <i class="fas fa-star-half-alt text-yellow-500"></i>
                        </div>
                        <p class="text-gray-300 italic">"As a working professional, I needed a flexible learning solution. BrightPath allowed me to study at my own pace and track my progress effectively. The mobile access was a game-changer."</p>
                    </div>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pink-900 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold">EL</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold">Emma Lopez</h4>
                            <p class="text-gray-400 text-sm">Marketing Professional</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob delay-1000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl p-8 md:p-12 shadow-xl border border-gray-700 max-w-5xl mx-auto animate-fade-in">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-2/3 mb-8 md:mb-0 md:pr-8">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Ready to Transform Your Learning Experience?</h2>
                        <p class="text-xl text-gray-300 mb-6">Join thousands of students who are already benefiting from our innovative learning platform.</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('register') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                                <span class="flex items-center">
                                    <span>Get Started for Free</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </a>
                            <a href="/courses" class="px-6 py-3 bg-gray-800 text-gray-300 font-semibold rounded-lg shadow-md border border-gray-600 hover:bg-gray-700 transition duration-300 transform hover:-translate-y-1">
                                <span class="flex items-center">
                                    <span>Browse Courses</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/3 flex justify-center">
                        <div class="relative w-48 h-48 animate-floating">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-blue-400 w-full h-full">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                            </svg>
                            <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

    <!-- Scripts -->
    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.animate-fade-in');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(element);
            });
        });
    </script>
</body>
</html>
