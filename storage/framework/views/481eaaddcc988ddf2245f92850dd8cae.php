<footer class="bg-gray-900 pt-12 pb-8 relative overflow-hidden border-t border-gray-800">
  <!-- Newsletter Subscription -->
  <div class="container mx-auto px-4 relative z-10">
    <div class="max-w-5xl mx-auto mb-12 bg-gray-800 rounded-lg p-6 shadow-md border border-gray-700">
      <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/2 mb-6 md:mb-0 md:pr-8">
          <h3 class="text-xl font-bold text-white mb-2">Subscribe to Our Newsletter</h3>
          <p class="text-gray-300">Stay updated with the latest educational content, features, and tips.</p>
        </div>
        <div class="md:w-1/2 w-full">
          <form class="flex">
            <input type="email" placeholder="Your email address" class="flex-grow px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="submit" class="ml-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300">
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="grid md:grid-cols-4 gap-8 mb-8">
      <!-- Column 1: Logo and About -->
      <div>
        <div class="flex items-center mb-4">
          <div class="mr-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
              </svg>
            </div>
          </div>
          <div>
            <div class="text-blue-500 text-xl font-bold">BrightPath</div>
            <div class="text-xs text-gray-400">Interactive Learning Platform</div>
          </div>
        </div>
        <p class="text-gray-300 mb-6">
          Empowering learners with modern, interactive, and accessible education through AI-powered tools and secure exam environments.
        </p>
        <div class="flex space-x-3">
          <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors duration-300">
            <i class="fab fa-twitter text-sm"></i>
          </a>
          <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors duration-300">
            <i class="fab fa-instagram text-sm"></i>
          </a>
          <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors duration-300">
            <i class="fab fa-linkedin-in text-sm"></i>
          </a>
          <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors duration-300">
            <i class="fab fa-youtube text-sm"></i>
          </a>
        </div>
      </div>

      <!-- Column 2: Quick Links -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">
          Quick Links
        </h3>
        <ul class="space-y-2">
          <li>
            <a href="/" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs text-blue-500 mr-2"></i>
              Home
            </a>
          </li>
          <li>
            <a href="/about" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs text-blue-500 mr-2"></i>
              About Us
            </a>
          </li>
          <li>
            <a href="/courses" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs text-blue-500 mr-2"></i>
              Courses
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('login')); ?>" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs text-blue-500 mr-2"></i>
              Login
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('register')); ?>" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-chevron-right text-xs text-blue-500 mr-2"></i>
              Register
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 3: Features -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">
          Features
        </h3>
        <ul class="space-y-2">
          <li>
            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-bolt text-xs text-blue-500 mr-2"></i>
              AI-Generated Quizzes
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-shield-alt text-xs text-blue-500 mr-2"></i>
              Secure Exam Environment
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-users text-xs text-blue-500 mr-2"></i>
              Interactive Learning
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-chart-line text-xs text-blue-500 mr-2"></i>
              Progress Tracking
            </a>
          </li>
          <li>
            <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors duration-300">
              <i class="fas fa-certificate text-xs text-blue-500 mr-2"></i>
              Certifications
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 4: Contact Us -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">
          Contact Us
        </h3>
        <ul class="space-y-3">
          <li>
            <div class="flex items-start">
              <i class="fas fa-map-marker-alt text-blue-500 mt-1 mr-3"></i>
              <div>
                <p class="text-white font-medium">Our Location</p>
                <p class="text-gray-400 text-sm">123 Education St, Learning City</p>
              </div>
            </div>
          </li>
          <li>
            <div class="flex items-start">
              <i class="fas fa-phone text-blue-500 mt-1 mr-3"></i>
              <div>
                <p class="text-white font-medium">Phone Number</p>
                <p class="text-gray-400 text-sm">+1 234 567 8900</p>
              </div>
            </div>
          </li>
          <li>
            <div class="flex items-start">
              <i class="fas fa-envelope text-blue-500 mt-1 mr-3"></i>
              <div>
                <p class="text-white font-medium">Email Address</p>
                <p class="text-gray-400 text-sm">contact@brightpath.com</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Trust Badges -->
    <div class="flex flex-wrap justify-center items-center gap-8 py-6 border-t border-gray-200 mb-6">
      <div class="flex items-center text-gray-600">
        <i class="fas fa-shield-alt text-green-500 mr-2"></i>
        <span>Secure Platform</span>
      </div>
      <div class="flex items-center text-gray-600">
        <i class="fas fa-certificate text-blue-500 mr-2"></i>
        <span>Certified Courses</span>
      </div>
      <div class="flex items-center text-gray-600">
        <i class="fas fa-headset text-purple-500 mr-2"></i>
        <span>Fast Support</span>
      </div>
      <div class="flex items-center text-gray-600">
        <i class="fas fa-clock text-yellow-500 mr-2"></i>
        <span>24/7 Access</span>
      </div>
    </div>

    <!-- Copyright and Legal -->
    <div class="pt-6 border-t border-gray-200 text-center">
      <div class="flex flex-wrap justify-center gap-4 mb-4">
        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Terms of Service</a>
        <span class="text-gray-300">|</span>
        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Privacy Policy</a>
        <span class="text-gray-300">|</span>
        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Cookie Policy</a>
        <span class="text-gray-300">|</span>
        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm">Accessibility</a>
      </div>
      <p class="text-gray-600 mb-2">
        &copy; 2025 <span class="text-blue-600 font-semibold">BrightPath</span> Learning Platform. All rights reserved.
      </p>
      <p class="text-gray-500 text-xs">
        Designed with <span class="text-red-500">♥</span> for a better learning experience
      </p>
    </div>
  </div>
</footer><?php /**PATH /var/www/resources/views/components/footer.blade.php ENDPATH**/ ?>