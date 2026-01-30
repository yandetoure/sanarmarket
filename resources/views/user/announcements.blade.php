@extends('layouts.dashboard')

@section('content')
    <div class="space-y-12">
        <!-- Premium List Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 pb-4" data-aos="fade-down">
            <div class="space-y-2">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 rounded-full bg-primary-50 text-primary-600 text-[10px] font-black uppercase tracking-widest border border-primary-100">Inventaire</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gestion de Marché</span>
                </div>
                <h1 class="text-4xl font-display font-black text-slate-900 leading-tight">
                    Mes <span class="text-gradient">Annonces</span>
                </h1>
                <p class="text-slate-500 font-medium max-w-lg">Optimisez la visibilité de vos produits et gérez vos publications en temps réel.</p>
            </div>
            <div class="flex items-center space-x-4">
                <x-button href="{{ route('announcements.create') }}" variant="primary" size="lg"
                    class="rounded-2xl shadow-2xl shadow-primary-500/25 py-5 px-8 group">
                    <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Nouvelle Annonce</span>
                </x-button>
            </div>
        </div>

        <!-- High-Impact Stats Hub -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-100/50 group hover:bg-white transition-all duration-500">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Volume de Vente</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-display font-black text-slate-900 leading-none">{{ $stats['total'] }}</p>
                    <span class="text-[10px] font-bold text-slate-400">Total</span>
                </div>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-emerald-50/50 group hover:bg-white transition-all duration-500">
                <p class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-3">En Ligne</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-display font-black text-slate-900 leading-none">{{ $stats['active'] }}</p>
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mb-1"></div>
                </div>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-orange-50/50 group hover:bg-white transition-all duration-500">
                <p class="text-[9px] font-black text-orange-500 uppercase tracking-[0.2em] mb-3">Modération</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-display font-black text-slate-900 leading-none">{{ $stats['pending'] }}</p>
                    <span class="text-[10px] font-bold text-orange-400">En attente</span>
                </div>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-primary-50/50 group hover:bg-white transition-all duration-500">
                <p class="text-[9px] font-black text-primary-500 uppercase tracking-[0.2em] mb-3">Visibilité Max</p>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-display font-black text-slate-900 leading-none">{{ $stats['featured'] }}</p>
                    <span class="text-primary-400">✨</span>
                </div>
            </div>
        </div>

        <!-- Premium Inventory Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            @forelse($announcements as $index => $announcement)
                <div class="glass rounded-[3rem] border-white/80 shadow-2xl shadow-slate-200/50 overflow-hidden group hover:-translate-y-3 transition-all duration-700 relative"
                    data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">

                    <div class="aspect-[1/1] bg-slate-100 overflow-hidden relative">
                        <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        
                        <!-- Premium Badges Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="absolute top-5 right-5 z-10 flex flex-col space-y-2">
                            <div class="glass-light rounded-xl px-3 py-1.5 backdrop-blur-md bg-white/90 border-white shadow-lg text-[9px] font-black uppercase tracking-widest text-slate-900">
                                {{ ucfirst($announcement->status) }}
                            </div>
                            @if($announcement->featured)
                                <div class="bg-primary-500 rounded-xl px-3 py-1.5 shadow-lg shadow-primary-500/30 text-[9px] font-black uppercase tracking-widest text-white border border-primary-400">
                                    En vedette
                                </div>
                            @endif
                        </div>

                        <div class="absolute inset-x-5 bottom-5 flex justify-between items-end transform translate-y-10 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500">
                            <div class="bg-white/95 backdrop-blur shadow-xl rounded-2xl p-4 flex-grow mr-3">
                                <p class="text-[9px] font-black text-primary-600 uppercase tracking-widest mb-1">{{ $announcement->category->name }}</p>
                                <p class="text-sm font-black text-slate-900 truncate leading-none uppercase">{{ number_format($announcement->price, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-4">
                        <h3 class="text-lg font-display font-black text-slate-900 group-hover:text-primary-600 transition-colors truncate">
                            {{ $announcement->title }}
                        </h3>
                        
                        <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest border-f border-slate-50 pt-2">
                            <span>Mis en ligne</span>
                            <span class="text-slate-900 font-black">{{ $announcement->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                            <x-button href="{{ route('announcements.edit', $announcement) }}" variant="secondary" size="sm"
                                class="rounded-2xl bg-slate-50 border-transparent hover:bg-primary-50 hover:text-primary-600 py-4 font-black uppercase tracking-widest text-[9px]">
                                Modifier
                            </x-button>
                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="w-full"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full h-full flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all py-4 font-black uppercase tracking-widest text-[9px]">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-40 text-center glass rounded-[4rem] border-white shadow-2xl" data-aos="zoom-in">
                    <div class="w-32 h-32 bg-slate-50 rounded-[3rem] flex items-center justify-center mx-auto mb-10 shadow-inner group relative">
                        <div class="absolute inset-0 bg-primary-100 rounded-[3rem] group-hover:scale-125 opacity-0 group-hover:opacity-50 blur-2xl transition-all duration-700"></div>
                        <svg class="w-16 h-16 text-slate-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-display font-black text-slate-900 mb-4">Votre inventaire est vide</h3>
                    <p class="text-slate-400 font-medium mb-12 max-w-sm mx-auto leading-relaxed">Vendez ce dont vous n'avez plus besoin et commencez à gagner de l'argent sur le Sanar Market.</p>
                    <x-button href="{{ route('announcements.create') }}" variant="primary" size="lg"
                        class="rounded-3xl shadow-2xl shadow-primary-500/30 px-12 py-6">
                        Publier mon premier article
                    </x-button>
                </div>
            @endforelse
        </div>

        <!-- Custom Pagination System -->
        @if($announcements->hasPages())
            <div class="mt-20 pt-10 border-t border-slate-100 flex justify-center text-gradient font-black">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
@endsection