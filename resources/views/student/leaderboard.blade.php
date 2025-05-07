<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  @include('components.header')
  <main class="container mx-auto p-4 flex-grow">
    <section class="bg-white rounded-xl shadow-lg p-10 my-12 max-w-3xl mx-auto">
      <h2 class="text-3xl text-blue-600 font-extrabold text-center mb-8 drop-shadow">Leaderboard</h2>
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
          @if(count($leaders) > 0)
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
          @else
            <tr>
              <td colspan="4" class="p-4 text-center text-gray-500">No leaderboard data available.</td>
            </tr>
          @endif
        </tbody>
      </table>
    </section>
  </main>
</body>