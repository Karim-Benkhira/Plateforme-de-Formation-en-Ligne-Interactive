<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BrightPath</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div>
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-blue-500 text-2xl font-bold">BrightPath</h1>
        <nav>
            @if(Auth::check())
                @if(Auth::user()->role === 'admin')
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('admin.users') }}">Users</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('admin.courses') }}">Courses</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('admin.categories') }}">categories</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('admin.reclamations') }}">Reports</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('admin.quizzes') }}">Quizzes</a>
                @elseif(Auth::user()->role === 'agent')
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('agent.dashboard') }}">Dashboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('agent.reclamations') }}">Reclamations</a>
                @elseif(Auth::user()->role === 'user')
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.dashboard') }}">Dashboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.courses') }}">Courses</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.myCourses') }}">My Courses</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.leaderboard') }}">Leaderboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.achievements') }}">Achievements</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.profile') }}">Profile</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('student.support') }}">Support</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-blue-500 hover:text-blue-700 mx-2">Logout</button>
                </form>
            @else
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="/">Home</a>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="/about">about</a>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('login') }}">Login</a>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="{{ route('register') }}">Register</a>
            @endif
        </nav>
    </header>
</body>
</html> 