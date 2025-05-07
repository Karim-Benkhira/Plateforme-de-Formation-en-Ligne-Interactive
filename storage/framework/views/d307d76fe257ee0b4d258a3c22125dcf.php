  <!-- Header -->
  <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- Main Content -->
  <main class="container mx-auto p-4">
    <!-- Hero Section -->
    <section class="bg-white rounded-lg shadow p-8 text-center my-8 relative overflow-hidden">
      <h2 class="text-3xl text-blue-500 font-bold mb-4">Welcome to BrightPath</h2>
      <p class="text-lg text-gray-600 mb-6">
        Empowering learners with modern, interactive, and accessible education.
      </p>
      <button onclick="window.location.href='courses.html'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Explore Courses
      </button>
    </section>

    <!-- Features -->
    <section class="grid md:grid-cols-3 gap-6 my-8">
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="text-xl text-blue-500 font-semibold mb-2">Interactive Lessons</h3>
        <p class="text-gray-600">Engage with hands-on lessons and real-world projects.</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="text-xl text-blue-500 font-semibold mb-2">Expert Instructors</h3>
        <p class="text-gray-600">Learn from industry professionals with years of experience.</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="text-xl text-blue-500 font-semibold mb-2">Flexible Learning</h3>
        <p class="text-gray-600">Study at your own pace, anytime, anywhere.</p>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-gray-50 rounded-lg shadow p-8 text-center my-8">
      <h2 class="text-2xl text-blue-500 font-bold mb-4">What Our Students Say</h2>
      <div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
        <p class="text-gray-600 italic">
          "BrightPath has transformed the way I learn. The courses are engaging and practical!"
        </p>
        <span class="block mt-4 text-blue-500 font-semibold">- John Doe</span>
      </div>
    </section>
  </main>
</body>

<?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/public/welcome.blade.php ENDPATH**/ ?>