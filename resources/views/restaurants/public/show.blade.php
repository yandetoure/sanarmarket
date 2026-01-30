@extends('layouts.app')

@section('title', $restaurant->name . ' - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('restaurants.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Retour aux restaurants
        </a>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-slate-200 mb-8">
        @if($restaurant->cover_image)
        <div class="aspect-video relative overflow-hidden bg-slate-100">
            <img src="{{ asset('storage/' . $restaurant->cover_image) }}" 
                 alt="{{ $restaurant->name }}"
                 class="w-full h-full object-cover">
        </div>
        @endif
        
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $restaurant->name }}</h1>
            
            @if($restaurant->description)
            <p class="text-lg text-muted-foreground mb-6">{{ $restaurant->description }}</p>
            @endif
            
            <div class="flex flex-wrap gap-4 mb-6">
                @if($restaurant->address)
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span>{{ $restaurant->address }}</span>
                </div>
                @endif
                @if($restaurant->phone)
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="phone" class="w-5 h-5"></i>
                    <span>{{ $restaurant->phone }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2 text-muted-foreground">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>{{ $restaurant->user->name }}</span>
                </div>
            </div>

            @if($restaurant->metadata)
            <div class="flex flex-wrap gap-3 mb-6">
                @if(isset($restaurant->metadata['cuisine_type']))
                <div class="bg-amber-100 text-amber-800 px-4 py-2 rounded-lg">
                    <span class="text-sm font-medium">Type de cuisine: {{ $restaurant->metadata['cuisine_type'] }}</span>
                </div>
                @endif
                @if(isset($restaurant->metadata['price_range']))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                    <span class="text-sm font-medium">Gamme de prix: {{ $restaurant->metadata['price_range'] }}</span>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if($restaurant->menuItems->count() > 0)
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Menu</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($restaurant->menuItems as $menuItem)
                <div class="bg-white rounded-3xl overflow-hidden shadow-[0_20px_60px_-40px_rgba(15,23,42,0.55)] hover:shadow-[0_30px_80px_-45px_rgba(14,116,144,0.45)] transition-all hover:-translate-y-1 border border-slate-200">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-amber-100 to-orange-50">
                            <i data-lucide="utensils-crossed" class="w-16 h-16 text-amber-400"></i>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h3 class="font-semibold text-xl text-slate-900 line-clamp-1">{{ $menuItem->title }}</h3>
                            <p class="rounded-full bg-primary/10 px-3 py-1 text-base font-semibold text-primary whitespace-nowrap">
                                {{ number_format($menuItem->price, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                        
                        @if($menuItem->description)
                        <p class="text-muted-foreground line-clamp-2 mb-4">
                            {{ $menuItem->description }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-2 text-green-600 mb-4">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span class="text-sm font-medium">Disponible</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-3xl border border-slate-200">
        <i data-lucide="utensils-crossed" class="w-16 h-16 text-muted-foreground mx-auto mb-4"></i>
        <p class="text-muted-foreground text-lg">Aucun plat disponible pour le moment</p>
    </div>
    @endif

    @if($restaurant->schedules->count() > 0)
    <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-slate-200">
        <div class="p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Horaires d'ouverture</h2>
            <div class="space-y-3">
                @php
                    $days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                @endphp
                @foreach($restaurant->schedules as $schedule)
                <div class="flex items-center justify-between py-3 border-b border-slate-200 last:border-0">
                    <span class="font-medium text-gray-900">{{ $days[$schedule->day_of_week] }}</span>
                    @if($schedule->is_closed)
                        <span class="text-red-600 font-medium">Fermé</span>
                    @else
                        <span class="text-gray-700">{{ $schedule->opens_at }} - {{ $schedule->closes_at }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

