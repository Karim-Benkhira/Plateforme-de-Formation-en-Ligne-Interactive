<body class="flex justify-center items-center h-screen bg-white">
<style>
    .LogIn-background {
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

    .LogIn-container {
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

  <div class="LogIn-background"></div>
  <div class="LogIn-container">
    <form action="{{ route('login') }}" method="POST">
      @csrf
      <h2 class="mb-6 text-2xl font-bold text-cyan-500">Welcome To Bright Path!</h2>
      <input type="email" name="email" placeholder="Email" 
        value="{{ old('email') }}"
        class="w-full p-3 mb-4 border border-cyan-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 @error('email') border-red-500 @enderror">
      @error('email')
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
      @enderror
      <input type="password" name="password" placeholder="Password" 
        class="w-full p-3 mb-4 border border-cyan-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 @error('password') border-red-500 @enderror">
      @error('password')
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
      @enderror
      <div class="flex items-center mb-4">
        <input type="checkbox" name="remember" id="remember" class="mr-2">
        <label for="remember" class="text-gray-600">Remember me</label>
      </div>
      <button class="w-full p-3 bg-gradient-to-r from-cyan-400 to-teal-300 text-black font-bold rounded-md transition-transform transform hover:-translate-y-1 hover:shadow-lg">
        Login
      </button>
      @if (session('success'))
      <div class="mt-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded-md">
        {{ session('success') }}
      </div>
      @endif
      @if (session('error'))
      <div class="mt-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md">
        {{ session('error') }}
      </div>
      @endif
      <p class="mt-6 text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-cyan-500 font-bold hover:underline">Register</a></p>
    </form>
  </div>
</body>