@extends('layouts.marketing')

@section('title', 'Dashboard Marketing')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Marketing</h1>
    <p class="text-gray-600 mt-2">Gérez vos campagnes et analysez vos performances</p>
</div>

<div class="grid grid-cols 1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Publicités -->
    <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Publicités</p>
                <p class="text-3xl font-bold">{{ $totalAdvertisements }}</p>
            </div>
            <i data-lucide="image" class="w-12 h-12 text-green-100"></i>
        </div>
    </div>

    <!-- Publicités Actives -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Actives</p>
                <p class="text-3xl font-bold">{{ $activeAdvertisements }}</p>
            </div>
            <i data-lucide="check-circle" class="w-12 h-12 text-blue-100"></i>
        </div>
    </div>

    <!-- Annonces -->
    <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">Annonces</p>
                <p class="text-3xl font-bold">{{ $totalAnnouncements }}</p>
            </div>
            <i data-lucide="file-text" class="w-12 h-12 text-purple-100"></i>
        </div>
    </div>

    <!-- Annonces Actives -->
    <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Actives</p>
                <p class="text-3xl font-bold">{{ $activeAnnouncements }}</p>
            </div>
            <i data-lucide="trending-up" class="w-12 h-12 text-orange-100"></i>
        </div>
    </div>
</div>

<!-- Statistiques de Performance -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6  mb-8">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Vues</h3>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($performanceStats['views'], 0, ',', ' ') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Clics</h3>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($performanceStats['clicks'], 0, ',', ' ') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-2">Taux de Conversion</h3>
        <p class="text-2xl font-bold text-green-600">{{ $performanceStats['conversion'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Publicités Récentes -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Publicités Récentes</h2>
        </div>
        @if($recentAds->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($recentAds->take(5) as $ad)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $ad->title }}</p>
                            <p class="text-sm text-gray-500">{{ $ad->category->name }}</p>
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $ad->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                <p>Aucune publicité</p>
            </div>
        @endif
    </div>

    <!-- Annonces Récentes -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Annonces Récentes</h2>
        </div>
        @if($recentAnnouncements->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($recentAnnouncements->take(5) as $announcement)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $announcement->title }}</p>
                            <p class="text-sm text-gray-500">{{ $announcement->category->name }}</p>
                        </div>
                        <a href="{{ route('announcements.show', $announcement) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            Voir →
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                <p>Aucune annonce</p>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
@endsection

