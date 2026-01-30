<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SanarWeb') }} - @yield('title', 'Bienvenue')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .text-gradient {
            background: linear-gradient(to right, #0284c7, #c026d3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-900 h-full">
    <div class="min-h-full flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/70 backdrop-blur-xl sticky top-0 z-50 border-b border-white/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center space-x-3 group transition-transform duration-300 hover:scale-105">
                            <div class="w-12 h-12 bg-primary-600 rounded-2xl flex items-center justify-center shadow-xl shadow-primary-200 group-hover:rotate-6 transition-transform">
                                <span class="text-white font-display font-bold text-2xl">S</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xl font-display font-black tracking-tighter text-slate-900 leading-none">Sanar<span class="text-primary-600">Web</span></span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Plateforme Communautaire</span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="hidden md:ml-10 md:flex md:items-center md:space-x-1">
                        @php
                            $navItems = [
                                ['label' => 'Annonces', 'route' => 'announcements.index'],
                                ['label' => 'Boutiques', 'route' => 'boutiques.index'],
                                ['label' => 'Restaurants', 'route' => 'restaurants.index'],
                                ['label' => 'Forum', 'route' => 'forum.index'],
                            ];
                        @endphp
                        @foreach($navItems as $item)
                            <a href="{{ route($item['route']) }}" class="relative px-5 py-2 text-sm font-bold text-slate-600 hover:text-primary-600 transition-colors group">
                                {{ $item['label'] }}
                                <span class="absolute bottom-0 left-5 right-5 h-0.5 bg-primary-600 scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                            </a>
                        @endforeach
                    </div>

                    <div class="flex items-center space-x-5">
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none p-1.5 pr-4 rounded-2xl border border-slate-100 bg-white hover:bg-slate-50 transition-colors shadow-sm">
                                    <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ storage_url(auth()->user()->avatar) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-black text-primary-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                        @endif
                                    </div>
                                    <span class="hidden lg:block text-sm font-bold text-slate-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-cloak 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute right-0 mt-3 w-56 bg-white rounded-[1.5rem] shadow-2xl py-2 border border-slate-100 z-50 overflow-hidden">
                                    <div class="px-4 py-3 border-b border-slate-50 mb-1 bg-slate-50/50">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Connecté en tant que</p>
                                        <p class="text-[10px] font-bold text-primary-600 truncate mt-1">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        Tableau de bord
                                    </a>
                                    <div class="border-t border-slate-50 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-600 hover:text-primary-600 text-sm font-bold transition-colors">Connexion</a>
                            <x-button href="{{ route('register') }}" variant="primary" size="sm" class="px-6 shadow-xl shadow-primary-200">
                                S'inscrire
                            </x-button>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4 text-white">
                            <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                                <span class="font-bold">S</span>
                            </div>
                            <span class="text-xl font-bold tracking-tight">Sanar<span
                                    class="text-primary-500">Web</span></span>
                        </div>
                        <p class="max-w-xs text-sm leading-relaxed">
                            La plateforme communautaire dédiée aux étudiants pour faciliter la vie sur le campus.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">Lien utiles</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">À propos</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Confidentialité</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">Suivez-nous</h3>
                        <div class="flex space-x-4">
                            <!-- Icons placeholder -->
                        </div>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-slate-800 text-center text-xs">
                    <p>&copy; {{ date('Y') }} SanarWeb. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-quad',
        });
    </script>
</body>

</html>