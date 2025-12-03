<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Subdomain Directory') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen text-slate-600">
    <div class="min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
        <!-- Navigation -->
        <nav class="bg-slate-900 border-b border-slate-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-white flex items-center gap-2">
                                <span>Subdomain <span class="text-indigo-400">abiyamf.my.id</span></span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden sm:flex items-center space-x-4">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-300 hover:text-white hover:bg-slate-800 px-3 py-2 rounded-md text-sm font-medium transition-colors">Login</a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Icon when menu is closed -->
                            <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Icon when menu is open -->
                            <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-white hover:bg-slate-800 block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left text-slate-300 hover:text-white hover:bg-slate-800 block px-3 py-2 rounded-md text-base font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-white hover:bg-slate-800 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 border-t border-slate-800 py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-400 text-sm">
                &copy; {{ date('Y') }} Subdomain Directory. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
