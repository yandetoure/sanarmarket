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

                <!-- Navigation desktop (visible uniquement sur desktop à partir de 1024px) -->
                <nav class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('home') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('home') ? 'text-gray-900' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('announcements.index') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('announcements.*') ? 'text-gray-900' : '' }}">
                        Annonces
                    </a>
                    <a href="{{ route('boutiques.index') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('boutiques.*') ? 'text-gray-900' : '' }}">
                        Boutiques
                    </a>
                    <a href="{{ route('restaurants.index') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('restaurants.*') ? 'text-gray-900' : '' }}">
                        Restaurants
                    </a>
                    <a href="{{ route('forum.index') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('forum.index') || request()->routeIs('forum.show') || request()->routeIs('forum.create') ? 'text-gray-900' : '' }}">
                        Forum
                    </a>
                    <a href="{{ route('forum.groups.index') }}" class="text-lg text-gray-500 hover:text-gray-900 transition-colors {{ request()->routeIs('forum.groups.*') ? 'text-gray-900' : '' }}">
                        Groupes
                    </a>
                    <a href="#" class="text-lg text-gray-500 hover:text-gray-900 transition-colors">
                        À propos
                    </a>
                </nav>

                <!-- Éléments desktop (visible uniquement sur desktop à partir de 1024px) -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        @php
                            $dashboardRoute = Auth::user()->isAdmin()
                                ? route('admin.dashboard')
                                : (Auth::user()->isDesigner()
                                    ? route('designer.dashboard')
                                    : (Auth::user()->isMarketing()
                                        ? route('marketing.dashboard')
                                        : route('dashboard')));
                        @endphp
                        <div class="flex items-center gap-2 text-gray-500 text-lg">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <a href="{{ $dashboardRoute }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all flex items-center gap-2 text-lg">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Dashboard</span>
                        </a>
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

                <!-- Menu burger mobile et tablette (visible jusqu'à 1024px, caché sur desktop lg et plus) -->
                <button id="mobileNavButton" class="lg:hidden p-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors" aria-label="Menu">
                    <i data-lucide="menu" class="w-5 h-5 text-gray-700"></i>
                </button>
            </div>

            <!-- Menu mobile navigation (caché par défaut, visible uniquement jusqu'à 1024px) -->
            <div id="mobileNavMenu" class="hidden lg:hidden border-t border-gray-200 mt-4 pt-4 pb-2">
                <nav class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-gray-100 font-semibold' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('announcements.index') }}" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('announcements.*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Annonces
                    </a>
                    <a href="{{ route('boutiques.index') }}" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('boutiques.*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Boutiques
                    </a>
                    <a href="{{ route('restaurants.index') }}" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('restaurants.*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Restaurants
                    </a>
                    <a href="{{ route('forum.index') }}" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('forum.index') || request()->routeIs('forum.show') || request()->routeIs('forum.create') ? 'bg-gray-100 font-semibold' : '' }}">
                        Forum
                    </a>
                    <a href="{{ route('forum.groups.index') }}" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('forum.groups.*') ? 'bg-gray-100 font-semibold' : '' }}">
                        Groupes
                    </a>
                    <a href="#" class="px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                        À propos
                    </a>

                    @auth
                        <!-- Informations utilisateur dans le menu mobile -->
                        <div class="border-t border-gray-200 mt-2 pt-3">
                            <div class="px-4 py-2 flex items-center gap-2 text-gray-700 mb-2">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                            </div>
                            <a href="{{ $dashboardRoute }}" class="flex items-center gap-2 px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors mb-2">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('announcements.create') }}" class="flex items-center gap-2 px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors mb-2">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Publier une annonce
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 text-base text-gray-700 hover:bg-gray-50 rounded-lg transition-colors w-full text-left">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    Se déconnecter
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Boutons de connexion dans le menu mobile -->
                        <div class="border-t border-gray-200 mt-2 pt-3 space-y-2">
                            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-base font-semibold text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-base font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                                S'inscrire
                            </a>
                            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-base font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Publier une annonce
                            </a>
                        </div>
                    @endauth
                </nav>
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

        // Menu burger mobile pour la navigation
        const mobileNavButton = document.getElementById('mobileNavButton');
        const mobileNavMenu = document.getElementById('mobileNavMenu');
        let navMenuOpen = false;

        if (mobileNavButton && mobileNavMenu) {
            mobileNavButton.addEventListener('click', function(e) {
                e.stopPropagation();
                navMenuOpen = !navMenuOpen;
                if (navMenuOpen) {
                    mobileNavMenu.classList.remove('hidden');
                    mobileNavButton.innerHTML = '<i data-lucide="x" class="w-5 h-5 text-gray-700"></i>';
                    lucide.createIcons();
                } else {
                    mobileNavMenu.classList.add('hidden');
                    mobileNavButton.innerHTML = '<i data-lucide="menu" class="w-5 h-5 text-gray-700"></i>';
                    lucide.createIcons();
                }
            });

            // Fermer le menu en cliquant en dehors
            document.addEventListener('click', function(event) {
                if (!mobileNavButton.contains(event.target) && !mobileNavMenu.contains(event.target)) {
                    if (navMenuOpen) {
                        navMenuOpen = false;
                        mobileNavMenu.classList.add('hidden');
                        mobileNavButton.innerHTML = '<i data-lucide="menu" class="w-5 h-5 text-gray-700"></i>';
                        lucide.createIcons();
                    }
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
