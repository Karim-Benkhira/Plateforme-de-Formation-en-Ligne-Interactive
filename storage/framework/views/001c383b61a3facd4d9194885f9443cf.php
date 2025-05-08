  <!-- Header -->
  <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- Main Content -->
  <div class="bg-gradient-to-b from-blue-50 to-white">
    <!-- Hero Section -->
    <section class="relative overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute inset-0 z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-cyan-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
      </div>

      <!-- Hero Content -->
      <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
          <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-extrabold text-blue-600 leading-tight mb-4">
              Transform Your Learning Experience
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-lg">
              BrightPath offers an interactive learning platform with AI-generated quizzes and secure exam environments powered by facial recognition.
            </p>
            <div class="flex flex-wrap gap-4">
              <a href="/courses" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 transform hover:-translate-y-1">
                Explore Courses
              </a>
              <a href="/register" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-md border border-blue-200 hover:bg-blue-50 transition duration-300 transform hover:-translate-y-1">
                Join Now
              </a>
            </div>
          </div>
          <div class="md:w-1/2">
            <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Online Learning" class="rounded-xl shadow-2xl transform -rotate-2 hover:rotate-0 transition duration-500">
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-16">Innovative Learning Features</h2>

        <div class="grid md:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-blue-500 hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">AI-Generated Quizzes</h3>
            <p class="text-gray-600 text-center">
              Our platform uses advanced AI to automatically generate relevant quizzes from course content, providing personalized learning experiences.
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-blue-500 hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">Secure Exam Environment</h3>
            <p class="text-gray-600 text-center">
              Take exams with confidence using our facial recognition technology that ensures academic integrity and prevents fraud.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="bg-white rounded-xl shadow-lg p-8 border-t-4 border-blue-500 hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">Detailed Analytics</h3>
            <p class="text-gray-600 text-center">
              Track your progress with comprehensive analytics and personalized insights to optimize your learning journey.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-blue-50">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-16">How BrightPath Works</h2>

        <div class="grid md:grid-cols-4 gap-8">
          <!-- Step 1 -->
          <div class="flex flex-col items-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">1</div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">Register</h3>
            <p class="text-gray-600 text-center">Create your account and set up your learning profile.</p>
          </div>

          <!-- Step 2 -->
          <div class="flex flex-col items-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">2</div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">Explore Courses</h3>
            <p class="text-gray-600 text-center">Browse our extensive catalog of courses in various subjects.</p>
          </div>

          <!-- Step 3 -->
          <div class="flex flex-col items-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">3</div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">Learn & Practice</h3>
            <p class="text-gray-600 text-center">Engage with course materials and test your knowledge with AI-generated quizzes.</p>
          </div>

          <!-- Step 4 -->
          <div class="flex flex-col items-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">4</div>
            <h3 class="text-xl font-semibold text-center text-blue-600 mb-3">Get Certified</h3>
            <p class="text-gray-600 text-center">Complete secure exams and earn certificates to showcase your skills.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-16">What Our Students Say</h2>

        <div class="grid md:grid-cols-3 gap-8">
          <!-- Testimonial 1 -->
          <div class="bg-white rounded-xl shadow-lg p-8 relative">
            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
              </div>
            </div>
            <p class="text-gray-600 italic mb-6 mt-4">
              "BrightPath's AI-generated quizzes helped me identify my weak areas and focus my studies effectively. The platform is intuitive and engaging!"
            </p>
            <div class="flex items-center">
              <div class="w-12 h-12 bg-blue-100 rounded-full mr-4"></div>
              <div>
                <h4 class="font-semibold text-blue-600">Sarah Johnson</h4>
                <p class="text-gray-500 text-sm">Computer Science Student</p>
              </div>
            </div>
          </div>

          <!-- Testimonial 2 -->
          <div class="bg-white rounded-xl shadow-lg p-8 relative">
            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
              </div>
            </div>
            <p class="text-gray-600 italic mb-6 mt-4">
              "As an instructor, I appreciate the secure exam environment. The facial recognition feature ensures academic integrity while providing a seamless experience for students."
            </p>
            <div class="flex items-center">
              <div class="w-12 h-12 bg-blue-100 rounded-full mr-4"></div>
              <div>
                <h4 class="font-semibold text-blue-600">Dr. Michael Chen</h4>
                <p class="text-gray-500 text-sm">Professor of Mathematics</p>
              </div>
            </div>
          </div>

          <!-- Testimonial 3 -->
          <div class="bg-white rounded-xl shadow-lg p-8 relative">
            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
              </div>
            </div>
            <p class="text-gray-600 italic mb-6 mt-4">
              "The detailed analytics have transformed how I approach my studies. I can see my progress in real-time and focus on areas where I need improvement."
            </p>
            <div class="flex items-center">
              <div class="w-12 h-12 bg-blue-100 rounded-full mr-4"></div>
              <div>
                <h4 class="font-semibold text-blue-600">Alex Rodriguez</h4>
                <p class="text-gray-500 text-sm">Business Administration Student</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Ready to Transform Your Learning Experience?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
          Join thousands of students who are already benefiting from our innovative learning platform.
        </p>
        <a href="/register" class="px-8 py-4 bg-white text-blue-600 font-bold rounded-lg shadow-lg hover:bg-blue-50 transition duration-300 transform hover:-translate-y-1 inline-block">
          Get Started Today
        </a>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/public/welcome.blade.php ENDPATH**/ ?>