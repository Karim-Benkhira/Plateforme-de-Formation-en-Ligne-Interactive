@extends('layouts.app')

@section('title', 'About Us | BrightPath')

@section('content')
<div class="bg-gray-950 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="bg-blue-600 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2 text-white">About BrightPath</h1>
                    <p class="text-blue-100">Empowering learners through innovative education technology</p>
                </div>
            </div>
        </div>

        <!-- Our Story Section -->
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-10">
            <div class="md:flex">
                <div class="md:w-1/2 p-8">
                    <h2 class="text-2xl font-bold text-white mb-4">Our Story</h2>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        BrightPath was founded with a simple yet powerful vision: to make quality education accessible to everyone, everywhere.
                        We believe that learning should be engaging, interactive, and tailored to each student's unique needs.
                    </p>
                    <p class="text-gray-300 leading-relaxed">
                        Our platform combines cutting-edge technology with proven educational methodologies to create a learning experience
                        that is both effective and enjoyable. From AI-generated quizzes to secure exam monitoring, we're leveraging technology
                        to transform education.
                    </p>
                </div>
                <div class="md:w-1/2 bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center p-8">
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
        <div class="mb-10">
            <div class="flex items-center text-xl font-bold text-white mb-6">
                <i class="fas fa-heart mr-2 text-blue-500"></i> Our Core Values
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gray-800 rounded-lg p-6 transform transition-transform hover:scale-105 shadow-lg">
                    <div class="w-16 h-16 bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 text-center">Excellence</h3>
                    <p class="text-gray-400 text-center">We strive for excellence in everything we do, from course content to platform performance.</p>
                </div>

                <div class="bg-gray-800 rounded-lg p-6 transform transition-transform hover:scale-105 shadow-lg">
                    <div class="w-16 h-16 bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lightbulb text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 text-center">Innovation</h3>
                    <p class="text-gray-400 text-center">We embrace new technologies and methodologies to continuously improve the learning experience.</p>
                </div>

                <div class="bg-gray-800 rounded-lg p-6 transform transition-transform hover:scale-105 shadow-lg">
                    <div class="w-16 h-16 bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-balance-scale text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 text-center">Integrity</h3>
                    <p class="text-gray-400 text-center">We operate with honesty, transparency, and ethical standards in all our interactions.</p>
                </div>

                <div class="bg-gray-800 rounded-lg p-6 transform transition-transform hover:scale-105 shadow-lg">
                    <div class="w-16 h-16 bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2 text-center">Inclusivity</h3>
                    <p class="text-gray-400 text-center">We design our platform to be accessible to all learners, regardless of background or ability.</p>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mb-10">
            <div class="flex items-center text-xl font-bold text-white mb-6">
                <i class="fas fa-rocket mr-2 text-blue-500"></i> What Makes Us Different
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4">
                        <h3 class="text-lg font-bold text-white">Interactive Learning</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-400 mb-4">Our courses are designed to be engaging and interactive, with multimedia content and hands-on activities.</p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                                Video lectures and demonstrations
                            </li>
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                                Interactive quizzes and assessments
                            </li>
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                                Practical projects and assignments
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-4">
                        <h3 class="text-lg font-bold text-white">AI-Powered Learning</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-400 mb-4">We leverage artificial intelligence to enhance the learning experience and provide personalized support.</p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-purple-500 mr-2"></i>
                                AI-generated quizzes and assessments
                            </li>
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-purple-500 mr-2"></i>
                                Personalized learning paths
                            </li>
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-purple-500 mr-2"></i>
                                Intelligent progress tracking
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4">
                        <h3 class="text-lg font-bold text-white">Secure Assessment</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-400 mb-4">Our platform ensures academic integrity with advanced security features for exams and assessments.</p>
                        <ul class="space-y-2">
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                                Facial recognition for exam verification
                            </li>
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-purple-500 mr-2"></i>
                                Secure browser environment
                            </li>
                            <li class="flex items-center text-gray-400">
                                <i class="fas fa-check-circle text-blue-500 mr-2"></i>
                                Anti-cheating measures
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-8 text-center text-white mb-8">
            <h2 class="text-3xl font-bold mb-4">Ready to Start Learning?</h2>
            <p class="text-xl text-blue-100 mb-8">Join thousands of students who are already transforming their future with BrightPath.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i> Sign Up Now
                </a>
                <a href="{{ url('/courses') }}" class="bg-transparent border-2 border-white text-white hover:bg-white/10 font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                    <i class="fas fa-book mr-2"></i> Explore Courses
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
