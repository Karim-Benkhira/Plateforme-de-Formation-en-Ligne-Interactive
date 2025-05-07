@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Manage Users</h2>

      <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow">
          <thead>
            <tr>
              <th class="border-b-2 p-3 text-left text-blue-700">ID</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Name</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Email</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Role</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr class="{{ $loop->even ? 'bg-blue-50' : '' }}">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3">{{ $user->username }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ ucfirst($user->role) }}</td>
                <td class="p-3">
                  @if($user->id == 1)
                    <span class="text-xs text-yellow-700 font-semibold bg-yellow-100 px-2 py-1 rounded">Can't change owner's role</span>
                  @else
                    <form action="{{ route('admin.updateRole', $user->id) }}" method="POST" class="inline">
                      @csrf
                      @method('PUT')
                      <select name="role" class="border rounded px-2 py-1">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agent</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                      </select>
                      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded transition">Update</button>
                    </form>
                  @endif

                  @if($user->role === 'admin')
                    <span class="text-xs text-red-700 font-semibold bg-red-100 px-2 py-1 rounded ml-2">Can't ban admin</span>
                  @else
                    @if($user->is_banned)
                      <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST" class="inline ml-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded transition">Unban</button>
                      </form>
                    @else
                      <form action="{{ route('admin.banUser', $user->id) }}" method="POST" class="inline ml-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded transition">Ban</button>
                      </form>
                    @endif
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>