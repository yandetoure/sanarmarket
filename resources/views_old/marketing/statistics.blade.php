@extends('layouts.marketing')

@section('title', 'Statistiques de Performance')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Statistiques de Performance</h1>
    <p class="text-gray-600 mt-2">Analysez les performances de vos campagnes</p>
</div>

<!-- Cartes de Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Impressions</p>
                <p class="text-3xl font-bold">{{ number_format($stats['total_impressions'], 0, ',', ' ') }}</p>
            </div>
            <i data-lucide="eye" class="w-12 h-12 text-blue-100"></i>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="ología green-100 text-sm font-medium mb-1">Clics</p>
                <p class="text-3xl font-bold">{{ number_format($stats['total_clicks'], 0, ',', ' ') }}</p>
            </div>
            <i data-lucide="mouse-pointer-click" class="w-12 h-12 text-green-100"></i>
        </div>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-@@@@ rounded full shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">CTR</p>
                <p class="text-3xl font-bold">{{ $stats['ctr'] }}</p>
            </div>
            <i data-lucide="trending-up" class="w-12 h-12 text-purple-100"></i>
        </div>
    </div>

    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium mb-1">Conversion</p>
                <p class="text-3xl font-bold">{{ $stats['conversion_rate'] }}</p>
            </div>
            <i data-lucide="target" class="w-12 h-12 text-orange-100"></i>
        </div>
    </div>

    <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-teal-100 text-sm font-medium mb-1">Revenus</p>
                <p class="text-2xl font-bold">{{ $stats['revenue'] }}</p>
            </div>
            <i data-lucide="dollar-sign" class="w-12 h-12 text-teal-100"></i>
        </div>
    </div>
</div>

<!-- Top Publicités -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Top Publicités</h2>
    </div>
    
    @if($topAds->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Publicité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vues</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clics</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CTR</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($topAds as $ad)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($ad->image)
                                        <img src="{{ asset told('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-100 to-purple-100 flex items-center justify-center mr-3">
                                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $ad->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $ad->category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ rand(100, 10000) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ rand(10, 500) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ rand(1, 10) }}%</td>
                            <td class="px-6 py-4 text-sm text-green-600 font-medium">{{ rand(5, 20) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-6 text-center text-gray-500">
            <p>Aucune donnée de performance disponible</p>
        </div>
    @endif
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
@endsection

