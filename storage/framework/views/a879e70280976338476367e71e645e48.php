<body class="flex justify-center items-center h-screen bg-white">
<style>
    .SignUp-background {
      position: fixed;
      top: -100%;
      left: -100%;
      width: 300%;
      height: 300vh;
      background: conic-gradient(
        from 0deg,
        rgb(255, 255, 255),
        rgba(0, 204, 255, 0.3),
        rgb(255, 255, 255),
        rgba(0, 204, 255, 0.3),
        rgb(255, 255, 255),
        rgba(0, 204, 255, 0.3),
        rgb(255, 255, 255),
        rgba(0, 204, 255, 0.3),
        rgb(255, 255, 255)
      );
      animation: rotate-lights 8s linear infinite;
    }

    .SignUp-container {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
      padding: 2.5rem;
      border-radius: 16px;
      border: 2px solid rgba(0, 217, 255, 0.253);
      box-shadow: 0 0 50px rgba(0, 123, 255, 0.589), 0 0 30px rgba(0, 123, 255, 0.2);
      width: 400px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    @keyframes rotate-lights {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
  </style>
  <div class="SignUp-background"></div>
  <div class="SignUp-container">
    <h2 class="mb-6 text-2xl font-bold text-cyan-500">Welcome To Bright Path!</h2>
    <form action="<?php echo e(route('register')); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <input type="text" name="name" placeholder="Username" 
        value="<?php echo e(old('name')); ?>"
        class="w-full p-3 mb-4 border border-cyan-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
      <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-red-500 text-sm mb-4"><?php echo e($message); ?></p>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

      <input type="email" name="email" placeholder="Email" 
        value="<?php echo e(old('email')); ?>"
        class="w-full p-3 mb-4 border border-cyan-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-red-500 text-sm mb-4"><?php echo e($message); ?></p>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

      <input type="password" name="password" placeholder="Password" 
        class="w-full p-3 mb-4 border border-cyan-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
      <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-red-500 text-sm mb-4"><?php echo e($message); ?></p>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

      <input type="password" name="password_confirmation" placeholder="Confirm Password" 
        class="w-full p-3 mb-4 border border-cyan-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">

      <button class="w-full mt-6 p-3 bg-gradient-to-r from-cyan-400 to-teal-300 text-black font-bold rounded-md transition-transform transform hover:-translate-y-1 hover:shadow-lg">
        Sign Up
      </button>

      <?php if(session('error')): ?>
        <div class="mt-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md">
          <?php echo e(session('error')); ?>

        </div>
      <?php endif; ?>
      <p class="mt-6 text-gray-600">Already have an account? <a href="<?php echo e(route('login')); ?>" class="text-cyan-500 font-bold hover:underline">Login</a></p>
    </form>
  </div>
</body><?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/public/Auth/signup.blade.php ENDPATH**/ ?>