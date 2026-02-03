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
        @if(auth()->user()->isAdmin())
            <!-- Super Admin Dashboard -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-200">
                        <span class="text-white text-lg">⚡</span>
                    </div>
                    <p class="text-[10px] font-black text-purple-600 uppercase tracking-[0.3em]">Super Admin</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-xl shadow-purple-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.dashboard') ? '' : 'group-hover:scale-110' }} transition-transform">🎯</span>
                        <span>Console Admin</span>
                    </a>
                </div>
            </div>

            <!-- Utilisateurs -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <span class="text-white text-lg">👥</span>
                    </div>
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Utilisateurs</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-xl shadow-blue-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.users*') ? '' : 'group-hover:scale-110' }} transition-transform">👤</span>
                        <span>Gestion Utilisateurs</span>
                    </a>
                </div>
            </div>

            <!-- Contenu & Annonces -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200">
                        <span class="text-white text-lg">📢</span>
                    </div>
                    <p class="text-[10px] font-black text-orange-600 uppercase tracking-[0.3em]">Contenu</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.announcements') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.announcements*') ? 'bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-xl shadow-orange-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.announcements*') ? '' : 'group-hover:scale-110' }} transition-transform">📢</span>
                        <span>Annonces</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.categories*') ? 'bg-gradient-to-r from-violet-600 to-purple-600 text-white shadow-xl shadow-violet-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-violet-50 hover:to-purple-50 hover:text-violet-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.categories*') ? '' : 'group-hover:scale-110' }} transition-transform">📁</span>
                        <span>Catégories</span>
                    </a>

                    <a href="{{ route('admin.subcategories') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.subcategories*') ? 'bg-gradient-to-r from-fuchsia-600 to-pink-600 text-white shadow-xl shadow-fuchsia-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-fuchsia-50 hover:to-pink-50 hover:text-fuchsia-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.subcategories*') ? '' : 'group-hover:scale-110' }} transition-transform">📂</span>
                        <span>Sous-catégories</span>
                    </a>
                </div>
            </div>

            <!-- Commerce -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                        <span class="text-white text-lg">🛒</span>
                    </div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em]">Commerce</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.boutiques') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.boutiques*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-xl shadow-emerald-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.boutiques*') ? '' : 'group-hover:scale-110' }} transition-transform">🏪</span>
                        <span>Boutiques</span>
                    </a>

                    <a href="{{ route('admin.restaurants') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.restaurants*') ? 'bg-gradient-to-r from-yellow-600 to-orange-600 text-white shadow-xl shadow-yellow-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 hover:text-yellow-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.restaurants*') ? '' : 'group-hover:scale-110' }} transition-transform">🍽️</span>
                        <span>Restaurants</span>
                    </a>
                </div>
            </div>

            <!-- Campus & Événements -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <span class="text-white text-lg">🎓</span>
                    </div>
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em]">Campus</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.events') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.events*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-xl shadow-indigo-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.events*') ? '' : 'group-hover:scale-110' }} transition-transform">🎉</span>
                        <span>Événements</span>
                    </a>

                    <a href="{{ route('admin.campus-spotlight') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.campus-spotlight*') ? 'bg-gradient-to-r from-pink-600 to-rose-600 text-white shadow-xl shadow-pink-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50 hover:text-pink-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.campus-spotlight*') ? '' : 'group-hover:scale-110' }} transition-transform">⭐</span>
                        <span>À la Une</span>
                    </a>

                    <a href="{{ route('admin.useful-info') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.useful-info*') ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-xl shadow-cyan-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-cyan-50 hover:to-blue-50 hover:text-cyan-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.useful-info*') ? '' : 'group-hover:scale-110' }} transition-transform">ℹ️</span>
                        <span>Infos Utiles</span>
                    </a>

                    <a href="{{ route('admin.campus-menus.index') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.campus-menus*') ? 'bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-xl shadow-orange-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.campus-menus*') ? '' : 'group-hover:scale-110' }} transition-transform">🍔</span>
                        <span>Restos Campus</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.subscription-plans.index') }}"
                class="nav-link group flex items-center px-6 py-4 text-sm font-bold text-slate-500 hover:bg-slate-50 hover:text-primary-600 transition-all duration-300 {{ request()->routeIs('admin.subscription-plans.*') ? 'active-nav-glow bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                <div
                    class="mr-4 p-2 rounded-xl bg-slate-100 text-slate-400 group-hover:bg-primary-100 group-hover:text-primary-600 transition-all duration-300 {{ request()->routeIs('admin.subscription-plans.*') ? 'bg-primary-100 text-primary-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Plans d'abonnement
            </a>

            <div class="px-6 py-4">
                <div class="h-px bg-slate-100"></div>
            </div>
            <!-- Paramètres -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-slate-500 to-gray-500 rounded-xl flex items-center justify-center shadow-lg shadow-slate-200">
                        <span class="text-white text-lg">⚙️</span>
                    </div>
                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">Paramètres</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('admin.customize') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.customize*') ? 'bg-gradient-to-r from-slate-600 to-gray-600 text-white shadow-xl shadow-slate-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-slate-50 hover:to-gray-50 hover:text-slate-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('admin.customize*') ? '' : 'group-hover:scale-110' }} transition-transform">🎨</span>
                        <span>Personnalisation</span>
                    </a>
                </div>
            </div>

            <!-- Status Widget -->
            <div class="glass p-6 rounded-3xl border border-white shadow-xl mx-3">
                <div class="flex items-center space-x-3 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-white text-xl">📊</span>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-600">Plateforme Active</p>
                        <p class="text-[10px] text-slate-400">Tout fonctionne ✨</p>
                    </div>
                </div>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Statut</span>
                        <span class="font-bold text-green-600">Opérationnel</span>
                    </div>
                </div>
            </div>


        @elseif(auth()->user()->isAmbassador())
            <!-- Ambassador Section -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <span class="text-white text-lg">🛡️</span>
                    </div>
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Ambassadeur</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('ambassador.dashboard') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('ambassador.dashboard') ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-xl shadow-blue-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('ambassador.dashboard') ? '' : 'group-hover:scale-110' }} transition-transform">🎯</span>
                        <span>Centre Validation</span>
                    </a>

                    <a href="{{ route('ambassador.boutiques.pending') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('ambassador.boutiques*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-xl shadow-emerald-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 hover:text-emerald-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('ambassador.boutiques*') ? '' : 'group-hover:scale-110' }} transition-transform">🏪</span>
                        <span>Boutiques</span>
                    </a>

                    <a href="{{ route('ambassador.restaurants.pending') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('ambassador.restaurants*') ? 'bg-gradient-to-r from-yellow-600 to-orange-600 text-white shadow-xl shadow-yellow-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-yellow-50 hover:to-orange-50 hover:text-yellow-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('ambassador.restaurants*') ? '' : 'group-hover:scale-110' }} transition-transform">🍽️</span>
                        <span>Restaurants</span>
                    </a>
                </div>
            </div>

            <!-- Univ Restaurants Management -->
            <div class="space-y-4">
                <div class="px-5 flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200">
                        <span class="text-white text-lg">🍔</span>
                    </div>
                    <p class="text-[10px] font-black text-orange-600 uppercase tracking-[0.3em]">Restos Campus</p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('ambassador.campus-menus.index') }}"
                        class="flex items-center px-5 py-4 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->routeIs('ambassador.campus-menus*') ? 'bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-xl shadow-orange-200' : 'text-slate-600 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 hover:shadow-lg' }}">
                        <span
                            class="h-5 w-5 mr-4 text-xl {{ request()->routeIs('ambassador.campus-menus*') ? '' : 'group-hover:scale-110' }} transition-transform">🍴</span>
                        <span>Gestion Menus</span>
                    </a>
                </div>
            </div>

        @else
            <!-- Standard User Section -->
            <div class="space-y-4">
                <p class="px-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Menu Principal</p>
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

            <!-- User Activity -->
            <div class="space-y-4">
                <p class="px-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Mon Activité</p>
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