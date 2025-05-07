@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="max-w-xl mx-auto my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Respond to Reclamation</h2>
      <div class="mb-4">
        <div class="font-semibold text-gray-700">From: {{ $reclamation->user->username ?? 'Unknown' }}</div>
        <div class="text-gray-600 mt-2 mb-2">Message: {{ $reclamation->message }}</div>
        <div class="text-gray-500 text-sm mb-2">Status: {{ $reclamation->status }}</div>
      </div>
      <form action="{{ route('admin.submitReclamationResponse', $reclamation->id) }}" method="POST" class="space-y-6">
        @csrf
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Response</label>
          <textarea name="response" rows="4" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200">{{ old('response', $reclamation->response) }}</textarea>
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Send Response & Mark as Resolved
        </button>
      </form>
    </section>
  </main>
</body>