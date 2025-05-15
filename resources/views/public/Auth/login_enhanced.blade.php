<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrightPath</title>
    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.11.4/dist/gsap.min.js"></script>
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
            position: relative;
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

        .bg-grid-pattern {
            background-image: 
                linear-gradient(rgba(15, 23, 42, 0.8) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, 0.8) 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: center center;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .login-content {
            position: relative;
            z-index: 2;
        }

        .input-field {
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .input-field::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(139, 92, 246, 0.1));
            z-index: -1;
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .input-field:focus-within::before {
            transform: translateY(0);
        }

        .input-icon {
            transition: all 0.3s ease;
        }

        .input-field:focus-within .input-icon {
            color: #38bdf8;
            transform: scale(1.1);
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 overflow-hidden">
    <!-- Particles Background -->
    <div id="particles-js" class="absolute inset-0 z-0"></div>
    
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-1000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-900 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob delay-2000"></div>

        <!-- Morphing Shapes -->
        <div class="absolute top-1/4 left-1/4 w-32 h-32 morphing-shape opacity-10 animate-float-up-down"></div>
        <div class="absolute bottom-1/4 right-1/4 w-24 h-24 morphing-shape opacity-10 animate-float-rotate" style="animation-delay: 1s;"></div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        
        <!-- Light Rays Effect -->
        <div class="absolute inset-0 overflow-hidden opacity-10">
            <div class="absolute -inset-[10%] rotate-45 bg-gradient-to-r from-transparent via-blue-500 to-transparent blur-3xl transform translate-x-full animate-shimmer"></div>
            <div class="absolute -inset-[10%] -rotate-45 bg-gradient-to-r from-transparent via-purple-500 to-transparent blur-3xl transform -translate-x-full animate-shimmer" style="animation-delay: 1s;"></div>
        </div>
    </div>

    <div class="relative z-10 w-full max-w-md px-4 login-content">
        <div class="glass-effect rounded-xl shadow-2xl overflow-hidden border border-gray-700 animate-fade-in">
            <div class="p-8">
                <div class="text-center mb-8 animate-scale-in">
                    <a href="/" class="inline-flex items-center justify-center mb-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="BrightPath Logo" class="h-12 w-12 mr-2 glow-effect">
                        <span class="text-2xl font-bold gradient-text">BrightPath</span>
                    </a>
                    <h1 class="text-3xl font-bold text-white mt-2">Welcome Back</h1>
                    <p class="text-gray-400 mt-2">Sign in to your account to continue</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                        <div class="relative input-field">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-500 input-icon"></i>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                class="w-full pl-10 pr-3 py-3 bg-gray-700/70 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror"
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
                            <a href="#" class="text-sm text-blue-400 hover:text-blue-300 transition-all duration-300">Forgot password?</a>
                        </div>
                        <div class="relative input-field">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-500 input-icon"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                class="w-full pl-10 pr-3 py-3 bg-gray-700/70 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror"
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
                            class="btn-3d w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </div>

                    @if (session('success'))
                        <div class="p-4 bg-green-900 bg-opacity-40 border border-green-700 text-green-300 rounded-lg flex items-start animate-fade-in">
                            <i class="fas fa-check-circle text-green-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Success!</h4>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('logout_success'))
                        <div class="p-4 bg-blue-900 bg-opacity-40 border border-blue-700 text-blue-300 rounded-lg flex items-start animate-fade-in">
                            <i class="fas fa-sign-out-alt text-blue-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Logged Out</h4>
                                <p>{{ session('logout_success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 bg-red-900 bg-opacity-40 border border-red-700 text-red-300 rounded-lg flex items-start animate-fade-in">
                            <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Error</h4>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="p-4 bg-red-900 bg-opacity-40 border border-red-700 text-red-300 rounded-lg animate-fade-in">
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

            <div class="py-4 px-8 bg-gray-900/80 border-t border-gray-700">
                <p class="text-center text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium transition-all duration-300">
                        Create an account
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                            "push": {
                                "particles_nb": 4
                            }
                        }
                    },
                    "retina_detect": true
                });
            }
        });
    </script>
</body>
</html>
