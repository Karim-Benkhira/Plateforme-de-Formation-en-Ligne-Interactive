@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12">
      <h2 class="text-4xl text-blue-600 font-extrabold mb-10 text-center drop-shadow">Agent Dashboard</h2>
      <div class="bg-white rounded-xl shadow-lg p-8 text-center border-l-4 border-blue-400 max-w-3xl mx-auto mb-12">
        <h3 class="text-2xl text-blue-500 font-bold mb-6">Reclamations Overview</h3>
        <div class="flex flex-col md:flex-row justify-center gap-32">
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold text-blue-600">{{ $totalReclamations }}</span>
            <span class="text-gray-700">Total</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold text-yellow-600">{{ $unresolvedReclamations }}</span>
            <span class="text-gray-700">Unresolved</span>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-2xl font-bold text-green-600">{{ $resolvedReclamations }}</span>
            <span class="text-gray-700">Resolved</span>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-8 max-w-3xl mx-auto">
        <h3 class="text-2xl text-blue-600 font-bold mb-6 text-center">Top 10 Users Leaderboard</h3>
        <div class="overflow-x-auto">
          <table class="w-full border-collapse bg-white shadow">
            <thead>
              <tr>
                <th class="border-b-2 p-3 text-left text-blue-700">Rank</th>
                <th class="border-b-2 p-3 text-left text-blue-700">Name</th>
                <th class="border-b-2 p-3 text-left text-blue-700">Total Score</th>
                <th class="border-b-2 p-3 text-left text-blue-700">Quizzes Taken</th>
              </tr>
            </thead>
            <tbody>
              @foreach($leaders as $index => $user)
                <tr class="{{ $index % 2 === 0 ? 'bg-blue-50' : '' }}">
                  <td class="p-3 font-bold text-blue-500">{{ $index + 1 }}</td>
                  <td class="p-3 font-semibold">{{ $user->username }}</td>
                  <td class="p-3">
                    <span class="inline-block bg-blue-500 text-white px-4 py-1 rounded-full font-bold shadow">{{ $user->total_score }}</span>
                  </td>
                  <td class="p-3">{{ $user->quizzes_count }}</td>
                </tr>
              @endforeach
              @if($leaders->isEmpty())
                <tr>
                  <td colspan="4" class="p-4 text-center text-gray-500">No leaderboard data available.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>
</body>