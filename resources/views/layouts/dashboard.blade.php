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
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-right: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(15px) saturate(160%);
            -webkit-backdrop-filter: blur(15px) saturate(160%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .active-nav-glow {
            box-shadow: 0 0 25px rgba(15, 117, 255, 0.25);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(15, 23, 42, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-900 h-full selection:bg-primary-100 selection:text-primary-700">
    <div class="min-h-full flex relative overflow-hidden" x-data="{ sidebarOpen: false }">
        <!-- Abstract Background Orbs -->
        <div class="fixed inset-0 z-0 pointer-events-none">
            <div
                class="absolute top-[-10%] left-[-5%] w-[40%] h-[40%] bg-primary-100/30 blur-[120px] rounded-full animate-pulse">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-5%] w-[35%] h-[35%] bg-indigo-100/30 blur-[100px] rounded-full delay-1000 animate-pulse">
            </div>
        </div>

        <!-- Sidebar and Backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-50 lg:hidden" x-cloak>
            <div @click="sidebarOpen = false" x-show="sidebarOpen"
                x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="fixed inset-y-0 left-0 flex w-72 flex-col bg-white/90 backdrop-blur-2xl shadow-2xl relative z-50">
                <!-- Mobile Sidebar Content -->
                @include('layouts.partials.sidebar-content')
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div
            class="hidden lg:flex lg:w-72 lg:flex-col lg:fixed lg:inset-y-0 glass-sidebar z-30 transition-all duration-500">
            @include('layouts.partials.sidebar-content')
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 lg:pl-72 focus:outline-none relative z-10">
            <!-- Header -->
            <header class="glass-header sticky top-0 z-30 transition-all duration-300">
                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-10">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-3 rounded-2xl text-slate-500 bg-white shadow-sm border border-slate-100 hover:text-primary-600 transition-all active:scale-95">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex flex-1 items-center justify-end">
                        <div class="flex items-center space-x-6">
                            <div class="hidden sm:block text-right">
                                <p class="text-sm font-black text-slate-900 leading-tight">{{ auth()->user()->name }}
                                </p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-0.5">
                                    {{ auth()->user()->role ?? 'Utilisateur' }}
                                </p>
                            </div>
                            <div class="relative group cursor-pointer">
                                <div
                                    class="w-11 h-11 rounded-[1.25rem] bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center border-2 border-white shadow-xl shadow-primary-100 text-white font-black text-sm group-hover:scale-110 transition-transform duration-300">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 py-12 px-4 sm:px-6 lg:px-10 max-w-7xl mx-auto w-full">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>