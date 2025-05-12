@extends('layouts.teacher')

@section('title', 'About Us - Bright Path')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl font-bold text-white mb-2">About Bright Path</h1>
            <p class="text-xl text-blue-100">Empowering learners through innovative education technology</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto">
    <!-- Mission & Vision Section -->
    <div class="max-w-6xl mx-auto">
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="md:flex">
                <div class="md:w-1/2 p-8">
                    <h2 class="text-2xl font-bold text-white mb-4">Our Story</h2>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        Bright Path was founded with a simple yet powerful vision: to make quality education accessible to everyone, everywhere.
                        We believe that learning should be engaging, interactive, and tailored to each student's unique needs.
                    </p>
                    <p class="text-gray-300 leading-relaxed">
                        Our platform combines cutting-edge technology with proven educational methodologies to create a learning experience
                        that is both effective and enjoyable. From AI-generated quizzes to secure exam monitoring, we're leveraging technology
                        to transform education.
                    </p>
                </div>
                <div class="md:w-1/2 bg-gradient-to-br from-primary-600 to-secondary-600 flex items-center justify-center p-8">
                    <div class="text-center text-white">
                        <div class="mb-4">
                            <i class="fas fa-lightbulb text-5xl text-yellow-300"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Our Mission</h3>
                        <p class="text-blue-100 mb-6">To empower learners of all backgrounds by providing accessible, engaging, and effective educational experiences.</p>
                        <h3 class="text-xl font-bold mb-3">Our Vision</h3>
                        <p class="text-blue-100">A world where quality education is a right, not a privilege, and where technology bridges gaps rather than creating them.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Our Core Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl shadow-lg p-6 transform transition-transform hover:scale-105">
                <div class="bg-primary-900/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-primary-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2 text-center">Excellence</h3>
                <p class="text-gray-400 text-center">We strive for excellence in everything we do, from course content to platform performance.</p>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg p-6 transform transition-transform hover:scale-105">
                <div class="bg-secondary-900/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-secondary-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2 text-center">Innovation</h3>
                <p class="text-gray-400 text-center">We embrace new technologies and methodologies to continuously improve the learning experience.</p>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg p-6 transform transition-transform hover:scale-105">
                <div class="bg-primary-900/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-balance-scale text-primary-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2 text-center">Integrity</h3>
                <p class="text-gray-400 text-center">We operate with honesty, transparency, and ethical standards in all our interactions.</p>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg p-6 transform transition-transform hover:scale-105">
                <div class="bg-secondary-900/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-secondary-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2 text-center">Inclusivity</h3>
                <p class="text-gray-400 text-center">We design our platform to be accessible to all learners, regardless of background or ability.</p>
            </div>
        </div>

        <!-- Features Section -->
        <h2 class="text-2xl font-bold text-white mb-6 text-center">What Makes Us Different</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 p-4">
                    <h3 class="text-lg font-bold text-white">Interactive Learning</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-400 mb-4">Our courses are designed to be engaging and interactive, with multimedia content and hands-on activities.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                            Video lectures and demonstrations
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                            Interactive quizzes and assessments
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                            Practical projects and assignments
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-600 to-secondary-700 p-4">
                    <h3 class="text-lg font-bold text-white">AI-Powered Learning</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-400 mb-4">We leverage artificial intelligence to enhance the learning experience and provide personalized support.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                            AI-generated quizzes and assessments
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                            Personalized learning paths
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                            Intelligent progress tracking
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-primary-600 to-secondary-600 p-4">
                    <h3 class="text-lg font-bold text-white">Secure Assessment</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-400 mb-4">Our platform ensures academic integrity with advanced security features for exams and assessments.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                            Facial recognition for exam verification
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                            Secure browser environment
                        </li>
                        <li class="flex items-center text-gray-400">
                            <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                            Anti-cheating measures
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
