@extends('layouts.app')

@section('title', 'Boutiques du Campus')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <!-- Hero Section -->
    <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/marketplace.png') }}" alt="" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                    Les <span class="text-gradient">Boutiques</span> Pro du Campus.
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Découvrez les commerces officiels et les entrepreneurs du campus. Qualité et service garanti.
                </p>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-12" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-display font-bold text-slate-900">Répertoire des Boutiques</h2>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">
                    {{ $boutiques->total() }} établissement{{ $boutiques->total() > 1 ? 's' : '' }} vérifié{{ $boutiques->total() > 1 ? 's' : '' }}
                </p>
            </div>
        </div>

        @if($boutiques->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($boutiques as $index => $boutique)
                    <a href="{{ route('boutiques.public.show', $boutique) }}" 
                       class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500"
                       data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="aspect-video relative overflow-hidden bg-slate-100">
                            @if($boutique->cover_image)
                                <img src="{{ asset('storage/' . $boutique->cover_image) }}" 
                                     alt="{{ $boutique->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100/50">
                                    <svg class="w-16 h-16 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-4 py-2 rounded-xl border border-white/20">Voir la boutique</span>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-display font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $boutique->name }}</h3>
                                @if($boutique->is_subscribed)
                                    <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg border border-emerald-100">Premium</span>
                                @endif
                            </div>
                            
                            @if($boutique->description)
                                <p class="text-sm text-slate-500 line-clamp-2 mb-6 font-medium leading-relaxed">
                                    {{ $boutique->description }}
                                </p>
                            @endif
                            
                            <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
                                <div class="flex items-center text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <span class="text-xs font-bold">{{ $boutique->articles_count }} Articles</span>
                                </div>
                                @if($boutique->address)
                                    <div class="flex items-center text-slate-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="text-xs font-bold truncate max-w-[120px]">{{ $boutique->address }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $boutiques->links() }}
            </div>
        @else
            <div class="py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucune boutique disponible</h3>
                <p class="text-slate-500 mb-8 max-w-xs mx-auto">Le répertoire est vide en ce moment. Revenez plus tard ou créez votre boutique !</p>
                @auth
                    <x-button href="{{ route('boutiques.create') }}" variant="primary">Créer ma boutique</x-button>
                @endauth
            </div>
        @endif
    </main>
</div>
@endsection
