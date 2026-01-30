@extends('layouts.dashboard')

@section('content')
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6" data-aos="fade-down">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900 leading-tight">Mes <span
                        class="text-gradient">Annonces</span></h1>
                <p class="text-slate-500 font-medium mt-1">Gérez vos publications et optimisez vos ventes sur la plateforme.
                </p>
            </div>
            <x-button href="{{ route('announcements.create') }}" variant="primary" size="lg"
                class="shadow-2xl shadow-primary-500/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle Annonce
            </x-button>
        </div>

        <!-- Animated Mini Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" data-aos="fade-up">
            <div class="glass-light p-6 rounded-[2rem] border-white/60 shadow-lg shadow-slate-100/50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-2xl font-display font-black text-slate-900">{{ $stats['total'] }}</p>
            </div>
            <div class="glass-light p-6 rounded-[2rem] border-white/60 shadow-lg shadow-emerald-50/50">
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Actives</p>
                <p class="text-2xl font-display font-black text-slate-900">{{ $stats['active'] }}</p>
            </div>
            <div class="glass-light p-6 rounded-[2rem] border-white/60 shadow-lg shadow-orange-50/50">
                <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">En attente</p>
                <p class="text-2xl font-display font-black text-slate-900">{{ $stats['pending'] }}</p>
            </div>
            <div class="glass-light p-6 rounded-[2rem] border-white/60 shadow-lg shadow-primary-50/50">
                <p class="text-[10px] font-black text-primary-500 uppercase tracking-widest mb-1">Featured</p>
                <p class="text-2xl font-display font-black text-slate-900">{{ $stats['featured'] }}</p>
            </div>
        </div>

        <!-- Announcements Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($announcements as $index => $announcement)
                <div class="glass rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50 overflow-hidden group hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500"
                    data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">

                    <div class="aspect-[4/3] bg-slate-100 overflow-hidden relative">
                        <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 right-4 z-10">
                            <x-badge
                                variant="{{ $announcement->status === 'active' ? 'emerald' : ($announcement->status === 'pending' ? 'orange' : 'slate') }}"
                                size="sm" class="shadow-lg backdrop-blur-md bg-white/80 border-white/50">
                                {{ ucfirst($announcement->status) }}
                            </x-badge>
                        </div>
                        <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/60 to-transparent">
                            <span
                                class="text-[10px] font-bold text-white uppercase tracking-widest opacity-80">{{ $announcement->category->name }}</span>
                        </div>
                    </div>

                    <div class="p-8">
                        <h3
                            class="text-lg font-display font-black text-slate-900 truncate group-hover:text-primary-600 transition-colors">
                            {{ $announcement->title }}</h3>
                        <p class="text-primary-600 font-bold mt-1 text-base">
                            {{ number_format($announcement->price, 0, ',', ' ') }} <span
                                class="text-xs uppercase ml-0.5">FCFA</span></p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">
                            {{ $announcement->created_at->format('d M Y') }}</p>

                        <div class="grid grid-cols-2 gap-3 mt-8">
                            <x-button href="{{ route('announcements.edit', $announcement) }}" variant="primary" size="sm"
                                class="rounded-2xl">
                                Modifier
                            </x-button>
                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="secondary" size="sm"
                                    class="w-full rounded-2xl text-red-600 hover:bg-red-50 hover:border-red-100">
                                    Supprimer
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <svg class="w-12 h-12 text-slate-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-black text-slate-900 mb-2">Pas encore d'annonce ?</h3>
                    <p class="text-slate-500 font-medium mb-10 max-w-xs mx-auto">Videz vos placards et gagnez de l'argent en
                        quelques clics.</p>
                    <x-button href="{{ route('announcements.create') }}" variant="primary" size="lg"
                        class="shadow-2xl shadow-primary-500/20">
                        Publier ma première annonce
                    </x-button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $announcements->links() }}
        </div>
    </div>
@endsection