<body class="bg-gray-100 text-gray-800">
  <!-- Header -->
  <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <!-- Main Content -->
  <main class="container mx-auto p-4 ">
    <section class="bg-white rounded-lg shadow p-8 text-center my-8">
      <h2 class="text-3xl text-blue-500 font-bold mb-4">About Us</h2>
      <p class="text-lg text-gray-600 mb-4">
        BrightPath is dedicated to providing quality online education with interactive courses and real-world projects.
      </p>
    </section>
    <section class="grid md:grid-cols-3 gap-6 my-8">
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="text-xl text-blue-500 font-semibold mb-2">Our Mission</h3>
        <p class="text-gray-600">Making learning accessible and engaging for everyone.</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="text-xl text-blue-500 font-semibold mb-2">Our Vision</h3>
        <p class="text-gray-600">Empowering learners to reach their full potential.</p>
      </div>
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <h3 class="text-xl text-blue-500 font-semibold mb-2">Our Values</h3>
        <p class="text-gray-600">Quality, Innovation, Integrity, and Inclusivity.</p>
      </div>
    </section>
  </main>
</body><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/public/about.blade.php ENDPATH**/ ?>