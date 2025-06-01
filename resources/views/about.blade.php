@extends('layouts.teacher')

@section('title', 'About Us - Bright Path')

@push('styles')
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
    }
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    .about-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .about-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
        transform: translateY(-2px);
    }
    .value-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        padding: 2rem;
        transition: all 0.3s ease;
        text-align: center;
    }
    .value-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white rounded-full opacity-50"></div>
    </div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        <h1 class="text-5xl font-bold text-white mb-4 text-shadow">🌟 About Bright Path</h1>
        <p class="text-xl text-pink-100">Empowering learners through innovative education technology</p>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-6xl mx-auto">
    <!-- Mission & Vision Section -->
    <div class="about-card overflow-hidden mb-8">
        <div class="md:flex">
            <div class="md:w-1/2 p-8">
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-book-open mr-3 text-pink-400"></i> Our Story
                </h2>
                <p class="text-gray-300 mb-6 leading-relaxed text-lg">
                    Bright Path was founded with a simple yet powerful vision: to make quality education accessible to everyone, everywhere.
                    We believe that learning should be engaging, interactive, and tailored to each student's unique needs.
                </p>
                <p class="text-gray-300 leading-relaxed text-lg">
                    Our platform combines cutting-edge technology with proven educational methodologies to create a learning experience
                    that is both effective and enjoyable. From AI-generated quizzes to secure exam monitoring, we're leveraging technology
                    to transform education.
                </p>
            </div>
            <div class="md:w-1/2 gradient-pink-blue flex items-center justify-center p-8">
                <div class="text-center text-white">
                    <div class="mb-6">
                        <div class="w-20 h-20 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-lightbulb text-3xl text-yellow-300"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-shadow">🎯 Our Mission</h3>
                    <p class="text-pink-100 mb-8 text-lg">To empower learners of all backgrounds by providing accessible, engaging, and effective educational experiences.</p>
                    <h3 class="text-2xl font-bold mb-4 text-shadow">🚀 Our Vision</h3>
                    <p class="text-pink-100 text-lg">A world where quality education is a right, not a privilege, and where technology bridges gaps rather than creating them.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-white mb-4 flex items-center justify-center">
            <i class="fas fa-heart mr-3 text-pink-400"></i> Our Core Values
        </h2>
        <p class="text-gray-400 text-lg">The principles that guide everything we do</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="value-card card-hover">
            <div class="w-16 h-16 mx-auto mb-4 gradient-pink-blue rounded-full flex items-center justify-center">
                <i class="fas fa-star text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">✨ Excellence</h3>
            <p class="text-gray-300">We strive for excellence in everything we do, from course content to platform performance.</p>
        </div>

        <div class="value-card card-hover">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                <i class="fas fa-lightbulb text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">💡 Innovation</h3>
            <p class="text-gray-300">We embrace new technologies and methodologies to continuously improve the learning experience.</p>
        </div>

        <div class="value-card card-hover">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center">
                <i class="fas fa-balance-scale text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">⚖️ Integrity</h3>
            <p class="text-gray-300">We operate with honesty, transparency, and ethical standards in all our interactions.</p>
        </div>

        <div class="value-card card-hover">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-3">🤝 Inclusivity</h3>
            <p class="text-gray-300">We design our platform to be accessible to all learners, regardless of background or ability.</p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-white mb-4 flex items-center justify-center">
            <i class="fas fa-rocket mr-3 text-pink-400"></i> What Makes Us Different
        </h2>
        <p class="text-gray-400 text-lg">Innovative features that set us apart</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="about-card overflow-hidden card-hover">
            <div class="gradient-pink-blue p-6">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-play-circle mr-3"></i> Interactive Learning
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-300 mb-6 text-lg">Our courses are designed to be engaging and interactive, with multimedia content and hands-on activities.</p>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-pink-400 mr-3"></i>
                        Video lectures and demonstrations
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-pink-400 mr-3"></i>
                        Interactive quizzes and assessments
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-pink-400 mr-3"></i>
                        Practical projects and assignments
                    </li>
                </ul>
            </div>
        </div>

        <div class="about-card overflow-hidden card-hover">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-robot mr-3"></i> AI-Powered Learning
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-300 mb-6 text-lg">We leverage artificial intelligence to enhance the learning experience and provide personalized support.</p>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-purple-400 mr-3"></i>
                        AI-generated quizzes and assessments
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-purple-400 mr-3"></i>
                        Personalized learning paths
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-purple-400 mr-3"></i>
                        Intelligent progress tracking
                    </li>
                </ul>
            </div>
        </div>

        <div class="about-card overflow-hidden card-hover">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-shield-alt mr-3"></i> Secure Assessment
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-300 mb-6 text-lg">Our platform ensures academic integrity with advanced security features for exams and assessments.</p>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-emerald-400 mr-3"></i>
                        Facial recognition for exam verification
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-emerald-400 mr-3"></i>
                        Secure browser environment
                    </li>
                    <li class="flex items-center text-gray-300">
                        <i class="fas fa-check-circle text-emerald-400 mr-3"></i>
                        Anti-cheating measures
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
