@extends('layouts.app')

@section('title', 'Restaurants du Campus')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <!-- Hero Section -->
    <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=2000" alt="" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                    Où <span class="text-gradient">Manger</span> aujourd'hui ?
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Découvrez les restaurants du campus, leurs menus et leurs spécialités. Bon appétit !
                </p>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-12" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-display font-bold text-slate-900">Répertoire des Restaurants</h2>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">
                    {{ $restaurants->total() }} établissement{{ $restaurants->total() > 1 ? 's' : '' }} listé{{ $restaurants->total() > 1 ? 's' : '' }}
                </p>
            </div>
        </div>

        @if($restaurants->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($restaurants as $index => $restaurant)
                    <a href="{{ route('restaurants.public.show', $restaurant) }}" 
                       class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500"
                       data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="aspect-video relative overflow-hidden bg-slate-100">
                            @if($restaurant->cover_image)
                                <img src="{{ asset('storage/' . $restaurant->cover_image) }}" 
                                     alt="{{ $restaurant->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100/50">
                                    <svg class="w-16 h-16 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-4 py-2 rounded-xl border border-white/20">Voir les menus</span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-900 shadow-lg">
                                    Ouvert
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-display font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $restaurant->name }}</h3>
                                @if($restaurant->is_subscribed)
                                    <span class="bg-orange-50 text-orange-600 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg border border-orange-100">Partenaire</span>
                                @endif
                            </div>
                            
                            @if($restaurant->description)
                                <p class="text-sm text-slate-500 line-clamp-2 mb-6 font-medium leading-relaxed">
                                    {{ $restaurant->description }}
                                </p>
                            @endif
                            
                            <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
                                <div class="flex items-center text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-xs font-bold">{{ $restaurant->menu_items_count ?? 0 }} Plats</span>
                                </div>
                                <div class="flex items-center text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-xs font-bold truncate max-w-[120px]">{{ $restaurant->address ?? 'Campus' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $restaurants->links() }}
            </div>
        @else
            <div class="py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucun restaurant disponible</h3>
                <p class="text-slate-500 mb-8 max-w-xs mx-auto">La cuisine est fermée pour le moment. Revenez plus tard !</p>
            </div>
        @endif
    </main>
</div>
@endsection
