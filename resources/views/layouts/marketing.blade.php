<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Marketing') - Sanar Market</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .main-content {
            margin-left: 14rem; /* Increased sidebar width */
        }
        .fixed-sidebar {
            top: 3.5rem; /* Reduced from 4rem */
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-green-50">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-r from-green-600 to-purple-600 rounded-lg flex items-center justify-center mr-2 shadow-md">
                            <i data-lucide="trending-up" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-green-600 to-purple-600 bg-clip-text text-transparent">Sanar Market - Marketing</span>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="{{ route('announcements.index') }}" class="text-gray-500 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Annonces</a>
                        <a href="{{ route('forum.index') }}" class="text-gray-500 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Forum</a>
                        <a href="{{ route('forum.groups.index') }}" class="text-gray-500 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Groupes</a>
                        <a href="{{ route('marketing.dashboard') }}" class="bg-gradient-to-r from-green-600 to-purple-600 text-white px-3 py-2 rounded-md text-sm font-medium shadow-md">Marketing</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-r from-green-400 to-purple-500 rounded-full flex items-center justify-center mr-2">
                            <i data-lucide="user" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-14">
        <!-- Left Sidebar -->
        <div class="fixed left-0 top-14 w-56 h-[calc(100vh-3.5rem)] bg-gradient-to-b from-white to-green-50 shadow-xl border-r border-gray-200 z-40 flex flex-col">
            <div class="flex-1 overflow-y-auto p-4">
                <nav class="space-y-1">
                    <a href="{{ route('marketing.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-purple-600 rounded-lg shadow-md">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-4">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gestion</h3>
                        <div class="space-y-1">
                            <a href="{{ route('marketing.advertisements') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-purple-50 hover:text-green-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('marketing.advertisements') ? 'bg-gradient-to-r from-green-50 to-purple-50 text-green-600' : '' }}">
                                <div class="p-1.5 bg-green-100 rounded-lg mr-2 group-hover:bg-green-200 transition-colors">
                                    <i data-lucide="image" class="w-3.5 h-3.5 text-green-600"></i>
                                </div>
                                Publicités
                            </a>
                            <a href="{{ route('marketing.statistics') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-green-50 hover:text-purple-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('marketing.statistics') ? 'bg-gradient-to-r from-purple-50 to-green-50 text-purple-600' : '' }}">
                                <div class="p-1.5 bg-purple-100 rounded-lg mr-2 group-hover:bg-purple-200 transition-colors">
                                    <i data-lucide="bar-chart" class="w-3.5 h-3.5 text-purple-600"></i>
                                </div>
                                Statistiques
                            </a>
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Compte</h3>
                        <div class="px-3">
                            <a href="{{ route('marketing.profile.edit') }}" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 rounded-lg transition-all">
                                <i data-lucide="user" class="w-3.5 h-3.5 mr-2"></i>
                                Mon Profil
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Fixed Logout Button at Bottom -->
            <div class="p-4 border-t border-gray-200 bg-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-all">
                        <i data-lucide="log-out" class="w-3.5 h-3.5 mr-2"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 p-8 bg-gray-100">
            @yield('content')
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

