@extends('layouts.dashboard')

@section('content')
    <div class="space-y-10">
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6" data-aos="fade-down">
            <div>
                <h1 class="text-3xl md:text-4xl font-display font-black text-slate-900 leading-tight">
                    Ravi de vous revoir, <span class="text-gradient">{{ explode(' ', auth()->user()->name)[0] }}</span> ! 👋
                </h1>
                <p class="text-slate-500 font-medium mt-1">Voici l'activité de votre compte pour aujourd'hui.</p>
            </div>
            <div class="flex items-center space-x-4">
                <x-button href="{{ route('announcements.create') }}" variant="primary" size="lg"
                    class="shadow-2xl shadow-primary-500/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouvelle Annonce
                </x-button>
            </div>
        </div>

        <!-- Animated Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Stats Card 1 -->
            <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50 group hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500"
                data-aos="fade-up">
                <div class="flex items-center space-x-6">
                    <div
                        class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Mes Annonces</p>
                        <p class="text-3xl font-display font-black text-slate-900">
                            {{ auth()->user()->announcements()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Card 2 -->
            <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50 group hover:shadow-2xl hover:shadow-emerald-100 transition-all duration-500"
                data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center space-x-6">
                    <div
                        class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Boutiques</p>
                        <p class="text-3xl font-display font-black text-slate-900">
                            {{ auth()->user()->boutiques()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Card 3 -->
            <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50 group hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500"
                data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center space-x-6">
                    <div
                        class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Activités Forum</p>
                        <p class="text-3xl font-display font-black text-slate-900">
                            {{ auth()->user()->forumReplies()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-10">
            <!-- Recent Activity Area -->
            <div class="glass rounded-[3rem] border-white/60 shadow-xl shadow-slate-200/50 overflow-hidden flex flex-col"
                data-aos="fade-right">
                <div class="p-10 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-xl font-display font-black text-slate-900">Dernières Publications</h3>
                    <a href="{{ route('dashboard.announcements') }}"
                        class="text-[10px] font-black text-primary-600 uppercase tracking-widest hover:underline">Voir
                        tout</a>
                </div>
                <div class="flex-grow">
                    @forelse(auth()->user()->announcements()->latest()->take(5)->get() as $announcement)
                        <div class="p-8 flex items-center space-x-6 hover:bg-white/40 transition-colors group">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 overflow-hidden flex-shrink-0 shadow-sm">
                                <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="flex-grow min-w-0">
                                <p class="text-base font-bold text-slate-900 truncate">{{ $announcement->title }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                                    {{ $announcement->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <x-badge
                                    variant="{{ $announcement->status === 'active' ? 'emerald' : ($announcement->status === 'pending' ? 'orange' : 'slate') }}"
                                    size="sm">
                                    {{ ucfirst($announcement->status) }}
                                </x-badge>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-slate-400 font-bold italic">Aucune annonce récente.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Premium Upsell & Help -->
            <div class="space-y-10" data-aos="fade-left">
                <!-- Premium Card -->
                <div
                    class="bg-primary-600 rounded-[3rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-primary-200">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                    <div class="relative z-10">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black bg-white/20 text-white border border-white/30 backdrop-blur-md mb-6 uppercase tracking-widest">
                            🔥 Upgrade
                        </span>
                        <h3 class="text-2xl md:text-3xl font-display font-black leading-tight">Vendez 5x plus vite avec
                            <span class="text-orange-400">Premium</span></h3>
                        <p class="mt-4 text-primary-100 font-medium leading-relaxed">Mettez vos annonces en avant et
                            profitez de statistiques de visites détaillées.</p>
                        <x-button variant="secondary" size="lg"
                            class="mt-8 bg-white text-primary-600 border-none hover:bg-slate-50 shadow-xl shadow-primary-900/20">Découvrir
                            les offres</x-button>
                    </div>
                </div>

                <!-- Help Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="glass-light p-8 rounded-[2rem] border-white/50 shadow-lg shadow-slate-200/40">
                        <h4 class="font-display font-black text-slate-900 mb-2">Centre d'aide</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">Des guides pour maîtriser le
                            Sanar Market.</p>
                        <div class="space-y-3 font-bold text-[10px] uppercase tracking-widest text-primary-600">
                            <a href="#" class="block hover:underline">Comment vendre ? →</a>
                            <a href="#" class="block hover:underline">Règles du forum →</a>
                        </div>
                    </div>
                    <div class="glass-light p-8 rounded-[2rem] border-white/50 shadow-lg shadow-slate-200/40">
                        <h4 class="font-display font-black text-slate-900 mb-2">Support</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6">Un problème ? Notre équipe est
                            là.</p>
                        <x-button href="https://wa.me/221772319878" target="_blank" variant="secondary" size="sm"
                            class="w-full bg-emerald-50 text-emerald-600 border-emerald-100">Contacter Support</x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection