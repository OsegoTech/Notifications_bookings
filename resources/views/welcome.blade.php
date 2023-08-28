<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased bg-white">
    <div class=" w-full  py-4 flex justify-around items-center px-10 border-b-2 shadow-md hover:shadow-lg transition duration-300">
        <img src="{{asset('images/logo.png')}}" alt="" class="rounded-full w-[80px]">
        <nav class="sm:block">
            <ul class="flex justify-between items-center font-bold">
                <li class="mr-3 text-1.5xl">Community</li>
                <li class="mr-3 text-1.5xl">Events</li>
                <li class="mr-3 text-1.5xl">Projects</li>
                <li class="mr-3 text-1.5xl">Contact</li>
            </ul>
        </nav>
        <div>
            <a href="{{ route('register') }}" class="mr-3 bg-green-400 text-white p-3 rounded-md hover:bg-green-600">Register</a>
            <a href="{{ route('login') }}" class="mr-3 bg-green-400 text-white p-3 rounded-md hover:bg-green-600">Login</a>
        </div>
    </div>
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen">

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex flex-col justify-center items-center">
                    <div class="mt-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">Log In</a>
                        @endauth
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
