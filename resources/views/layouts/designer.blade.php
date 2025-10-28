<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Designer') - Sanar Market</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .main-content {
            margin-left: 16rem;
        }
        .fixed-sidebar {
            top: 4rem;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-pink-50">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                            <i data-lucide="palette" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Sanar Market - Designer</span>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="text-gray-500 hover:text-pink-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="/announcements" class="text-gray-500 hover:text-pink-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Annonces</a>
                        <a href="{{ route('designer.dashboard') }}" class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-3 py-2 rounded-md text-sm font-medium shadow-md">Designer</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-pink-400 to-purple-500 rounded-full flex items-center justify-center mr-2">
                            <i data-lucide="user" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Left Sidebar -->
        <div class="fixed left-0 top-16 w-64 h-screen bg-gradient-to-b from-white to-pink-50 shadow-xl border-r border-gray-200 z-40 overflow-y-auto">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('designer.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white bg-gradient-to-r from-pink-600 to-purple-600 rounded-lg shadow-md">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-6">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Gestion</h3>
                        <div class="space-y-2">
                            <a href="{{ route('designer.my-designs') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 hover:text-pink-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('designer.my-designs') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600' : '' }}">
                                <div class="p-2 bg-pink-100 rounded-lg mr-3 group-hover:bg-pink-200 transition-colors">
                                    <i data-lucide="image" class="w-4 h-4 text-pink-600"></i>
                                </div>
                                Mes Créations
                            </a>
                            <a href="{{ route('designer.create') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('designer.create') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-600' : '' }}">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3 group-hover:bg-purple-200 transition-colors">
                                    <i data-lucide="plus-circle" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                Créer une publicité
                            </a>
                            <a href="{{ route('designer.customize') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-pink-50 hover:text-orange-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('designer.customize') ? 'bg-gradient-to-r from-orange-50 to-pink-50 text-orange-600' : '' }}">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3 group-hover:bg-orange-200 transition-colors">
                                    <i data-lucide="palette" class="w-4 h-4 text-orange-600"></i>
                                </div>
                                Personnaliser
                            </a>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Compte</h3>
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
    </script>
</body>
</html>

