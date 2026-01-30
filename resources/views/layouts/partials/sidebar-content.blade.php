<div class="flex flex-col h-full">
    <div class="flex h-20 shrink-0 items-center px-8">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-primary-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-display font-black text-xl shadow-lg shadow-primary-200">
                S</div>
            <span class="text-xl font-display font-black tracking-tight text-slate-900 leading-none">Sanar<span
                    class="text-primary-600">Web</span></span>
        </a>
    </div>

    <nav class="flex-1 space-y-2 p-6 overflow-y-auto custom-scrollbar">
        <div class="pb-6">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Général</p>
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3.5 text-sm font-bold rounded-[1.25rem] transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/50' }}">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Tableau de bord
            </a>
        </div>

        <div class="pb-6">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Mon Marché</p>
            <a href="{{ route('dashboard.announcements') }}"
                class="flex items-center px-4 py-3.5 text-sm font-bold rounded-[1.25rem] transition-all duration-300 group {{ request()->routeIs('dashboard.announcements') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/50' }}">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard.announcements') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Mes Annonces
            </a>
            <a href="{{ route('dashboard.boutiques') }}"
                class="flex items-center px-4 py-3.5 text-sm font-bold rounded-[1.25rem] transition-all duration-300 group {{ request()->routeIs('dashboard.boutiques') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/50' }}">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard.boutiques') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Ma Boutique
            </a>
        </div>

        <div class="pb-6">
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Restauration</p>
            <a href="{{ route('dashboard.restaurants') }}"
                class="flex items-center px-4 py-3.5 text-sm font-bold rounded-[1.25rem] transition-all duration-300 group {{ request()->routeIs('dashboard.restaurants') ? 'bg-primary-600 text-white shadow-xl shadow-primary-200 active-nav-glow' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/50' }}">
                <svg class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard.restaurants') ? 'text-white' : 'text-slate-400 group-hover:text-primary-500' }} transition-colors"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Mes Restaurants
            </a>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="pb-6">
                <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Administration</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3.5 text-sm font-bold rounded-[1.25rem] transition-all duration-300 group {{ request()->is('admin/*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-slate-500 hover:bg-white hover:text-slate-900 hover:shadow-lg hover:shadow-slate-200/50' }}">
                    <svg class="h-5 w-5 mr-3 {{ request()->is('admin/*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }} transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Espace Admin
                </a>
            </div>
        @endif
    </nav>

    <div class="p-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex w-full items-center px-4 py-3.5 text-sm font-bold rounded-[1.25rem] text-red-500 hover:bg-red-50 transition-all group">
                <svg class="h-5 w-5 mr-3 text-red-400 group-hover:text-red-500 transition-colors" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Déconnexion
            </button>
        </form>
    </div>
</div>