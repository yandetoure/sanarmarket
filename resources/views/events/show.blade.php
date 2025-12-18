@extends('layouts.app')

@section('title', $event->title . ' - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Retour aux événements
    </a>

    <article class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden">
        @if($event->image)
            <div class="aspect-video relative overflow-hidden bg-slate-100">
                <img src="{{ asset('storage/' . $event->image) }}" 
                     alt="{{ $event->title }}"
                     class="h-full w-full object-cover">
            </div>
        @endif

        <div class="p-8">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $event->title }}</h1>
                    @if($event->status === 'pending')
                        <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-800">
                            En attente de validation
                        </span>
                    @elseif($event->status === 'approved')
                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800">
                            Événement approuvé
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mb-6 text-sm text-slate-600">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    <span><strong>Début:</strong> {{ $event->start_date->format('d/m/Y à H:i') }}</span>
                </div>
                @if($event->end_date)
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar-check" class="w-5 h-5"></i>
                        <span><strong>Fin:</strong> {{ $event->end_date->format('d/m/Y à H:i') }}</span>
                    </div>
                @endif
                @if($event->location)
                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                        <span><strong>Lieu:</strong> {{ $event->location }}</span>
                    </div>
                @endif
            </div>

            <div class="prose max-w-none mb-6">
                <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
            </div>

            <div class="border-t pt-4 text-sm text-slate-500">
                <p>Publié par <strong>{{ $event->user->name }}</strong> le {{ $event->created_at->format('d/m/Y à H:i') }}</p>
                @if($event->approved_at)
                    <p>Approuvé le {{ $event->approved_at->format('d/m/Y à H:i') }}</p>
                @endif
            </div>
        </div>
    </article>
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

