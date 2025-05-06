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

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- EduZone Theme CSS -->
        <link href="{{ asset('assets/eduzone/css/style.css') }}" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])


    </head>
    <body>
        <!-- Header -->
        <header class="header py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 col-6">
                        <a href="{{ url('/') }}" class="logo d-flex align-items-center text-decoration-none">
                            <img src="{{ asset('assets/eduzone/images/logo.png') }}" alt="Logo" class="me-2" style="height: 40px; width: auto;">
                            <span class="text-primary fw-bold">{{ config('app.name', 'Plateforme de Formation en Ligne Interactive') }}</span>
                        </a>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <nav class="main-nav">
                            <ul class="nav justify-content-center">
                                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Courses</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Teachers</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Testimonials</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-3 col-6 text-end">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-primary btn-sm">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-5" id="home" style="background: var(--gradient-bg);">
            <div class="container">
                <div class="row align-items-center py-5">
                    <div class="col-lg-6 text-white">
                        <h1 class="fw-bold mb-4">Interactive Online Learning Platform</h1>
                        <p class="lead mb-4">Learn in an innovative way with our platform that combines interactive education, AI-generated quizzes, and facial recognition for secure exams.</p>
                        <div class="d-flex gap-3 mb-5">
                            <a href="{{ route('courses.index') }}" class="btn btn-light px-4">Explore Courses</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-light px-4">Register Now</a>
                            @endif
                        </div>

                        <div class="row text-center mt-5">
                            <div class="col-4">
                                <h2 class="fw-bold">500</h2>
                                <p>Online Courses</p>
                            </div>
                            <div class="col-4">
                                <h2 class="fw-bold">1837</h2>
                                <p>Students</p>
                            </div>
                            <div class="col-4">
                                <h2 class="fw-bold">200</h2>
                                <p>Expert Instructors</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset('assets/eduzone/images/education-hero.png') }}" alt="Education Platform" class="img-fluid" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5 bg-white" id="features">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3">Platform Features</h2>
                    <p class="text-muted">Discover the advanced features that make our platform unique</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" alt="Interactive Courses" class="img-fluid" style="height: 80px; width: auto;">
                                </div>
                                <h5 class="card-title fw-bold">Interactive Courses</h5>
                                <p class="card-text text-muted">Interactive educational content that combines theory and practice for a comprehensive learning experience</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" alt="Smart Quizzes" class="img-fluid" style="height: 80px; width: auto;">
                                </div>
                                <h5 class="card-title fw-bold">Smart Quizzes</h5>
                                <p class="card-text text-muted">AI-generated quizzes that adapt to the student's level and provide immediate feedback</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" alt="Secure Exams" class="img-fluid" style="height: 80px; width: auto;">
                                </div>
                                <h5 class="card-title fw-bold">Secure Exams</h5>
                                <p class="card-text text-muted">Facial recognition technology to ensure exam integrity and certificate reliability</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 text-center h-100">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" alt="Progress Tracking" class="img-fluid" style="height: 80px; width: auto;">
                                </div>
                                <h5 class="card-title fw-bold">Progress Tracking</h5>
                                <p class="card-text text-muted">Advanced tools to track student progress and analyze performance to improve the learning experience</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-5 bg-light" id="testimonials">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3">What Our Students Say</h2>
                    <p class="text-muted">Testimonials from students who have benefited from our educational platform</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"The platform helped me understand complex concepts in an easy and enjoyable way. The smart quizzes were very useful in assessing my level."</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: #ff5a00; font-weight: 700;">
                                        A
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Ahmed Mohamed</h6>
                                        <small class="text-muted">Engineering Student</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"I love the flexibility of learning on the platform. I can study anytime, anywhere, and the interactive content makes learning more enjoyable."</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: #4361ee; font-weight: 700;">
                                        S
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Sarah Ali</h6>
                                        <small class="text-muted">Medical Student</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="mb-4">"As a teacher, I find that the platform provides excellent tools for course management and tracking student progress. The facial recognition technology ensures exam integrity."</p>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background-color: #36b37e; font-weight: 700;">
                                        M
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Michael Johnson</h6>
                                        <small class="text-muted">Teacher</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5" style="background: var(--gradient-bg);">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center text-white">
                        <h2 class="fw-bold mb-3">Start Your Learning Journey Today</h2>
                        <p class="mb-4">Join thousands of students who benefit from our advanced educational platform</p>
                        <div class="d-flex justify-content-center flex-wrap gap-3">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light px-4">Register for Free</a>
                            @endif
                            <a href="{{ route('courses.index') }}" class="btn btn-outline-light px-4">Explore Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Courses Section -->
        <section class="py-5 bg-white">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3">Popular Courses</h2>
                    <p class="text-muted">Explore our most popular courses chosen by thousands of students</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" class="card-img-top p-3" alt="Course Image">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-primary">Beginner</span>
                                    <span class="text-warning"><i class="fas fa-star"></i> 4.8 (120)</span>
                                </div>
                                <h5 class="card-title fw-bold">Introduction to Web Development</h5>
                                <p class="card-text text-muted">Learn the fundamentals of web development including HTML, CSS, and JavaScript.</p>
                            </div>
                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; background-color: #ff5a00; font-weight: 700;">
                                        J
                                    </div>
                                    <span>John Smith</span>
                                </div>
                                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">View Course</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" class="card-img-top p-3" alt="Course Image">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-success">Intermediate</span>
                                    <span class="text-warning"><i class="fas fa-star"></i> 4.9 (85)</span>
                                </div>
                                <h5 class="card-title fw-bold">Data Science Fundamentals</h5>
                                <p class="card-text text-muted">Master the basics of data analysis, visualization, and machine learning algorithms.</p>
                            </div>
                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; background-color: #4361ee; font-weight: 700;">
                                        E
                                    </div>
                                    <span>Emily Johnson</span>
                                </div>
                                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">View Course</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="{{ asset('assets/eduzone/images/education-hero.svg') }}" class="card-img-top p-3" alt="Course Image">
                            <div class="card-body pb-0">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-danger">Advanced</span>
                                    <span class="text-warning"><i class="fas fa-star"></i> 4.7 (95)</span>
                                </div>
                                <h5 class="card-title fw-bold">Artificial Intelligence & Machine Learning</h5>
                                <p class="card-text text-muted">Dive deep into AI concepts, neural networks, and practical machine learning applications.</p>
                            </div>
                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; background-color: #36b37e; font-weight: 700;">
                                        D
                                    </div>
                                    <span>David Chen</span>
                                </div>
                                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">View Course</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('courses.index') }}" class="btn btn-primary px-4">View All Courses</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white pt-5 pb-3" id="contact">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <a href="{{ url('/') }}" class="d-flex align-items-center text-white text-decoration-none mb-3">
                            <img src="{{ asset('assets/eduzone/images/logo.svg') }}" alt="Logo" class="me-2" style="height: 40px; width: auto; filter: brightness(0) invert(1);">
                            <span class="fw-bold">{{ config('app.name', 'Plateforme de Formation en Ligne Interactive') }}</span>
                        </a>
                        <p class="mb-4 text-muted">An interactive educational platform that combines modern education, AI-generated quizzes, and facial recognition for secure exams.</p>
                        <div class="d-flex gap-3 mb-4">
                            <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="fw-bold mb-4">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('courses.index') }}" class="text-muted text-decoration-none">Courses</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">About Us</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Teachers</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="fw-bold mb-4">Support</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Privacy Policy</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Terms of Use</a></li>
                            <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Help Center</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="fw-bold mb-4">Contact Us</h5>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-3 d-flex">
                                <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                                <span>123 Knowledge Street, City</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="fas fa-envelope me-3 mt-1"></i>
                                <span>info@example.com</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="fas fa-phone me-3 mt-1"></i>
                                <span>+123 456 7890</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4 opacity-25">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <p class="mb-0 text-muted">&copy; {{ date('Y') }} {{ config('app.name', 'Plateforme de Formation en Ligne Interactive') }}. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0 text-muted">Designed with <i class="fas fa-heart text-danger"></i> for education</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- EduZone Theme Scripts -->
        <script src="{{ asset('assets/eduzone/js/scripts.js') }}"></script>
    </body>
</html>