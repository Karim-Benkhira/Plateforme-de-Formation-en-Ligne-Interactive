@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 flex flex-col md:flex-row gap-8 justify-center items-start">
      <!-- Edit Profile Form -->
      <div class="flex-1 max-w-md bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Edit Profile</h2>
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any() && !old('old_password'))
          <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif
        <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-6">
          @csrf
          <div>
            <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
            <input type="text" name="username" placeholder="Full Name" value="{{ old('username', $user->username) }}" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
          </div>
          <div>
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
          </div>
          <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
            Update Profile
          </button>
        </form>
      </div>

      <!-- Update Password Form -->
      <div class="flex-1 max-w-md bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Change Password</h2>
        @if($errors->any() && old('old_password'))
          <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            @foreach($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        @endif
        @if(session('password_success'))
          <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('password_success') }}</div>
        @endif
        <form action="{{ route('student.profile.password') }}" method="POST" class="space-y-6">
          @csrf
          <div>
            <label class="block text-gray-700 font-semibold mb-2">Old Password</label>
            <input type="password" name="old_password" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
          </div>
          <div>
            <label class="block text-gray-700 font-semibold mb-2">New Password</label>
            <input type="password" name="new_password" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
          </div>
          <div>
            <label class="block text-gray-700 font-semibold mb-2">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
          </div>
          <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
            Update Password
          </button>
        </form>
      </div>
    </section>
  </main>
</body>