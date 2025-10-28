<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Sanar Market</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* Ensure main content pushes past fixed sidebar */
        .main-content {
            margin-left: 16rem; /* Equivalent to w-64 */
        }
        /* Adjust for top nav bar height */
        .fixed-sidebar {
            top: 4rem; /* Equivalent to h-16 */
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Top Navigation Bar - Fixed -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Sanar Market</span>
                    </div>
                </div>

                <!-- Center Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="/announcements" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Annonces</a>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-2 rounded-md text-sm font-medium shadow-md">Administration</a>
                        <a href="/about" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">À propos</a>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mr-2">
                            <i data-lucide="user" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('announcements.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center shadow-md hover:from-green-600 hover:to-green-700 transition-all">
                        <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                        Publier
                    </a>
                    <div class="text-sm text-gray-500 font-medium">
                        {{ now()->format('d/m/Y') }} {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Left Sidebar - Fixed -->
        <div class="fixed left-0 top-16 w-64 h-screen bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 z-40 overflow-y-auto">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-md">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-6">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Gestion</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3 group-hover:bg-blue-200 transition-colors">
                                    <i data-lucide="users" class="w-4 h-4 text-blue-600"></i>
                                </div>
                                Utilisateurs
                            </a>
                            <a href="{{ route('admin.announcements') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-blue-50 hover:text-green-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.announcements') ? 'bg-gradient-to-r from-green-50 to-blue-50 text-green-600' : '' }}">
                                <div class="p-2 bg-green-100 rounded-lg mr-3 group-hover:bg-green-200 transition-colors">
                                    <i data-lucide="file-text" class="w-4 h-4 text-green-600"></i>
                                </div>
                                Annonces
                            </a>
                            <a href="{{ route('admin.advertisements.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.advertisements.*') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-600' : '' }}">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3 group-hover:bg-purple-200 transition-colors">
                                    <i data-lucide="image" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                Publicités
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-orange-50 to-red-50 text-orange-600' : '' }}">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3 group-hover:bg-orange-200 transition-colors">
                                    <i data-lucide="tag" class="w-4 h-4 text-orange-600"></i>
                                </div>
                                Catégories
                            </a>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Compte</h3>
                        <div class="px-4 space-y-2 mb-2">
                            <a href="{{ route('admin.profile.edit') }}" class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                                <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                Mon Profil
                            </a>
                            <a href="{{ route('admin.customize') }}" class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition-all">
                                <i data-lucide="palette" class="w-4 h-4 mr-2"></i>
                                Personnaliser
                            </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="px-4">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all">
                                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 p-8 bg-gray-100">
            @yield('content')
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        // Animation d'entrée pour les cartes
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    </script>
</body>
</html>
