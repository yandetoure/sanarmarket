<div class="flex flex-col h-full">
    <div class="flex h-24 shrink-0 items-center px-10">
        <a href="{{ route('home') }}" class="group flex items-center space-x-4">
            <div
                class="w-12 h-12 bg-gradient-to-br from-primary-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-display font-black text-2xl shadow-xl shadow-primary-200 group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                S
            </div>
            <div class="flex flex-col justify-center">
                <span class="text-2xl font-display font-black tracking-tight text-slate-900 leading-none">Sanar<span
                        class="text-primary-600">Web</span></span>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Espace Membre</span>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-6 py-8 space-y-10 overflow-y-auto custom-scrollbar">
        <!-- Main Navigation -->
        <div class="space-y-4">
            <p class="px-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Menu Principal</p>
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white/60 hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/40' }}">
                    <svg class="h-5 w-5 mr-4 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Tableau de bord</span>
                </a>
            </div>
        </div>

        <!-- Commerce & Marketplace -->
        <div class="space-y-4">
            <p class="px-5 text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Mon Activité</p>
            <div class="space-y-2">
                <a href="{{ route('dashboard.announcements') }}"
                    class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard.announcements') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white/60 hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/40' }}">
                    <svg class="h-5 w-5 mr-4 {{ request()->routeIs('dashboard.announcements') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Mes Annonces</span>
                </a>
                <a href="{{ route('dashboard.boutiques') }}"
                    class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard.boutiques') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white/60 hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/40' }}">
                    <svg class="h-5 w-5 mr-4 {{ request()->routeIs('dashboard.boutiques') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>Ma Boutique</span>
                </a>
                <a href="{{ route('dashboard.restaurants') }}"
                    class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('dashboard.restaurants') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white/60 hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/40' }}">
                    <svg class="h-5 w-5 mr-4 {{ request()->routeIs('dashboard.restaurants') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Mes Restaurants</span>
                </a>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            <!-- Administration -->
            <div class="space-y-4">
                <p class="px-5 text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em]">Administration</p>
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->is('admin/*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-slate-500 hover:bg-white/60 hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/40' }}">
                        <svg class="h-5 w-5 mr-4 {{ request()->is('admin/*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }} transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Espace Admin
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <div class="p-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex w-full items-center px-6 py-4 text-sm font-bold rounded-2xl text-red-500 hover:bg-red-50/50 transition-all group">
                <svg class="h-5 w-5 mr-4 text-red-400 group-hover:text-red-500 group-hover:-translate-x-1 transition-all"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</div>