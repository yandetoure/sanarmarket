@extends('layouts.app')

@section('title', 'Menus du Jour - Restau U')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <!-- Hero Section -->
        <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&q=80&w=2000"
                    alt="" class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div data-aos="fade-up">
                    <span
                        class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 backdrop-blur-md mb-6 uppercase tracking-widest">
                        🍔 Restauration Universitaire
                    </span>
                    <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                        Au <span class="text-orange-400">Menu</span> Aujourd'hui.
                    </h1>
                    <p class="text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                        Consultez en temps réel ce qui est servi au Restau 1 et au Restau 2. Évitez les files d'attente
                        inutiles !
                    </p>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Restaurant 1 -->
            <section class="mb-20">
                <div class="flex items-center space-x-4 mb-10" data-aos="fade-right">
                    <div
                        class="w-12 h-12 bg-primary-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-primary-200 font-display font-black text-xl">
                        1</div>
                    <div>
                        <h2 class="text-3xl font-display font-black text-slate-900">Restaurant 1</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Village UA</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Déjeuner -->
                    <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-display font-bold text-slate-900">Déjeuner</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">11:30 - 15:00</span>
                        </div>

                        <div class="bg-white/50 rounded-3xl p-6 border border-slate-100 min-h-[150px]">
                            @if($restau1Dejeuner)
                                <div class="prose prose-slate max-w-none text-slate-700 font-medium">
                                    {!! nl2br(e($restau1Dejeuner->menu_content)) !!}
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full py-8">
                                    <p class="text-slate-400 font-bold text-sm italic">Menu non disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Dîner -->
                    <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-display font-bold text-slate-900">Dîner</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">19:00 - 22:30</span>
                        </div>

                        <div class="bg-white/50 rounded-3xl p-6 border border-slate-100 min-h-[150px]">
                            @if($restau1Diner)
                                <div class="prose prose-slate max-w-none text-slate-700 font-medium">
                                    {!! nl2br(e($restau1Diner->menu_content)) !!}
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full py-8">
                                    <p class="text-slate-400 font-bold text-sm italic">Menu non disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- Restaurant 2 -->
            <section>
                <div class="flex items-center space-x-4 mb-10" data-aos="fade-right">
                    <div
                        class="w-12 h-12 bg-secondary-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-secondary-100 font-display font-black text-xl">
                        2</div>
                    <div>
                        <h2 class="text-3xl font-display font-black text-slate-900">Restaurant 2</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Village N</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Déjeuner -->
                    <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-display font-bold text-slate-900">Déjeuner</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">11:30 - 15:00</span>
                        </div>

                        <div class="bg-white/50 rounded-3xl p-6 border border-slate-100 min-h-[150px]">
                            @if($restau2Dejeuner)
                                <div class="prose prose-slate max-w-none text-slate-700 font-medium">
                                    {!! nl2br(e($restau2Dejeuner->menu_content)) !!}
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full py-8">
                                    <p class="text-slate-400 font-bold text-sm italic">Menu non disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Dîner -->
                    <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-display font-bold text-slate-900">Dîner</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">19:00 - 22:30</span>
                        </div>

                        <div class="bg-white/50 rounded-3xl p-6 border border-slate-100 min-h-[150px]">
                            @if($restau2Diner)
                                <div class="prose prose-slate max-w-none text-slate-700 font-medium">
                                    {!! nl2br(e($restau2Diner->menu_content)) !!}
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full py-8">
                                    <p class="text-slate-400 font-bold text-sm italic">Menu non disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Info Box -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <div class="bg-slate-900 rounded-[3rem] p-8 md:p-12 relative overflow-hidden" data-aos="zoom-in">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary-500 rounded-full blur-3xl opacity-20">
                </div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <h4 class="text-2xl font-display font-bold text-white mb-2">Un problème avec le menu ?</h4>
                        <p class="text-slate-400">Signalez toute erreur ou menu non mis à jour à nos ambassadeurs.</p>
                    </div>
                    <x-button variant="accent" size="lg">Contacter un Ambassadeur</x-button>
                </div>
            </div>
        </div>
    </div>
@endsection