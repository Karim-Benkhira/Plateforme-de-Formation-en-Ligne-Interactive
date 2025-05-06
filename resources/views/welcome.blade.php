<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Interactive online learning platform with course management, AI-generated quizzes, and facial recognition for secure exams">

        <title>{{ config('app.name', 'E-Learning Platform') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])

        <style>
            :root {
                --primary-color: #4361ee;
                --primary-dark: #3a56d4;
                --secondary-color: #7209b7;
                --accent-color: #f72585;
                --light-color: #f8f9fa;
                --dark-color: #212529;
                --gray-color: #6c757d;
                --success-color: #4cc9f0;
                --warning-color: #f9c74f;
                --danger-color: #f94144;
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Poppins', sans-serif;
                line-height: 1.6;
                color: var(--dark-color);
                background-color: var(--light-color);
            }

            a {
                text-decoration: none;
                color: inherit;
            }

            ul {
                list-style: none;
            }

            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem;
            }

            /* Header Styles */
            .header {
                background-color: #fff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                padding: 1rem 0;
            }

            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--primary-color);
                display: flex;
                align-items: center;
            }

            .logo i {
                margin-right: 0.5rem;
                font-size: 1.8rem;
            }

            .nav-links {
                display: flex;
                gap: 1.5rem;
            }

            .btn {
                display: inline-block;
                padding: 0.6rem 1.5rem;
                border-radius: 50px;
                font-weight: 500;
                text-align: center;
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .btn-primary {
                background-color: var(--primary-color);
                color: white;
                border: 2px solid var(--primary-color);
            }

            .btn-primary:hover {
                background-color: var(--primary-dark);
                border-color: var(--primary-dark);
            }

            .btn-outline {
                background-color: transparent;
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
            }

            .btn-outline:hover {
                background-color: var(--primary-color);
                color: white;
            }

            /* Hero Section */
            .hero {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                color: white;
                padding: 8rem 0 6rem;
                position: relative;
                overflow: hidden;
            }

            .hero-pattern {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.8;
            }

            .hero-content {
                position: relative;
                z-index: 1;
                text-align: center;
                max-width: 800px;
                margin: 0 auto;
            }

            .hero-title {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                line-height: 1.2;
            }

            .hero-subtitle {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }

            .hero-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-hero-primary {
                background-color: white;
                color: var(--primary-color);
                border: 2px solid white;
                font-weight: 600;
            }

            .btn-hero-primary:hover {
                background-color: rgba(255, 255, 255, 0.9);
                border-color: rgba(255, 255, 255, 0.9);
            }

            .btn-hero-secondary {
                background-color: transparent;
                color: white;
                border: 2px solid white;
                font-weight: 600;
            }

            .btn-hero-secondary:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            /* Features Section */
            .section {
                padding: 5rem 0;
            }

            .section-light {
                background-color: white;
            }

            .section-dark {
                background-color: #f8f9fa;
            }

            .section-title {
                text-align: center;
                margin-bottom: 3rem;
            }

            .section-title h2 {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--dark-color);
                margin-bottom: 1rem;
                position: relative;
                display: inline-block;
            }

            .section-title h2::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 50px;
                height: 3px;
                background-color: var(--primary-color);
            }

            .section-title p {
                font-size: 1.1rem;
                color: var(--gray-color);
                max-width: 600px;
                margin: 0 auto;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
            }

            .feature-card {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                padding: 2rem;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                text-align: center;
                position: relative;
                overflow: hidden;
                z-index: 1;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 0;
                background: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(114, 9, 183, 0.05) 100%);
                transition: height 0.3s ease;
                z-index: -1;
            }

            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            }

            .feature-card:hover::before {
                height: 100%;
            }

            .feature-icon {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                font-size: 1.8rem;
                position: relative;
            }

            .feature-icon::after {
                content: '';
                position: absolute;
                top: -5px;
                left: -5px;
                right: -5px;
                bottom: -5px;
                border-radius: 50%;
                border: 2px dashed;
                opacity: 0.3;
            }

            .feature-icon-1 {
                background-color: rgba(67, 97, 238, 0.1);
                color: var(--primary-color);
            }

            .feature-icon-1::after {
                border-color: var(--primary-color);
            }

            .feature-icon-2 {
                background-color: rgba(114, 9, 183, 0.1);
                color: var(--secondary-color);
            }

            .feature-icon-2::after {
                border-color: var(--secondary-color);
            }

            .feature-icon-3 {
                background-color: rgba(76, 201, 240, 0.1);
                color: var(--success-color);
            }

            .feature-icon-3::after {
                border-color: var(--success-color);
            }

            .feature-icon-4 {
                background-color: rgba(249, 199, 79, 0.1);
                color: var(--warning-color);
            }

            .feature-icon-4::after {
                border-color: var(--warning-color);
            }

            .feature-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: var(--dark-color);
            }

            .feature-description {
                color: var(--gray-color);
                font-size: 0.95rem;
            }

            /* Testimonials Section */
            .testimonials-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
            }

            .testimonial-card {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                padding: 2rem;
                position: relative;
            }

            .testimonial-card::before {
                content: '\201C';
                font-family: Georgia, serif;
                position: absolute;
                top: 10px;
                left: 20px;
                font-size: 5rem;
                color: rgba(67, 97, 238, 0.1);
                line-height: 1;
            }

            .testimonial-content {
                position: relative;
                z-index: 1;
            }

            .testimonial-text {
                font-style: italic;
                margin-bottom: 1.5rem;
                color: var(--gray-color);
            }

            .testimonial-author {
                display: flex;
                align-items: center;
            }

            .author-avatar {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                margin-right: 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                color: white;
            }

            .avatar-1 {
                background-color: var(--primary-color);
            }

            .avatar-2 {
                background-color: var(--secondary-color);
            }

            .avatar-3 {
                background-color: var(--success-color);
            }

            .author-info h4 {
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .author-info p {
                font-size: 0.85rem;
                color: var(--gray-color);
            }

            /* CTA Section */
            .cta-section {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
                color: white;
                padding: 5rem 0;
                text-align: center;
            }

            .cta-content {
                max-width: 700px;
                margin: 0 auto;
            }

            .cta-title {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .cta-subtitle {
                font-size: 1.1rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }

            /* Footer */
            .footer {
                background-color: var(--dark-color);
                color: white;
                padding: 4rem 0 2rem;
            }

            .footer-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
            }

            .footer-column h3 {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
                position: relative;
                padding-bottom: 0.5rem;
            }

            .footer-column h3::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 30px;
                height: 2px;
                background-color: var(--primary-color);
            }

            .footer-links li {
                margin-bottom: 0.75rem;
            }

            .footer-links a {
                color: rgba(255, 255, 255, 0.7);
                transition: color 0.3s ease;
            }

            .footer-links a:hover {
                color: white;
            }

            .footer-contact li {
                display: flex;
                margin-bottom: 1rem;
            }

            .footer-contact i {
                margin-right: 0.75rem;
                color: var(--primary-color);
            }

            .social-links {
                display: flex;
                gap: 1rem;
                margin-top: 1.5rem;
            }

            .social-links a {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
                transition: background-color 0.3s ease;
            }

            .social-links a:hover {
                background-color: var(--primary-color);
            }

            .footer-bottom {
                margin-top: 3rem;
                padding-top: 2rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                text-align: center;
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.9rem;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }

                .section-title h2 {
                    font-size: 2rem;
                }

                .cta-title {
                    font-size: 2rem;
                }
            }

            @media (max-width: 576px) {
                .hero-title {
                    font-size: 2rem;
                }

                .hero-subtitle {
                    font-size: 1rem;
                }

                .section-title h2 {
                    font-size: 1.75rem;
                }

                .cta-title {
                    font-size: 1.75rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header class="header">
            <div class="container header-container">
                <a href="{{ url('/') }}" class="logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>{{ config('app.name', 'Plateforme de Formation') }}</span>
                </a>
                <nav class="nav-links">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-pattern"></div>
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">Interactive Online Learning Platform</h1>
                    <p class="hero-subtitle">Learn in an innovative way with our platform that combines interactive education and advanced technology</p>
                    <div class="hero-buttons">
                        <a href="{{ route('courses.index') }}" class="btn btn-hero-primary">Explore Courses</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-hero-secondary">Register Now</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="section section-light">
            <div class="container">
                <div class="section-title">
                    <h2>Platform Features</h2>
                    <p>Discover the advanced features that make our platform unique</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon feature-icon-1">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="feature-title">Interactive Courses</h3>
                        <p class="feature-description">Interactive educational content that combines theory and practice for a comprehensive learning experience</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon feature-icon-2">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 class="feature-title">Smart Quizzes</h3>
                        <p class="feature-description">AI-generated quizzes that adapt to the student's level and provide immediate feedback</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon feature-icon-3">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3 class="feature-title">Secure Exams</h3>
                        <p class="feature-description">Facial recognition technology to ensure exam integrity and certificate reliability</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon feature-icon-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Progress Tracking</h3>
                        <p class="feature-description">Advanced tools to track student progress and analyze performance to improve the learning experience</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="section section-dark">
            <div class="container">
                <div class="section-title">
                    <h2>What Our Students Say</h2>
                    <p>Testimonials from students who have benefited from our educational platform</p>
                </div>
                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text">"The platform helped me understand complex concepts in an easy and enjoyable way. The smart quizzes were very useful in assessing my level."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar avatar-1">A</div>
                                <div class="author-info">
                                    <h4>Ahmed Mohamed</h4>
                                    <p>Engineering Student</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text">"I love the flexibility of learning on the platform. I can study anytime, anywhere, and the interactive content makes learning more enjoyable."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar avatar-2">S</div>
                                <div class="author-info">
                                    <h4>Sarah Ali</h4>
                                    <p>Medical Student</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p class="testimonial-text">"As a teacher, I find that the platform provides excellent tools for course management and tracking student progress. The facial recognition technology ensures exam integrity."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar avatar-3">M</div>
                                <div class="author-info">
                                    <h4>Michael Johnson</h4>
                                    <p>Teacher</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2 class="cta-title">Start Your Learning Journey Today</h2>
                    <p class="cta-subtitle">Join thousands of students who benefit from our advanced educational platform</p>
                    <div class="hero-buttons">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-hero-primary">Register for Free</a>
                        @endif
                        <a href="{{ route('courses.index') }}" class="btn btn-hero-secondary">Explore Courses</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-column">
                        <h3>{{ config('app.name', 'Plateforme de Formation') }}</h3>
                        <p>An interactive educational platform that combines modern education and advanced technology</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="footer-column">
                        <h3>Quick Links</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('courses.index') }}">Courses</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Teachers</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Support</h3>
                        <ul class="footer-links">
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Help</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Contact Us</h3>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>123 Knowledge Street, City</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>info@example.com</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>+123 456 7890</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Plateforme de Formation') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>