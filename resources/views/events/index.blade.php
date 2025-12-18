@extends('layouts.app')

@section('title', 'Événements - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Événements du campus</h1>
            <p class="text-muted-foreground">
                Découvrez les événements qui ont lieu au sein du campus
            </p>
        </div>
        @auth
            @if(auth()->user()->isAmbassador())
                <a href="{{ route('events.create') }}" class="bg-primary text-primary-foreground px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Créer un événement
                </a>
            @endif
        @endauth
    </div>

    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <a href="{{ route('events.show', $event) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-primary/40 hover:shadow-md block">
                    @if($event->image)
                        <div class="aspect-video relative overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $event->image) }}" 
                                 alt="{{ $event->title }}"
                                 class="h-full w-full object-cover transition duration-500 ease-out group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-video relative overflow-hidden bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center">
                            <i data-lucide="calendar" class="w-16 h-16 text-primary/40"></i>
                        </div>
                    @endif
                    
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="text-xl font-semibold text-slate-900 line-clamp-2">{{ $event->title }}</h3>
                            @if($event->status === 'pending')
                                <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">
                                    En attente
                                </span>
                            @elseif($event->status === 'approved')
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">
                                    Approuvé
                                </span>
                            @endif
                        </div>
                        
                        <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                            {{ $event->description }}
                        </p>
                        
                        <div class="flex items-center gap-4 text-sm text-muted-foreground">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="calendar" class="h-4 w-4"></i>
                                <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($event->location)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                                    <span class="line-clamp-1">{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="calendar-x" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
            <p class="text-muted-foreground text-lg">Aucun événement disponible</p>
        </div>
    @endif
</div>

@auth
    @if(auth()->user()->isModerator())
        <div class="container mx-auto px-4 py-4 border-t">
            <h2 class="text-xl font-semibold mb-4">Événements en attente de validation</h2>
            @php
                $pendingEvents = \App\Models\Event::where('status', 'pending')->with('user')->latest()->get();
            @endphp
            @if($pendingEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($pendingEvents as $event)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-slate-900">{{ $event->title }}</h3>
                                    <p class="text-sm text-slate-600 mt-1">{{ $event->description }}</p>
                                    <p class="text-xs text-slate-500 mt-2">Créé par {{ $event->user->name }} le {{ $event->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('events.approve', $event) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                            Approuver
                                        </button>
                                    </form>
                                    <form action="{{ route('events.reject', $event) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                            Rejeter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted-foreground">Aucun événement en attente</p>
            @endif
        </div>
    @endif
@endauth

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

