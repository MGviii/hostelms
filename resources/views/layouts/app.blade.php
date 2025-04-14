<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hostel Management System') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                                {{ config('app.name', 'Hostel Management System') }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        @auth
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('student.dashboard') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out
                                    {{ request()->routeIs('student.dashboard') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    <i class="fas fa-home mr-2"></i> Dashboard
                                </a>
                                <a href="{{ route('student.requests.index') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out
                                    {{ request()->routeIs('student.requests.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    <i class="fas fa-bed mr-2"></i> Room Requests
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Right Side Of Navbar -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @guest
                            <div class="space-x-4">
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Register</a>
                                @endif
                            </div>
                        @else
                            <div class="ml-3 relative">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-700 mr-4">{{ Auth::user()->name }}</span>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-700 hover:text-gray-900">
                                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-controls="mobile-menu" aria-expanded="false">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="sm:hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    @auth
                        <a href="{{ route('student.dashboard') }}"
                            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium focus:outline-none transition duration-150 ease-in-out
                            {{ request()->routeIs('student.dashboard') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                        <a href="{{ route('student.requests.index') }}"
                            class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium focus:outline-none transition duration-150 ease-in-out
                            {{ request()->routeIs('student.requests.*') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                            <i class="fas fa-bed mr-2"></i> Room Requests
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('button[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
