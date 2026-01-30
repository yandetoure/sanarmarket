@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-display font-bold text-slate-900">Mes Annonces</h1>
                <p class="text-slate-500 mt-1">Gérez vos publications sur le marché Sanar.</p>
            </div>
            <x-button href="{{ route('announcements.create') }}" variant="primary" size="md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle Annonce
            </x-button>
        </div>

        <!-- Quick Stats for Announcements -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</p>
                <p class="text-xl font-display font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-emerald-500">Actives</p>
                <p class="text-xl font-display font-bold text-slate-900 mt-1">{{ $stats['active'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-orange-500">En attente</p>
                <p class="text-xl font-display font-bold text-slate-900 mt-1">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-primary-500">Mises en avant
                </p>
                <p class="text-xl font-display font-bold text-slate-900 mt-1">{{ $stats['featured'] }}</p>
            </div>
        </div>

        <!-- Announcements Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($announcements as $announcement)
                <div
                    class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group hover:shadow-md transition-all">
                    <div class="aspect-w-4 aspect-h-3 bg-slate-100 overflow-hidden relative">
                        <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-2 right-2">
                            <x-badge
                                variant="{{ $announcement->status === 'active' ? 'emerald' : ($announcement->status === 'pending' ? 'orange' : 'slate') }}"
                                size="xs">
                                {{ $announcement->status }}
                            </x-badge>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <span
                                class="text-[10px] font-bold text-primary-600 uppercase tracking-wider">{{ $announcement->category->name }}</span>
                            <span class="text-xs text-slate-400">{{ $announcement->created_at->format('d/m/Y') }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 truncate">{{ $announcement->title }}</h3>
                        <p class="text-primary-600 font-bold mt-1">{{ number_format($announcement->price, 0, ',', ' ') }} FCFA
                        </p>

                        <div class="grid grid-cols-2 gap-2 mt-6">
                            <x-button href="{{ route('announcements.edit', $announcement) }}" variant="secondary" size="xs">
                                Modifier
                            </x-button>
                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="ghost" size="xs"
                                    class="w-full text-red-600 hover:bg-red-50 hover:text-red-700">
                                    Supprimer
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[2rem] border-2 border-dashed border-slate-200">
                    <div
                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">Vous n'avez pas encore publié d'annonce.</p>
                    <x-button href="{{ route('announcements.create') }}" variant="primary" size="sm" class="mt-6">
                        Publier ma première annonce
                    </x-button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $announcements->links() }}
        </div>
    </div>
@endsection