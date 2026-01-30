@extends('layouts.designer')

@section('title', 'Dashboard Designer')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Designer</h1>
    <p class="text-gray-600 mt-2">Gérez vos créations et publicités</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Publicités -->
    <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-pink-100 text-sm font-medium mb-1">Total Publicités</p>
                <p class="text-3xl font-bold">{{ $totalAdvertisements }}</p>
            </div>
            <i data-lucide="image" class="w-12 h-12 text-pink-100"></i>
        </div>
    </div>

    <!-- Publicités Actives -->
    <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Actives</p>
                <p class="text-3xl font-bold">{{ $activeAdvertisements }}</p>
            </div>
            <i data-lucide="check-circle" class="w-12 h-12 text-green-100"></i>
        </div>
    </div>

    <!-- Mes Créations -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Mes Créations</p>
                <p class="text-3xl font-bold">{{ $myDesigns }}</p>
            </div>
            <i data-lucide="palette" class="w-12 h-12 text-blue-100"></i>
        </div>
    </div>
</div>

<!-- Publicités Récentes -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Publicités Récentes</h2>
    </div>
    
    @if($recentAds->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentAds as $ad)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $ad->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $ad->category->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $ad->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $ad->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-6 text-center text-gray-500">
            <p>Aucune publicité pour le moment</p>
        </div>
    @endif
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
@endsection

