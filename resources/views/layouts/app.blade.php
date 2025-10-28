<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanar Market - Le marketplace des étudiants africains')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="border-b bg-white sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center">
                        <span class="text-white">🛒</span>
                    </div>
                    <h1 class="text-gray-900 font-semibold text-xl">Sanar Market</h1>
                </div>
                
                <nav class="hidden md:flex items-center gap-2">
                    <a href="{{ route('home') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('home') ? 'text-gray-900' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('announcements.index') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('announcements.*') ? 'text-gray-900' : '' }}">
                        Annonces
                    </a>
                    <a href="#" class="text-lg text-gray-500 hover:text-gray-900 transition-colors">
                        À propos
                    </a>
                </nav>

                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden md:flex items-center gap-2 text-gray-500 text-lg">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all flex items-center gap-2 text-lg">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Dashboard</span>
                            </a>
                        @elseif(Auth::user()->isDesigner())
                            <a href="{{ route('designer.dashboard') }}" class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-pink-700 hover:to-purple-700 transition-all flex items-center gap-2 text-lg">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Dashboard</span>
                            </a>
                        @elseif(Auth::user()->isMarketing())
                            <a href="{{ route('marketing.dashboard') }}" class="bg-gradient-to-r from-green-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-purple-700 transition-all flex items-center gap-2 text-lg">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Dashboard</span>
                            </a>
                        @endif
                        <a href="{{ route('announcements.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 text-lg">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Publier</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="border border-gray-200 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="border border-gray-200 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors text-lg">
                            Se connecter
                        </a>
                        <a href="{{ route('login') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 text-lg">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Publier une annonce
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @include('components.alerts')
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-500">
                <p>&copy; {{ date('Y') }} Sanar Market. Tous droits réservés.</p>
                <p class="mt-2">Le marketplace des étudiants africains</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        lucide.createIcons();
    </script>
    
    @yield('scripts')
</body>
</html>
