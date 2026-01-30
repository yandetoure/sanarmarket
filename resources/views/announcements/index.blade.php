@extends('layouts.app')

@section('title', 'Marketplace Étudiant')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <!-- Marketplace Hero -->
        <header class="relative py-20 overflow-hidden bg-slate-900">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/marketplace.png') }}" alt="" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div data-aos="fade-up">
                    <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                        Trouvez tout ce qu'il vous <span class="text-gradient">faut</span>.
                    </h1>
                    <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                        Le marché officiel de la communauté étudiante de Sanar. Achetez, vendez et échangez en toute
                        sécurité.
                    </p>

                    <!-- Search Bar -->
                    <div class="max-w-2xl mx-auto">
                        <form method="GET" action="{{ route('announcements.index') }}"
                            class="glass p-2 rounded-2xl flex items-center border-white/10 shadow-2xl">
                            <div class="flex-grow relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-12 pr-4 py-3 bg-transparent border-none text-white placeholder-slate-400 focus:ring-0 sm:text-sm"
                                    placeholder="Que cherchez-vous aujourd'hui ?">
                            </div>
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <x-button type="submit" variant="primary" size="md"
                                class="rounded-xl px-8 shadow-xl shadow-primary-500/20">
                                Rechercher
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Filters & Results -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Categories Chips -->
            <div class="flex flex-wrap items-center gap-3 mb-12" data-aos="fade-up">
                <a href="{{ route('announcements.index', request('search') ? ['search' => request('search')] : []) }}"
                    class="px-6 py-2.5 rounded-2xl text-sm font-bold transition-all {{ !request('category') || request('category') === 'all' ? 'bg-primary-600 text-white shadow-xl shadow-primary-200' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Toutes les catégories
                </a>
                @foreach(\App\Models\Category::all() as $category)
                    <a href="{{ route('announcements.index', array_merge(request('search') ? ['search' => request('search')] : [], ['category' => $category->slug])) }}"
                        class="px-6 py-2.5 rounded-2xl text-sm font-bold transition-all {{ request('category') === $category->slug ? 'bg-primary-600 text-white shadow-xl shadow-primary-200' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center justify-between mb-8" data-aos="fade-up">
                <div>
                    <h2 class="text-2xl font-display font-bold text-slate-900">
                        @if(request('category'))
                            {{ \App\Models\Category::where('slug', request('category'))->first()->name ?? 'Résultats' }}
                        @else
                            Toutes les annonces
                        @endif
                    </h2>
                    <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">
                        {{ $announcements->total() }} annonce{{ $announcements->total() > 1 ? 's' : '' }}
                        trouvée{{ $announcements->total() > 1 ? 's' : '' }}
                    </p>
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-slate-400">Trier par :</span>
                    <select
                        class="bg-white border-slate-200 rounded-xl text-sm font-bold text-slate-600 focus:ring-primary-500 focus:border-primary-500 px-4 py-2">
                        <option>Plus récents</option>
                        <option>Prix croissant</option>
                        <option>Prix décroissant</option>
                    </select>
                </div>
            </div>

            @if($announcements->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($announcements as $index => $announcement)
                        <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                            <x-card :title="$announcement->title" :price="$announcement->price"
                                :image="storage_url($announcement->media->first()?->path)" :category="$announcement->category->name"
                                :url="route('announcements.show', $announcement)" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    {{ $announcements->appends(request()->query())->links() }}
                </div>
            @else
                <div class="py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucune annonce trouvée</h3>
                    <p class="text-slate-500 mb-8 max-w-xs mx-auto">Nous n'avons trouvé aucun résultat pour votre recherche
                        actuelle. Essayez de réinitialiser les filtres.</p>
                    <x-button href="{{ route('announcements.index') }}" variant="secondary">Voir toutes les annonces</x-button>
                </div>
            @endif
        </main>
    </div>
@endsection