<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  @include('components.header')
  <main class="container mx-auto p-4 flex-grow">
    <section class="max-w-2xl mx-auto my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Your Achievements</h2>
      <div class="mb-8 flex justify-center gap-8">
        <div class="bg-blue-100 rounded-lg p-4 text-center">
          <div class="text-2xl font-bold text-blue-600">{{ $totalScore }}</div>
          <div class="text-gray-700">Total Score</div>
        </div>
        <div class="bg-blue-100 rounded-lg p-4 text-center">
          <div class="text-2xl font-bold text-blue-600">{{ $quizzesTaken }}</div>
          <div class="text-gray-700">Quizzes Taken</div>
        </div>
      </div>

      <div class="flex flex-wrap gap-6 justify-center">
        @foreach($achievements as $ach)
          @php
            $colors = [
              'bronze' => 'bg-yellow-700 text-white border-yellow-700',
              'silver' => 'bg-gray-400 text-gray-700 border-gray-400',
              'gold' => 'bg-yellow-400 text-yellow-900 border-yellow-400',
              'diamond' => 'bg-blue-300 text-blue-900 border-blue-400',
            ];
            $color = $colors[$ach['tier']];
          @endphp

          @if($ach['tier'] === 'diamond')
            <div class="w-full flex justify-center">
              <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-6 shadow-sm border-l-8 {{ $color }} max-w-md mx-auto">
                <div class="text-4xl mr-2">{{ $ach['icon'] }}</div>
                <div>
                  <div class="font-semibold text-xl">{{ $ach['title'] }}</div>
                  <div class="text-gray-700 text-sm mb-1">{{ $ach['desc'] }}</div>
                  @if($ach['unlocked'])
                    <span class="inline-block bg-green-500 text-white px-3 py-1 rounded-full font-bold">Unlocked</span>
                  @else
                    <span class="inline-block bg-gray-300 text-gray-600 px-3 py-1 rounded-full font-bold">Locked</span>
                  @endif
                </div>
              </div>
            </div>
          @else
            <div class="flex items-center gap-4 bg-gray-50 rounded-lg p-4 shadow-sm border-l-8 {{ $color }} w-[45%]">
              <div class="text-3xl mr-2">{{ $ach['icon'] }}</div>
              <div>
                <div class="font-semibold text-lg">{{ $ach['title'] }}</div>
                @if($ach['tier'] === 'bronze')
                <div class="text-white   text-sm mb-1">{{ $ach['desc'] }}</div>
                @else
                <div class="text-gray-700 text-sm mb-1">{{ $ach['desc'] }}</div>
                @endif
                @if($ach['unlocked'])
                  <span class="inline-block bg-green-500 text-white px-3 py-1 rounded-full font-bold">Unlocked</span>
                @else
                  <span class="inline-block bg-gray-300 text-gray-600 px-3 py-1 rounded-full font-bold">Locked</span>
                @endif
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </section>
  </main>
</body>
