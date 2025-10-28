<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Designer') - Sanar Market</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @php
        $designerSettings = \App\Models\DesignerSetting::getForUser(Auth::id());
    @endphp
    <style>
        :root {
            --navbar-bg: {{ $designerSettings->navbar_bg_color }};
            --navbar-text: {{ $designerSettings->navbar_text_color }};
            --navbar-accent: {{ $designerSettings->navbar_accent_color }};
            --sidebar-bg: {{ $designerSettings->sidebar_bg_color }};
            --sidebar-text: {{ $designerSettings->sidebar_text_color }};
            --sidebar-active-bg: {{ $designerSettings->sidebar_active_bg }};
            --sidebar-active-text: {{ $designerSettings->sidebar_active_text }};
            --primary-color: {{ $designerSettings->primary_color }};
            --secondary-color: {{ $designerSettings->secondary_color }};
            --accent-color: {{ $designerSettings->accent_color }};
            --font-size: {{ $designerSettings->font_size }}px;
        }
        .main-content {
            margin-left: 16rem;
        }
        .fixed-sidebar {
            top: 4rem;
        }
        body {
            font-family: '{{ $designerSettings->font_family }}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: var(--font-size);
        }
        .navbar-custom {
            background-color: var(--navbar-bg);
            color: var(--navbar-text);
        }
        .navbar-text-custom {
            color: var(--navbar-text);
        }
        .navbar-accent-custom {
            color: var(--navbar-accent);
        }
        .navbar-hover-custom:hover {
            color: var(--navbar-accent);
        }
        .navbar-gradient-custom {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        .sidebar-custom {
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
        }
        .sidebar-link-custom {
            color: var(--sidebar-text);
        }
        .sidebar-link-custom:hover {
            background: linear-gradient(to right, var(--sidebar-active-bg), var(--sidebar-active-bg));
            color: var(--sidebar-active-text);
        }
        .sidebar-active-custom {
            background: linear-gradient(to right, var(--sidebar-active-bg), var(--sidebar-active-bg));
            color: var(--sidebar-active-text);
        }
        .btn-primary-custom {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        .btn-accent-custom {
            background-color: var(--accent-color);
        }
        .text-primary-custom {
            color: var(--primary-color);
        }
        .bg-primary-custom {
            background-color: var(--primary-color);
        }
        body.custom-theme {
            --color-primary: var(--primary-color);
            --color-secondary: var(--secondary-color);
            --color-accent: var(--accent-color);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-pink-50 custom-theme">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 left-0 right-0 z-50 navbar-custom shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        @if($designerSettings->logo_url)
                            <img src="{{ $designerSettings->logo_url }}" alt="Logo" class="h-10 w-auto mr-3">
                        @else
                            <div class="w-8 h-8 navbar-gradient-custom rounded-lg flex items-center justify-center mr-3 shadow-md">
                                <i data-lucide="palette" class="w-5 h-5 text-white"></i>
                            </div>
                        @endif
                        <span class="text-xl font-bold navbar-gradient-custom bg-clip-text text-transparent">Sanar Market - Designer</span>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="navbar-text-custom navbar-hover-custom px-3 py-2 rounded-md text-sm font-medium transition-colors">Accueil</a>
                        <a href="/announcements" class="navbar-text-custom navbar-hover-custom px-3 py-2 rounded-md text-sm font-medium transition-colors">Annonces</a>
                        <a href="{{ route('designer.dashboard') }}" class="navbar-gradient-custom text-white px-3 py-2 rounded-md text-sm font-medium shadow-md">Designer</a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 navbar-gradient-custom rounded-full flex items-center justify-center mr-2">
                            <i data-lucide="user" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-medium navbar-text-custom">{{ Auth::user()->name }}</span>
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
        <div class="fixed left-0 top-16 w-64 h-screen sidebar-custom shadow-xl border-r border-gray-200 z-40 overflow-y-auto">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('designer.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white navbar-gradient-custom rounded-lg shadow-md">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-6">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Gestion</h3>
                        <div class="space-y-2">
                            <a href="{{ route('designer.my-designs') }}" class="flex items-center px-4 py-3 text-sm font-medium sidebar-link-custom rounded-lg transition-all duration-200 group {{ request()->routeIs('designer.my-designs') ? 'sidebar-active-custom' : '' }}">
                                <div class="p-2 bg-pink-100 rounded-lg mr-3 group-hover:bg-pink-200 transition-colors">
                                    <i data-lucide="image" class="w-4 h-4 text-pink-600"></i>
                                </div>
                                Mes Créations
                            </a>
                            <a href="{{ route('designer.create') }}" class="flex items-center px-4 py-3 text-sm font-medium sidebar-link-custom rounded-lg transition-all duration-200 group {{ request()->routeIs('designer.create') ? 'sidebar-active-custom' : '' }}">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3 group-hover:bg-purple-200 transition-colors">
                                    <i data-lucide="plus-circle" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                Créer une publicité
                            </a>
                            <a href="{{ route('designer.customize') }}" class="flex items-center px-4 py-3 text-sm font-medium sidebar-link-custom rounded-lg transition-all duration-200 group {{ request()->routeIs('designer.customize') ? 'sidebar-active-custom' : '' }}">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3 group-hover:bg-orange-200 transition-colors">
                                    <i data-lucide="palette" class="w-4 h-4 text-orange-600"></i>
                                </div>
                                Personnaliser
                            </a>
                        </div>
                    </div>

                    <div class="pt-6">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Compte</h3>
                        <div class="px-4 mb-2">
                            <a href="{{ route('designer.profile.edit') }}" class="w-full flex items-center justify-center px-4 py-3 text-sm font-medium navbar-accent-custom bg-pink-50 hover:bg-pink-100 rounded-lg transition-all">
                                <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                Mon Profil
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
    </script>
</body>
</html>

