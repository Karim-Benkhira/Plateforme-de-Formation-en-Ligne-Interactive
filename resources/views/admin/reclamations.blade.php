@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Reclamation Oversight</h2>
      <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white shadow">
          <thead>
            <tr>
              <th class="border-b-2 p-3 text-left text-blue-700">User</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Message</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Status</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Response</th>
              <th class="border-b-2 p-3 text-left text-blue-700">Actions</th>
            </tr>
          </thead>
          <tbody>
            @if($reclamations->isEmpty())
              <tr>
                <td colspan="5" class="p-3 text-center text-gray-500">No reclamations found.</td>
              </tr>
            @endif
            @foreach($reclamations as $reclamation)
              <tr class="{{ $loop->even ? 'bg-blue-50' : '' }}">
                <td class="p-3 font-semibold">{{ $reclamation->user->username ?? 'Unknown' }}</td>
                <td class="p-3">{{ $reclamation->message }}</td>
                <td class="p-3">
                  <span class="inline-block px-3 py-1 rounded-full text-white {{ $reclamation->status === 'resolved' ? 'bg-green-500' : 'bg-yellow-500' }}">
                    {{ $reclamation->status }}
                  </span>
                </td>
                <td class="p-3">{{ $reclamation->response ?? '-' }}</td>
                <td class="p-3">
                @if($reclamation->status !== 'resolved')
                  <a href="{{ route('admin.respondReclamation', $reclamation->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded transition">Respond</a>
                @else
                <p class="bg-gray-500 hover:bg-gray-700 cursor-not-allowed text-white font-bold py-1 px-2 rounded transition inline-block">Resolved</p>
                @endif
                <form action="{{ route('admin.deleteReclamation', $reclamation->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded transition" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>