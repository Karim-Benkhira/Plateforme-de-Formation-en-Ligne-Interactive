<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Bright Path Learning Platform'); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('images/logo.svg')); ?>" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/theme-colors.css')); ?>" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
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
                        },
                    }
                }
            }
        }
    </script>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased text-gray-200 bg-gray-950">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="bg-gray-950 border-b border-gray-900 sticky top-0 z-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center">
                            <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="BrightPath Logo" class="h-10 w-10 mr-2">
                            <span class="text-blue-500 text-2xl font-bold">BrightPath</span>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center space-x-1">
                        <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150" href="/">Home</a>
                        <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150" href="/about">About</a>
                        <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150" href="/courses">Courses</a>

                        <?php if(auth()->guard()->check()): ?>
                            <div class="flex items-center space-x-2 ml-2">
                                <div class="relative group">
                                    <button class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-800 transition duration-150">
                                        <span class="mr-1"><?php echo e(Auth::user()->username); ?></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50 hidden group-hover:block border border-gray-700">
                                        <?php if(Auth::user()->role === 'admin'): ?>
                                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-blue-500">Dashboard</a>
                                        <?php elseif(Auth::user()->role === 'teacher'): ?>
                                            <a href="<?php echo e(route('teacher.dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-blue-500">Dashboard</a>
                                        <?php elseif(Auth::user()->role === 'user'): ?>
                                            <a href="<?php echo e(route('student.dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-blue-500">Dashboard</a>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="block">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-blue-500">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a class="px-4 py-2 rounded-md text-sm font-medium text-blue-500 border border-blue-500 hover:bg-blue-900 transition duration-150 ml-2" href="<?php echo e(route('login')); ?>">Login</a>
                            <a class="px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150" href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    </nav>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" type="button" class="text-gray-400 hover:text-blue-500 focus:outline-none focus:text-blue-500" aria-label="Toggle menu">
                            <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                                <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="fixed inset-0 z-50 hidden">
                <div class="absolute inset-0 bg-gray-900 opacity-75" id="mobile-menu-overlay"></div>
                <div class="absolute inset-y-0 right-0 max-w-xs w-full bg-gray-800 shadow-lg p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="BrightPath Logo" class="h-8 w-8 mr-2">
                            <span class="text-blue-500 text-xl font-bold">BrightPath</span>
                        </div>
                        <button id="close-mobile-menu" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 flex flex-col">
                        <a class="px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-700 transition duration-150 mb-1" href="/">Home</a>
                        <a class="px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-700 transition duration-150 mb-1" href="/about">About</a>
                        <a class="px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-700 transition duration-150 mb-1" href="/courses">Courses</a>

                        <?php if(auth()->guard()->check()): ?>
                            <div class="border-t border-gray-700 my-4"></div>
                            <div class="px-3 py-2">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-700 flex items-center justify-center mr-3">
                                        <span class="text-white font-bold"><?php echo e(substr(Auth::user()->username, 0, 1)); ?></span>
                                    </div>
                                    <div>
                                        <div class="text-white font-medium"><?php echo e(Auth::user()->username); ?></div>
                                        <div class="text-sm text-gray-400"><?php echo e(Auth::user()->email); ?></div>
                                    </div>
                                </div>

                                <?php if(Auth::user()->role === 'admin'): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-700 transition duration-150 mb-1">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                    </a>
                                <?php elseif(Auth::user()->role === 'teacher'): ?>
                                    <a href="<?php echo e(route('teacher.dashboard')); ?>" class="block px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-700 transition duration-150 mb-1">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i> Teacher Dashboard
                                    </a>
                                <?php elseif(Auth::user()->role === 'user'): ?>
                                    <a href="<?php echo e(route('student.dashboard')); ?>" class="block px-3 py-3 rounded-md text-base font-medium text-gray-300 hover:text-blue-500 hover:bg-gray-700 transition duration-150 mb-1">
                                        <i class="fas fa-user-graduate mr-2"></i> Student Dashboard
                                    </a>
                                <?php endif; ?>

                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left px-3 py-3 rounded-md text-base font-medium text-red-400 hover:text-red-300 hover:bg-gray-700 transition duration-150 mb-1">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="border-t border-gray-700 my-4"></div>
                            <a class="px-4 py-3 rounded-md text-base font-medium text-blue-500 border border-blue-500 hover:bg-blue-900 transition duration-150 mb-3 text-center" href="<?php echo e(route('login')); ?>">Login</a>
                            <a class="px-4 py-3 rounded-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150 text-center" href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-950 border-t border-gray-900 py-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center">
                            <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="BrightPath Logo" class="h-8 w-8 mr-2">
                            <span class="text-blue-500 text-xl font-bold">BrightPath</span>
                        </div>
                        <p class="text-gray-400 mt-2">&copy; <?php echo e(date('Y')); ?> BrightPath Learning Platform. All rights reserved.</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                        <div>
                            <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="/" class="text-gray-400 hover:text-blue-500 transition duration-150">Home</a></li>
                                <li><a href="/about" class="text-gray-400 hover:text-blue-500 transition duration-150">About</a></li>
                                <li><a href="/courses" class="text-gray-400 hover:text-blue-500 transition duration-150">Courses</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-4">Support</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">Help Center</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">Contact Us</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">Privacy Policy</a></li>
                            </ul>
                        </div>
                        <div class="col-span-2 md:col-span-1 mt-6 md:mt-0">
                            <h3 class="text-white font-semibold mb-4">Connect With Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">
                                    <i class="fab fa-facebook-f text-lg"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">
                                    <i class="fab fa-twitter text-lg"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">
                                    <i class="fab fa-instagram text-lg"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-150">
                                    <i class="fab fa-linkedin-in text-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMobileMenu = document.getElementById('close-mobile-menu');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

            if (mobileMenuButton && mobileMenu) {
                // Open mobile menu
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });

                // Close mobile menu
                const closeMenu = function() {
                    mobileMenu.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                };

                if (closeMobileMenu) {
                    closeMobileMenu.addEventListener('click', closeMenu);
                }

                if (mobileMenuOverlay) {
                    mobileMenuOverlay.addEventListener('click', closeMenu);
                }
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>