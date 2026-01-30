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
            margin-left: 0; /* Mobile: no margin */
            width: 100%;
            box-sizing: border-box;
        }
        @media (min-width: 1024px) {
            .main-content {
                margin-left: 14rem; /* Desktop: sidebar width (w-56 = 14rem = 224px) */
                width: calc(100% - 14rem);
            }
        }
        /* Adjust for top nav bar height */
        .fixed-sidebar {
            top: 3.5rem; /* Reduced from 4rem */
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        /* Hide sidebar on mobile */
        @media (max-width: 1023px) {
            .desktop-sidebar {
                display: none !important;
            }
        }
        /* Mobile drawer styles */
        .mobile-drawer {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-drawer.open {
            transform: translateX(0);
        }
        .mobile-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
        .mobile-overlay.open {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Top Navigation Bar - Fixed -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
                <!-- Logo and Burger Menu (Mobile) -->
                <div class="flex items-center">
                    <!-- Burger Menu Button (Mobile only) -->
                    <button id="mobileMenuButton" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors mr-2">
                        <i data-lucide="menu" class="w-5 h-5 text-gray-700"></i>
                    </button>
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-2 shadow-md">
                            <i data-lucide="shopping-cart" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Sanar Market</span>
                    </div>
                </div>

                <!-- Center Navigation (Desktop only) -->
                <div class="hidden lg:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="{{ route('announcements.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Annonces</a>
                        <a href="{{ route('forum.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Forum</a>
                        <a href="{{ route('forum.groups.index') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Groupes</a>
                        <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-2 rounded-md text-sm font-medium shadow-md">Administration</a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">À propos</a>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <div class="hidden md:flex items-center">
                        <div class="w-6 h-6 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mr-2">
                            <i data-lucide="user" class="w-3.5 h-3.5 text-white"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    </div>
                    <a href="{{ route('announcements.create') }}" class="hidden md:flex bg-gradient-to-r from-green-500 to-green-600 text-white px-3 py-2 rounded-lg text-sm font-medium items-center shadow-md hover:from-green-600 hover:to-green-700 transition-all">
                        <i data-lucide="plus" class="w-3.5 h-3.5 mr-1"></i>
                        Publier
                    </a>
                    <div class="hidden lg:block text-sm text-gray-500 font-medium">
                        {{ now()->format('d/m/Y') }} {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>

    <!-- Mobile Drawer Menu -->
    <div id="mobileDrawer" class="mobile-drawer fixed left-0 top-0 h-full w-80 bg-gradient-to-b from-white to-gray-50 shadow-2xl z-50 lg:hidden flex flex-col">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center mr-2 shadow-md">
                    <i data-lucide="shopping-cart" class="w-4 h-4 text-white"></i>
                </div>
                <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Sanar Market</span>
            </div>
            <button id="closeMobileMenu" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5 text-gray-700"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-4">
            <!-- User Info -->
            <div class="mb-4 pb-4 border-b border-gray-200">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mr-2">
                        <i data-lucide="user" class="w-4 h-4 text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrateur</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-md">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i>
                    Dashboard
                </a>
                
                <div class="pt-4">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Navigation</h3>
                    <div class="space-y-1">
                        <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                            Accueil
                        </a>
                        <a href="{{ route('announcements.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            Annonces
                        </a>
                        <a href="{{ route('forum.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                            Forum
                        </a>
                        <a href="{{ route('forum.groups.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                            Groupes
                        </a>
                        <a href="{{ route('announcements.create') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Publier une annonce
                        </a>
                    </div>
                </div>
                
                <div class="pt-4">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gestion</h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.users') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                            <div class="p-1.5 bg-blue-100 rounded-lg mr-2 group-hover:bg-blue-200 transition-colors">
                                <i data-lucide="users" class="w-3.5 h-3.5 text-blue-600"></i>
                            </div>
                            Utilisateurs
                        </a>
                        <a href="{{ route('admin.announcements') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-blue-50 hover:text-green-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.announcements') ? 'bg-gradient-to-r from-green-50 to-blue-50 text-green-600' : '' }}">
                            <div class="p-1.5 bg-green-100 rounded-lg mr-2 group-hover:bg-green-200 transition-colors">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 text-green-600"></i>
                            </div>
                            Annonces
                        </a>
                        <a href="{{ route('admin.advertisements.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.advertisements.*') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-600' : '' }}">
                            <div class="p-1.5 bg-purple-100 rounded-lg mr-2 group-hover:bg-purple-200 transition-colors">
                                <i data-lucide="image" class="w-3.5 h-3.5 text-purple-600"></i>
                            </div>
                            Publicités
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-orange-50 to-red-50 text-orange-600' : '' }}">
                            <div class="p-1.5 bg-orange-100 rounded-lg mr-2 group-hover:bg-orange-200 transition-colors">
                                <i data-lucide="tag" class="w-3.5 h-3.5 text-orange-600"></i>
                            </div>
                            Catégories
                        </a>
                        <a href="{{ route('admin.subcategories') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-yellow-50 hover:text-amber-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.subcategories.*') ? 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-600' : '' }}">
                            <div class="p-1.5 bg-amber-100 rounded-lg mr-2 group-hover:bg-amber-200 transition-colors">
                                <i data-lucide="tags" class="w-3.5 h-3.5 text-amber-600"></i>
                            </div>
                            Sous-catégories
                        </a>
                        <a href="{{ route('admin.boutiques') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50 hover:text-indigo-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.boutiques') ? 'bg-gradient-to-r from-indigo-50 to-blue-50 text-indigo-600' : '' }}">
                            <div class="p-1.5 bg-indigo-100 rounded-lg mr-2 group-hover:bg-indigo-200 transition-colors">
                                <i data-lucide="store" class="w-3.5 h-3.5 text-indigo-600"></i>
                            </div>
                            Boutiques
                        </a>
                        <a href="{{ route('admin.restaurants') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.restaurants') ? 'bg-gradient-to-r from-red-50 to-pink-50 text-red-600' : '' }}">
                            <div class="p-1.5 bg-red-100 rounded-lg mr-2 group-hover:bg-red-200 transition-colors">
                                <i data-lucide="utensils-crossed" class="w-3.5 h-3.5 text-red-600"></i>
                            </div>
                            Restaurants
                        </a>
                        <a href="{{ route('admin.events') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 hover:text-teal-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.events') ? 'bg-gradient-to-r from-teal-50 to-cyan-50 text-teal-600' : '' }}">
                            <div class="p-1.5 bg-teal-100 rounded-lg mr-2 group-hover:bg-teal-200 transition-colors">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-teal-600"></i>
                            </div>
                            Événements
                        </a>
                        <a href="{{ route('admin.campus-spotlight') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-violet-50 hover:to-purple-50 hover:text-violet-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.campus-spotlight') ? 'bg-gradient-to-r from-violet-50 to-purple-50 text-violet-600' : '' }}">
                            <div class="p-1.5 bg-violet-100 rounded-lg mr-2 group-hover:bg-violet-200 transition-colors">
                                <i data-lucide="megaphone" class="w-3.5 h-3.5 text-violet-600"></i>
                            </div>
                            À la une
                        </a>
                        <a href="{{ route('admin.campus-restaurant-menus') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.campus-restaurant-menus') ? 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-600' : '' }}">
                            <div class="p-1.5 bg-emerald-100 rounded-lg mr-2 group-hover:bg-emerald-200 transition-colors">
                                <i data-lucide="utensils" class="w-3.5 h-3.5 text-emerald-600"></i>
                            </div>
                            Menus Campus
                        </a>
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.useful-info') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 hover:text-sky-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.useful-info') ? 'bg-gradient-to-r from-sky-50 to-blue-50 text-sky-600' : '' }}">
                            <div class="p-1.5 bg-sky-100 rounded-lg mr-2 group-hover:bg-sky-200 transition-colors">
                                <i data-lucide="info" class="w-3.5 h-3.5 text-sky-600"></i>
                            </div>
                            Infos utiles
                        </a>
                        @endif
                    </div>
                </div>

                <div class="pt-4">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Compte</h3>
                    <div class="px-3 space-y-1">
                        <a href="{{ route('admin.profile.edit') }}" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                            <i data-lucide="user" class="w-3.5 h-3.5 mr-2"></i>
                            Mon Profil
                        </a>
                        <a href="{{ route('admin.customize') }}" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition-all">
                            <i data-lucide="palette" class="w-3.5 h-3.5 mr-2"></i>
                            Personnaliser
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Logout Button -->
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

    <div class="flex pt-14">
        <!-- Left Sidebar - Fixed (Desktop only) -->
        <aside class="desktop-sidebar hidden lg:flex fixed left-0 top-14 w-56 h-[calc(100vh-3.5rem)] bg-gradient-to-b from-white to-gray-50 shadow-xl border-r border-gray-200 z-40 flex-col">
            <div class="flex-1 overflow-y-auto p-4">
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-md">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 mr-2"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-4">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gestion</h3>
                        <div class="space-y-1">
                            <a href="{{ route('admin.users') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                                <div class="p-1.5 bg-blue-100 rounded-lg mr-2 group-hover:bg-blue-200 transition-colors">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-blue-600"></i>
                                </div>
                                Utilisateurs
                            </a>
                            <a href="{{ route('admin.announcements') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-blue-50 hover:text-green-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.announcements') ? 'bg-gradient-to-r from-green-50 to-blue-50 text-green-600' : '' }}">
                                <div class="p-1.5 bg-green-100 rounded-lg mr-2 group-hover:bg-green-200 transition-colors">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-green-600"></i>
                                </div>
                                Annonces
                            </a>
                            <a href="{{ route('admin.advertisements.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.advertisements.*') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-600' : '' }}">
                                <div class="p-1.5 bg-purple-100 rounded-lg mr-2 group-hover:bg-purple-200 transition-colors">
                                    <i data-lucide="image" class="w-3.5 h-3.5 text-purple-600"></i>
                                </div>
                                Publicités
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-orange-50 to-red-50 text-orange-600' : '' }}">
                                <div class="p-1.5 bg-orange-100 rounded-lg mr-2 group-hover:bg-orange-200 transition-colors">
                                    <i data-lucide="tag" class="w-3.5 h-3.5 text-orange-600"></i>
                                </div>
                                Catégories
                            </a>
                            <a href="{{ route('admin.subcategories') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-amber-50 hover:to-yellow-50 hover:text-amber-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.subcategories.*') ? 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-600' : '' }}">
                                <div class="p-1.5 bg-amber-100 rounded-lg mr-2 group-hover:bg-amber-200 transition-colors">
                                    <i data-lucide="tags" class="w-3.5 h-3.5 text-amber-600"></i>
                                </div>
                                Sous-catégories
                            </a>
                            <a href="{{ route('admin.boutiques') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50 hover:text-indigo-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.boutiques') ? 'bg-gradient-to-r from-indigo-50 to-blue-50 text-indigo-600' : '' }}">
                                <div class="p-1.5 bg-indigo-100 rounded-lg mr-2 group-hover:bg-indigo-200 transition-colors">
                                    <i data-lucide="store" class="w-3.5 h-3.5 text-indigo-600"></i>
                                </div>
                                Boutiques
                            </a>
                            <a href="{{ route('admin.restaurants') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.restaurants') ? 'bg-gradient-to-r from-red-50 to-pink-50 text-red-600' : '' }}">
                                <div class="p-1.5 bg-red-100 rounded-lg mr-2 group-hover:bg-red-200 transition-colors">
                                    <i data-lucide="utensils-crossed" class="w-3.5 h-3.5 text-red-600"></i>
                                </div>
                                Restaurants
                            </a>
                            <a href="{{ route('admin.events') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 hover:text-teal-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.events') ? 'bg-gradient-to-r from-teal-50 to-cyan-50 text-teal-600' : '' }}">
                                <div class="p-1.5 bg-teal-100 rounded-lg mr-2 group-hover:bg-teal-200 transition-colors">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5 text-teal-600"></i>
                                </div>
                                Événements
                            </a>
                            <a href="{{ route('admin.campus-spotlight') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-violet-50 hover:to-purple-50 hover:text-violet-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.campus-spotlight') ? 'bg-gradient-to-r from-violet-50 to-purple-50 text-violet-600' : '' }}">
                                <div class="p-1.5 bg-violet-100 rounded-lg mr-2 group-hover:bg-violet-200 transition-colors">
                                    <i data-lucide="megaphone" class="w-3.5 h-3.5 text-violet-600"></i>
                                </div>
                                À la une
                            </a>
                            <a href="{{ route('admin.campus-restaurant-menus') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.campus-restaurant-menus') ? 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-600' : '' }}">
                            <div class="p-1.5 bg-emerald-100 rounded-lg mr-2 group-hover:bg-emerald-200 transition-colors">
                                <i data-lucide="utensils" class="w-3.5 h-3.5 text-emerald-600"></i>
                            </div>
                            Menus Campus
                        </a>
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.useful-info') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 hover:text-sky-600 rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.useful-info') ? 'bg-gradient-to-r from-sky-50 to-blue-50 text-sky-600' : '' }}">
                            <div class="p-1.5 bg-sky-100 rounded-lg mr-2 group-hover:bg-sky-200 transition-colors">
                                <i data-lucide="info" class="w-3.5 h-3.5 text-sky-600"></i>
                            </div>
                            Infos utiles
                        </a>
                        @endif
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Compte</h3>
                        <div class="px-3 space-y-1">
                            <a href="{{ route('admin.profile.edit') }}" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                                <i data-lucide="user" class="w-3.5 h-3.5 mr-2"></i>
                                Mon Profil
                            </a>
                            <a href="{{ route('admin.customize') }}" class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition-all">
                                <i data-lucide="palette" class="w-3.5 h-3.5 mr-2"></i>
                                Personnaliser
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
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 p-8 bg-gray-100">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
        
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileDrawer = document.getElementById('mobileDrawer');
        const mobileOverlay = document.getElementById('mobileOverlay');
        
        function openMobileMenu() {
            mobileDrawer.classList.add('open');
            mobileOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
            lucide.createIcons();
        }
        
        function closeMobileMenuFunc() {
            mobileDrawer.classList.remove('open');
            mobileOverlay.classList.remove('open');
            document.body.style.overflow = '';
            lucide.createIcons();
        }
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', openMobileMenu);
        }
        
        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
        }
        
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', closeMobileMenuFunc);
        }
        
        // Close menu when clicking on a link
        const mobileLinks = mobileDrawer?.querySelectorAll('a');
        if (mobileLinks) {
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    setTimeout(closeMobileMenuFunc, 100);
                });
            });
        }
        
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
