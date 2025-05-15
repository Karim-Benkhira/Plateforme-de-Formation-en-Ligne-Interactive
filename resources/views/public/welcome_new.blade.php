<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrightPath - Interactive Learning Platform</title>
    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.11.4/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.11.4/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
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
                        'spin-slow': 'spin 15s linear infinite',
                        'wave': 'wave 8s ease-in-out infinite',
                        'shimmer': 'shimmer 2s linear infinite',
                        'float-up-down': 'floatUpDown 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                        'morph': 'morph 8s ease-in-out infinite',
                        'tilt': 'tilt 10s infinite linear',
                        'bounce-in': 'bounceIn 1s ease-out',
                        'float-rotate': 'floatRotate 6s ease-in-out infinite',
                        'slide-up': 'slideUp 1s ease-out',
                        'slide-down': 'slideDown 1s ease-out',
                        'zoom-in': 'zoomIn 1s ease-out',
                        'zoom-out': 'zoomOut 1s ease-out',
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
                        },
                        wave: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '25%': { transform: 'translateY(-15px)' },
                            '50%': { transform: 'translateY(0)' },
                            '75%': { transform: 'translateY(15px)' }
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '200% 0' },
                            '100%': { backgroundPosition: '-200% 0' }
                        },
                        floatUpDown: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0)' },
                            '25%': { transform: 'translateY(-20px) rotate(3deg)' },
                            '50%': { transform: 'translateY(0) rotate(0)' },
                            '75%': { transform: 'translateY(20px) rotate(-3deg)' }
                        },
                        glow: {
                            '0%, 100%': { filter: 'brightness(1)' },
                            '50%': { filter: 'brightness(1.3)' }
                        },
                        morph: {
                            '0%, 100%': { borderRadius: '60% 40% 30% 70% / 60% 30% 70% 40%' },
                            '25%': { borderRadius: '30% 60% 70% 40% / 50% 60% 30% 60%' },
                            '50%': { borderRadius: '50% 60% 30% 60% / 30% 60% 70% 40%' },
                            '75%': { borderRadius: '60% 40% 60% 30% / 60% 40% 60% 40%' }
                        },
                        tilt: {
                            '0%, 100%': { transform: 'rotateX(0deg) rotateY(0deg)' },
                            '25%': { transform: 'rotateX(5deg) rotateY(10deg)' },
                            '50%': { transform: 'rotateX(0deg) rotateY(0deg)' },
                            '75%': { transform: 'rotateX(-5deg) rotateY(-10deg)' }
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.3)', opacity: '0' },
                            '50%': { transform: 'scale(1.05)', opacity: '0.9' },
                            '70%': { transform: 'scale(0.9)' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        floatRotate: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '25%': { transform: 'translateY(-15px) rotate(5deg)' },
                            '50%': { transform: 'translateY(0) rotate(0deg)' },
                            '75%': { transform: 'translateY(15px) rotate(-5deg)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        zoomIn: {
                            '0%': { transform: 'scale(0)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        zoomOut: {
                            '0%': { transform: 'scale(1.5)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
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
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
        }

        .gradient-border {
            position: relative;
            border-radius: 0.5rem;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #0ea5e9, #8b5cf6, #0ea5e9);
            border-radius: 0.6rem;
            z-index: -1;
            background-size: 200% 200%;
            animation: shimmer 3s linear infinite;
        }

        .card-hover {
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .card-hover:hover {
            transform: translateY(-15px) rotateX(5deg);
            box-shadow: 0 30px 40px -15px rgba(0, 0, 0, 0.2), 0 20px 20px -10px rgba(0, 0, 0, 0.1);
        }

        .card-hover:hover .card-icon {
            transform: translateZ(20px) scale(1.2);
            color: #38bdf8;
        }

        .card-icon {
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .stats-card {
            @apply bg-gray-800 rounded-lg p-6 flex items-center transition-all duration-500 hover:bg-gray-700 hover:shadow-lg;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.15), rgba(139, 92, 246, 0.15));
            z-index: -1;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .stats-card:hover::before {
            transform: translateY(0);
        }

        .stats-icon {
            @apply w-14 h-14 rounded-full flex items-center justify-center mr-4 text-white text-xl;
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .stats-icon::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.5s ease;
        }

        .stats-card:hover .stats-icon::after {
            transform: scale(2);
        }

        .stats-icon.primary {
            @apply bg-gradient-to-br from-blue-500 to-blue-700;
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.5);
        }

        .stats-icon.success {
            @apply bg-gradient-to-br from-green-500 to-green-700;
            box-shadow: 0 0 15px rgba(34, 197, 94, 0.5);
        }

        .stats-icon.warning {
            @apply bg-gradient-to-br from-yellow-500 to-yellow-700;
            box-shadow: 0 0 15px rgba(234, 179, 8, 0.5);
        }

        .stats-icon.danger {
            @apply bg-gradient-to-br from-red-500 to-red-700;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
        }

        .stats-label {
            @apply text-gray-400 text-sm;
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-label {
            @apply text-gray-200;
        }

        .stats-value {
            @apply text-white text-2xl font-bold;
            transition: all 0.3s ease;
            position: relative;
        }

        .stats-card:hover .stats-value {
            transform: scale(1.1);
            background: linear-gradient(to right, #0ea5e9, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-title {
            @apply text-xl font-bold text-white mb-6;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #0ea5e9, #8b5cf6);
            border-radius: 3px;
        }

        .data-card {
            @apply bg-gray-800 rounded-xl shadow-lg transition-all duration-500;
            position: relative;
            overflow: hidden;
        }

        .data-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            transform: rotate(45deg);
            transition: all 0.8s ease;
        }

        .data-card:hover::before {
            left: 100%;
        }

        .glass-effect {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .shimmer-effect {
            background: linear-gradient(90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                rgba(255, 255, 255, 0) 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .morphing-shape {
            animation: morph 8s ease-in-out infinite;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            transition: all 1s ease-in-out;
            background: linear-gradient(45deg, #0ea5e9, #8b5cf6);
        }

        .glow-effect {
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.5);
            animation: glow 3s ease-in-out infinite;
        }

        .btn-3d {
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: all 0.3s ease;
        }

        .btn-3d:hover {
            transform: translateY(-5px) rotateX(10deg);
        }

        .btn-3d::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 5%;
            width: 90%;
            height: 10px;
            background: linear-gradient(to right, rgba(14, 165, 233, 0.5), rgba(139, 92, 246, 0.5));
            filter: blur(10px);
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .btn-3d:hover::before {
            opacity: 0.8;
            bottom: -15px;
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
                        <img src="{{ asset('images/logo.svg') }}" alt="BrightPath Logo" class="h-10 w-10 mr-2">
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
            <!-- Particles Background -->
            <div id="particles-js" class="absolute inset-0 z-0"></div>

            <!-- Background Elements -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
                <div class="absolute top-40 right-10 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-1000"></div>
                <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-2000"></div>

                <!-- Morphing Shapes -->
                <div class="absolute top-1/4 left-1/4 w-32 h-32 morphing-shape opacity-20 animate-float-up-down"></div>
                <div class="absolute bottom-1/4 right-1/4 w-24 h-24 morphing-shape opacity-20 animate-float-rotate" style="animation-delay: 1s;"></div>

                <!-- Decorative Elements -->
                <div class="hidden lg:block absolute top-40 left-20 transform rotate-12 animate-spin-slow">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-500 opacity-50">
                        <circle cx="20" cy="20" r="8" stroke="currentColor" stroke-width="2"/>
                        <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                    </svg>
                </div>
                <div class="hidden lg:block absolute bottom-40 right-20 transform -rotate-12 animate-pulse-slow">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-purple-500 opacity-50">
                        <rect x="10" y="10" width="20" height="20" stroke="currentColor" stroke-width="2"/>
                        <rect x="4" y="4" width="32" height="32" stroke="currentColor" stroke-width="2" stroke-dasharray="4 4"/>
                    </svg>
                </div>

                <!-- Floating Elements -->
                <div class="hidden lg:block absolute top-1/3 right-1/3 animate-float-up-down" style="animation-delay: 0.5s;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-blue-400 opacity-30">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M15 9L9 15" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 9L15 15" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <div class="hidden lg:block absolute bottom-1/3 left-1/3 animate-float-rotate" style="animation-delay: 1.5s;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-purple-400 opacity-30">
                        <path d="M3 6H21" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 12H21" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 18H21" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>

                <!-- Grid Pattern -->
                <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>

                <!-- Light Rays Effect -->
                <div class="absolute inset-0 overflow-hidden opacity-10">
                    <div class="absolute -inset-[10%] rotate-45 bg-gradient-to-r from-transparent via-blue-500 to-transparent blur-3xl transform translate-x-full animate-shimmer"></div>
                    <div class="absolute -inset-[10%] -rotate-45 bg-gradient-to-r from-transparent via-purple-500 to-transparent blur-3xl transform -translate-x-full animate-shimmer" style="animation-delay: 1s;"></div>
                </div>
            </div>

            <!-- Hero Content -->
            <div class="container mx-auto px-4 py-20 relative z-10 hero-content">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 mb-10 md:mb-0 animate-slide-in-left">
                        <div class="inline-flex items-center px-3 py-1 bg-blue-900 text-blue-300 rounded-full text-sm font-semibold mb-4 shadow-sm glow-effect">
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
                            <a href="/courses" class="btn-3d px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1 animate-scale-in">
                                <span class="flex items-center">
                                    <span>Explore Courses</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </a>
                            <a href="/register" class="gradient-border px-6 py-3 bg-gray-800 text-blue-400 font-semibold rounded-lg shadow-md hover:bg-gray-700 transition duration-300 transform hover:-translate-y-1 animate-scale-in" style="animation-delay: 0.2s">
                                <span class="flex items-center">
                                    <span>Join Now</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- 3D Floating Element -->
                    <div class="hidden md:block md:w-1/2 relative">
                        <div class="absolute top-0 right-0 w-64 h-64 animate-float-rotate">
                            <div class="relative w-full h-full">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-xl animate-pulse-slow"></div>
                                <div class="absolute inset-4 bg-gradient-to-br from-blue-600/30 to-purple-600/30 rounded-full blur-lg animate-pulse-slow" style="animation-delay: 0.5s;"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <img src="{{ asset('images/logo.svg') }}" alt="BrightPath Logo" class="h-32 w-32">
                                </div>
                            </div>
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
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in glass-effect" style="animation-delay: 0.1s">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-6 card-icon glow-effect">
                        <i class="fas fa-brain text-blue-200 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">AI-Generated Quizzes</h3>
                    <p class="text-gray-400 mb-6">Our AI analyzes course content to create personalized quizzes that adapt to your learning style and progress.</p>
                    <a href="#" class="gradient-border inline-flex items-center px-4 py-2 rounded-lg text-blue-400 hover:text-blue-300 font-medium transition-all duration-300 hover:shadow-lg">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in glass-effect" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center mb-6 card-icon glow-effect">
                        <i class="fas fa-shield-alt text-purple-200 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Secure Exam Environment</h3>
                    <p class="text-gray-400 mb-6">Our facial recognition technology ensures exam integrity while providing a comfortable testing experience.</p>
                    <a href="#" class="gradient-border inline-flex items-center px-4 py-2 rounded-lg text-purple-400 hover:text-purple-300 font-medium transition-all duration-300 hover:shadow-lg">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in glass-effect" style="animation-delay: 0.3s">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-600 to-pink-800 rounded-full flex items-center justify-center mb-6 card-icon glow-effect">
                        <i class="fas fa-chart-line text-pink-200 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Progress Tracking</h3>
                    <p class="text-gray-400 mb-6">Detailed analytics and visualizations help you understand your strengths and areas for improvement.</p>
                    <a href="#" class="gradient-border inline-flex items-center px-4 py-2 rounded-lg text-pink-400 hover:text-pink-300 font-medium transition-all duration-300 hover:shadow-lg">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in glass-effect" style="animation-delay: 0.4s">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-800 rounded-full flex items-center justify-center mb-6 card-icon glow-effect">
                        <i class="fas fa-users text-green-200 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Interactive Learning</h3>
                    <p class="text-gray-400 mb-6">Engage with course materials through interactive exercises, discussions, and collaborative projects.</p>
                    <a href="#" class="gradient-border inline-flex items-center px-4 py-2 rounded-lg text-green-400 hover:text-green-300 font-medium transition-all duration-300 hover:shadow-lg">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in glass-effect" style="animation-delay: 0.5s">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-600 to-yellow-800 rounded-full flex items-center justify-center mb-6 card-icon glow-effect">
                        <i class="fas fa-certificate text-yellow-200 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Certifications</h3>
                    <p class="text-gray-400 mb-6">Earn recognized certificates upon course completion to showcase your skills and knowledge.</p>
                    <a href="#" class="gradient-border inline-flex items-center px-4 py-2 rounded-lg text-yellow-400 hover:text-yellow-300 font-medium transition-all duration-300 hover:shadow-lg">
                        <span>Learn more</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-800 rounded-xl p-8 shadow-lg card-hover animate-fade-in glass-effect" style="animation-delay: 0.6s">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center mb-6 card-icon glow-effect">
                        <i class="fas fa-mobile-alt text-red-200 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-white">Mobile Learning</h3>
                    <p class="text-gray-400 mb-6">Access your courses anytime, anywhere with our responsive platform optimized for all devices.</p>
                    <a href="#" class="gradient-border inline-flex items-center px-4 py-2 rounded-lg text-red-400 hover:text-red-300 font-medium transition-all duration-300 hover:shadow-lg">
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
    <section class="py-20 bg-gray-800 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0 opacity-20">
            <div class="absolute top-20 left-10 w-64 h-64 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute bottom-20 right-10 w-64 h-64 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl animate-blob delay-1000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">How BrightPath Works</h2>
                <p class="text-xl text-gray-400">Our simple process helps you start learning effectively in just a few steps.</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative animate-fade-in" style="animation-delay: 0.1s">
                    <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative z-10 glass-effect border border-gray-700 hover:border-blue-500 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute -top-4 -left-4 w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg glow-effect">1</div>
                        <h3 class="text-xl font-bold mb-4 text-white mt-4">Create Your Account</h3>
                        <p class="text-gray-400">Sign up for a free account to browse our course catalog and explore the platform features.</p>
                        <div class="absolute bottom-4 right-4 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="hidden md:block absolute top-1/2 left-full w-24 h-2 bg-gradient-to-r from-blue-600 to-transparent transform -translate-y-1/2 z-0 animate-pulse-slow"></div>
                </div>

                <!-- Step 2 -->
                <div class="relative animate-fade-in" style="animation-delay: 0.2s">
                    <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative z-10 glass-effect border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute -top-4 -left-4 w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg glow-effect">2</div>
                        <h3 class="text-xl font-bold mb-4 text-white mt-4">Enroll in Courses</h3>
                        <p class="text-gray-400">Choose from a wide range of courses designed by expert educators and industry professionals.</p>
                        <div class="absolute bottom-4 right-4 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="hidden md:block absolute top-1/2 left-full w-24 h-2 bg-gradient-to-r from-purple-600 to-transparent transform -translate-y-1/2 z-0 animate-pulse-slow"></div>
                </div>

                <!-- Step 3 -->
                <div class="relative animate-fade-in" style="animation-delay: 0.3s">
                    <div class="bg-gray-900 rounded-xl p-8 shadow-lg relative z-10 glass-effect border border-gray-700 hover:border-pink-500 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute -top-4 -left-4 w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg glow-effect">3</div>
                        <h3 class="text-xl font-bold mb-4 text-white mt-4">Learn & Earn Certificates</h3>
                        <p class="text-gray-400">Complete courses at your own pace, take assessments, and earn certificates to showcase your skills.</p>
                        <div class="absolute bottom-4 right-4 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center animate-fade-in" style="animation-delay: 0.4s">
                <a href="{{ route('register') }}" class="btn-3d inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <span class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                    <span>Get Started Today</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gray-900 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
            <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-900/20 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-purple-900/20 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-12 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Our Impact in Numbers</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card animate-fade-in glass-effect" style="animation-delay: 0.1s">
                    <div class="stats-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="stats-label">Active Students</div>
                        <div class="stats-value" data-count="10000">10,000+</div>
                    </div>
                </div>

                <div class="stats-card animate-fade-in glass-effect" style="animation-delay: 0.2s">
                    <div class="stats-icon success">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <div class="stats-label">Courses</div>
                        <div class="stats-value" data-count="500">500+</div>
                    </div>
                </div>

                <div class="stats-card animate-fade-in glass-effect" style="animation-delay: 0.3s">
                    <div class="stats-icon warning">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div>
                        <div class="stats-label">Certificates Issued</div>
                        <div class="stats-value" data-count="25000">25,000+</div>
                    </div>
                </div>

                <div class="stats-card animate-fade-in glass-effect" style="animation-delay: 0.4s">
                    <div class="stats-icon danger">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div>
                        <div class="stats-label">Countries</div>
                        <div class="stats-value" data-count="150">150+</div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-12">
                <div class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-full text-gray-300 text-sm animate-pulse-slow">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    <span>Real-time data updated daily</span>
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

            // Initialize particles.js
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 80,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": ["#0ea5e9", "#8b5cf6", "#ec4899"]
                        },
                        "shape": {
                            "type": "circle",
                            "stroke": {
                                "width": 0,
                                "color": "#000000"
                            },
                            "polygon": {
                                "nb_sides": 5
                            }
                        },
                        "opacity": {
                            "value": 0.3,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 1,
                                "opacity_min": 0.1,
                                "sync": false
                            }
                        },
                        "size": {
                            "value": 3,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 2,
                                "size_min": 0.1,
                                "sync": false
                            }
                        },
                        "line_linked": {
                            "enable": true,
                            "distance": 150,
                            "color": "#0ea5e9",
                            "opacity": 0.2,
                            "width": 1
                        },
                        "move": {
                            "enable": true,
                            "speed": 1,
                            "direction": "none",
                            "random": true,
                            "straight": false,
                            "out_mode": "out",
                            "bounce": false,
                            "attract": {
                                "enable": true,
                                "rotateX": 600,
                                "rotateY": 1200
                            }
                        }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": {
                            "onhover": {
                                "enable": true,
                                "mode": "grab"
                            },
                            "onclick": {
                                "enable": true,
                                "mode": "push"
                            },
                            "resize": true
                        },
                        "modes": {
                            "grab": {
                                "distance": 140,
                                "line_linked": {
                                    "opacity": 0.5
                                }
                            },
                            "bubble": {
                                "distance": 400,
                                "size": 40,
                                "duration": 2,
                                "opacity": 8,
                                "speed": 3
                            },
                            "repulse": {
                                "distance": 200,
                                "duration": 0.4
                            },
                            "push": {
                                "particles_nb": 4
                            },
                            "remove": {
                                "particles_nb": 2
                            }
                        }
                    },
                    "retina_detect": true
                });
            }

            // Initialize GSAP animations
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);

                // Parallax effect for background elements
                gsap.utils.toArray('.parallax-bg').forEach(element => {
                    gsap.to(element, {
                        y: -80,
                        ease: "none",
                        scrollTrigger: {
                            trigger: element.parentElement,
                            start: "top bottom",
                            end: "bottom top",
                            scrub: true
                        }
                    });
                });

                // Staggered animations for features
                gsap.from('.card-hover', {
                    scrollTrigger: {
                        trigger: '.card-hover',
                        start: "top bottom-=100px",
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    stagger: 0.2,
                    ease: "power2.out"
                });

                // Stats counter animation
                const statsValues = document.querySelectorAll('.stats-value[data-count]');
                statsValues.forEach(stat => {
                    const finalValue = parseInt(stat.getAttribute('data-count'));

                    ScrollTrigger.create({
                        trigger: stat,
                        start: "top bottom-=100px",
                        onEnter: () => {
                            gsap.fromTo(stat,
                                { textContent: 0 },
                                {
                                    duration: 2,
                                    textContent: finalValue,
                                    ease: "power2.out",
                                    snap: { textContent: 1 },
                                    onUpdate: function() {
                                        stat.textContent = Math.floor(this.targets()[0].textContent).toLocaleString() + '+';
                                    }
                                }
                            );
                        },
                        once: true
                    });
                });
            }
        });
    </script>
</body>
</html>
