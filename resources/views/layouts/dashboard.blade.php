<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SanarWeb') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass-sidebar {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-900 h-full">
    <div class="min-h-full flex" x-data="{ sidebarOpen: false }">
        <!-- Sidebar and Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" x-cloak>
            <div @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

            <div class="fixed inset-y-0 left-0 flex w-72 flex-col bg-white shadow-2xl animate-fade-in relative z-50">
                <!-- Mobile Sidebar Content -->
                @include('layouts.partials.sidebar-content')
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden lg:flex lg:w-72 lg:flex-col lg:fixed lg:inset-y-0 glass-sidebar border-r border-slate-200">
            @include('layouts.partials.sidebar-content')
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 lg:pl-72 focus:outline-none">
            <!-- Header -->
            <header class="bg-white/70 backdrop-blur-md sticky top-0 z-30 border-b border-white/50 shadow-sm">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex flex-1 items-center justify-end space-x-6">
                        <div class="flex items-center space-x-4">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-black text-slate-900 leading-tight">{{ auth()->user()->name }}
                                </p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    {{ auth()->user()->role ?? 'Utilisateur' }}</p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center border-2 border-white shadow-lg text-white font-black text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>