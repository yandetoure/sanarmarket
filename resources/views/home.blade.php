@extends('layouts.app')

@section('title', 'La plateforme campus nouvelle génération')

@section('content')
    <div class="relative overflow-hidden">
        <!-- Hero Section -->
        <section class="relative min-h-[90vh] flex items-center pt-20 pb-12 overflow-hidden">
            <!-- Background with Parallax effect -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/hero.png') }}" alt="" class="w-full h-full object-cover scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/40 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <div data-aos="fade-up">
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-primary-500/20 text-primary-400 border border-primary-500/30 backdrop-blur-md mb-6">
                            ✨ Bienvenue sur SanarWeb v2.0
                        </span>
                        <h1 class="text-5xl md:text-7xl font-display font-extrabold text-white leading-tight mb-6">
                            Vivez votre <span class="text-gradient">Campus</span> <br>
                            Comme jamais auparavant.
                        </h1>
                        <p class="text-xl text-slate-300 mb-10 leading-relaxed max-w-2xl">
                            La plateforme communautaire qui centralise tout ce dont vous avez besoin : marché étudiant,
                            menus du jour, événements et discussions en direct.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 mb-12">
                            <x-button href="{{ route('announcements.index') }}" variant="primary" size="lg" class="group">
                                Explorer le Marché
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </x-button>
                            <x-button href="{{ route('register') }}" variant="secondary" size="lg"
                                class="bg-white/10 border-white/20 text-white hover:bg-white/20 backdrop-blur-md">
                                Rejoindre la Communauté
                            </x-button>
                        </div>
                    </div>

                    <!-- Stats floating or bottom -->
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-white/10" data-aos="fade-up"
                        data-aos-delay="200">
                        <div>
                            <p class="text-3xl font-display font-bold text-white">2.5k+</p>
                            <p class="text-sm text-slate-400">Étudiants actifs</p>
                        </div>
                        <div>
                            <p class="text-3xl font-display font-bold text-white">500+</p>
                            <p class="text-sm text-slate-400">Annonces / jour</p>
                        </div>
                        <div>
                            <p class="text-3xl font-display font-bold text-white">15+</p>
                            <p class="text-sm text-slate-400">Services campus</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Card Example -->
            <div class="hidden lg:block absolute right-20 top-1/2 -translate-y-1/2 w-80 animate-float" data-aos="fade-left"
                data-aos-delay="400">
                <div class="glass p-6 rounded-[2.5rem] shadow-2xl border-white/40">
                    <div class="flex items-center space-x-4 mb-4">
                        <div
                            class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest leading-none">Vente
                                Flash</p>
                            <p class="text-sm font-bold text-slate-900 mt-1">iPhone 15 Pro Max</p>
                        </div>
                    </div>
                    <div class="aspect-square rounded-2xl bg-slate-100 mb-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1696446701796-da61225697cc?auto=format&fit=crop&q=80&w=400"
                            alt="" class="w-full h-full object-cover">
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-display font-bold text-slate-900">850.000 F</p>
                        <x-badge variant="emerald" size="xs">Disponible</x-badge>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-sm font-bold text-primary-600 uppercase tracking-widest mb-3">Services Campus</h2>
                    <h3 class="text-4xl md:text-5xl font-display font-extrabold text-slate-900 mb-6">Tout le Campus dans
                        votre <span class="text-gradient">Poche</span></h3>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto">Découvrez les outils essentiels pour optimiser votre
                        vie étudiante au quotidien.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @php
                        $services = [
                            [
                                'title' => 'Menu du Jour',
                                'desc' => 'Consultez les menus de Restau 1 et Restau 2 en temps réel.',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>',
                                'color' => 'blue',
                                'route' => 'campus-restaurant-menu.index'
                            ],
                            [
                                'title' => 'Infos Utiles',
                                'desc' => 'Pharmacies de garde, horaires de prière et contacts universitaires.',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                                'color' => 'emerald',
                                'route' => 'useful-info.index'
                            ],
                            [
                                'title' => 'Événements',
                                'desc' => 'Ne manquez aucune conférence, soirée ou activité culturelle.',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>',
                                'color' => 'purple',
                                'route' => 'events.index'
                            ],
                            [
                                'title' => 'Spotlight',
                                'desc' => 'Tout ce qui fait le buzz au campus, sélectionné pour vous.',
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"></path>',
                                'color' => 'orange',
                                'route' => 'campus-spotlight.index'
                            ]
                        ];
                    @endphp

                    @foreach($services as $index => $service)
                        <a href="{{ route($service['route']) }}"
                            class="group bg-slate-50 p-8 rounded-[2.5rem] border border-transparent hover:border-{{ $service['color'] }}-200 hover:bg-white hover:shadow-2xl hover:shadow-{{ $service['color'] }}-100 transition-all duration-500"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div
                                class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-{{ $service['color'] }}-600 shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 mb-6 border border-slate-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">@php echo $service['icon'] @endphp</svg>
                            </div>
                            <h4 class="text-xl font-display font-bold text-slate-900 mb-3">{{ $service['title'] }}</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $service['desc'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Marketplace Preview Section -->
        <section class="py-24 bg-slate-50 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary-100/50 rounded-full blur-3xl -mr-64 -mt-64">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-secondary-100/50 rounded-full blur-3xl -ml-64 -mb-64">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12" data-aos="fade-up">
                    <div>
                        <h2 class="text-sm font-bold text-secondary-600 uppercase tracking-widest mb-3">Le Marché</h2>
                        <h3 class="text-4xl font-display font-extrabold text-slate-900">Annonces <span
                                class="text-gradient">Récentes</span></h3>
                    </div>
                    <x-button href="{{ route('announcements.index') }}" variant="ghost" class="mt-4 md:mt-0">
                        Découvrir tout le catalogue
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </x-button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @forelse($announcements as $index => $announcement)
                        <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <x-card :title="$announcement->title" :price="$announcement->price"
                                :image="storage_url($announcement->media->first()?->path)"
                                :category="$announcement->category->name" :url="route('announcements.show', $announcement)" />
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center">
                            <p class="text-slate-400">Aucune annonce disponible pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Community Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-slate-900 rounded-[3rem] p-8 md:p-16 relative overflow-hidden" data-aos="zoom-in">
                    <!-- Decorative background -->
                    <div class="absolute inset-0 z-0">
                        <img src="{{ asset('images/marketplace.png') }}" alt=""
                            class="w-full h-full object-cover opacity-20">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                    </div>

                    <div class="relative z-10 grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h3 class="text-3xl md:text-5xl font-display font-extrabold text-white mb-6">Rejoignez la plus
                                grande communauté étudiante.</h3>
                            <p class="text-lg text-slate-400 mb-10">Plus de 5000 étudiants échangent, vendent et
                                s'entraident chaque jour sur SanarWeb. Ne restez pas en marge.</p>
                            <div class="flex flex-wrap gap-4">
                                <x-button href="{{ route('register') }}" variant="accent" size="lg">S'inscrire
                                    Maintenant</x-button>
                                <x-button href="{{ route('forum.index') }}" variant="secondary" size="lg"
                                    class="bg-white/10 border-white/20 text-white hover:bg-white/20 backdrop-blur-md">Consulter
                                    le Forum</x-button>
                            </div>
                        </div>
                        <div class="hidden lg:grid grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div class="glass p-6 rounded-3xl border-white/10 translate-y-8">
                                    <p class="text-white font-bold italic">"Incroyable plateforme, j'ai vendu mon ancien
                                        ordi en 2h !"</p>
                                    <p class="text-primary-400 text-xs mt-4 font-bold">@moussa_diop</p>
                                </div>
                                <div class="glass p-6 rounded-3xl border-white/10">
                                    <p class="text-white font-bold italic">"Le menu du restau m'évite de faire la queue pour
                                        rien."</p>
                                    <p class="text-primary-400 text-xs mt-4 font-bold">@fatou_ndoye</p>
                                </div>
                            </div>
                            <div class="space-y-4 pt-12">
                                <div class="glass p-6 rounded-3xl border-white/10">
                                    <p class="text-white font-bold italic">"Le forum d'entraide est super réactif."</p>
                                    <p class="text-primary-400 text-xs mt-4 font-bold">@omar_faye</p>
                                </div>
                                <div class="glass p-6 rounded-3xl border-white/10 -translate-y-8">
                                    <p class="text-white font-bold italic">"Un design enfin propre pour Sanar !"</p>
                                    <p class="text-primary-400 text-xs mt-4 font-bold">@aminta_kane</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        /* Additional custom animations not in tailwind config */
        @keyframes float {

            0%,
            100% {
                transform: translateY(-50%) translateY(0);
            }

            50% {
                transform: translateY(-50%) translateY(-20px);
            }
        }
    </style>
@endsection