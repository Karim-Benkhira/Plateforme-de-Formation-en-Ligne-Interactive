<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Teacher Dashboard - Bright Path'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/theme-colors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/teacher-dashboard.css')); ?>" rel="stylesheet">
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
<body class="bg-gray-900 font-sans antialiased">
    <div class="teacher-dashboard min-h-screen">
        <!-- Header -->
        <header class="dashboard-header bg-gray-800 rounded-lg shadow-lg mb-6">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-3">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="dashboard-logo text-primary-400 text-2xl font-bold">
                            Bright Path
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="dashboard-nav hidden md:flex items-center space-x-6">
                        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="dashboard-nav-link <?php echo e(request()->routeIs('teacher.dashboard') ? 'active' : ''); ?>">Dashboard</a>
                        <a href="<?php echo e(route('teacher.courses')); ?>" class="dashboard-nav-link <?php echo e(request()->routeIs('teacher.courses*') ? 'active' : ''); ?>">Courses</a>
                        <a href="<?php echo e(route('teacher.quizzes')); ?>" class="dashboard-nav-link <?php echo e(request()->routeIs('teacher.quizzes*') ? 'active' : ''); ?>">Quizzes</a>
                        <a href="<?php echo e(route('teacher.analytics')); ?>" class="dashboard-nav-link <?php echo e(request()->routeIs('teacher.analytics*') ? 'active' : ''); ?>">Analytics</a>
                        <a href="<?php echo e(url('/about')); ?>" class="dashboard-nav-link">About</a>
                    </nav>

                    <!-- User Menu -->
                    <div class="flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-600 text-white">
                                    <?php echo e(substr(Auth::user()->username, 0, 1)); ?>

                                </span>
                                <span class="text-gray-300 hidden md:inline-block"><?php echo e(Auth::user()->username); ?></span>
                                <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Settings</a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-400 hover:text-white focus:outline-none" id="mobile-menu-button">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="<?php echo e(route('teacher.dashboard')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Dashboard</a>
                    <a href="<?php echo e(route('teacher.courses')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Courses</a>
                    <a href="<?php echo e(route('teacher.quizzes')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Quizzes</a>
                    <a href="<?php echo e(route('teacher.analytics')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Analytics</a>
                    <a href="<?php echo e(url('/about')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">About</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="mt-12 py-6 text-center text-gray-500 text-sm">
            <p>&copy; <?php echo e(date('Y')); ?> Bright Path Learning Platform. All rights reserved.</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/layouts/teacher.blade.php ENDPATH**/ ?>