@extends('layouts.admin')

@section('title', 'Gestion des Restaurants')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Restaurants</h1>
        <p class="text-gray-600 mt-2">Gérez tous les restaurants</p>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
                <i data-lucide="utensils-crossed" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Restaurants</p>
                <p class="text-2xl font-bold text-gray-900">{{ $restaurants->total() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Approuvés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $restaurants->where('validation_status', 'approved')->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">En Attente</p>
                <p class="text-2xl font-bold text-gray-900">{{ $restaurants->where('validation_status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i data-lucide="star" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Abonnés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $restaurants->where('is_subscribed', true)->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des restaurants -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Liste des Restaurants</h2>
    </div>
    
    @if($restaurants->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propriétaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abonnement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($restaurants as $restaurant)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($restaurant->cover_image)
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $restaurant->cover_image) }}" alt="{{ $restaurant->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                                <i data-lucide="utensils-crossed" class="w-5 h-5 text-red-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $restaurant->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($restaurant->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $restaurant->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $restaurant->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $restaurant->menu_items_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($restaurant->status === 'active') bg-green-100 text-green-800
                                    @elseif($restaurant->status === 'draft') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($restaurant->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($restaurant->validation_status === 'approved') bg-green-100 text-green-800
                                    @elseif($restaurant->validation_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($restaurant->validation_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $restaurant->is_subscribed ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $restaurant->is_subscribed ? 'Abonné' : 'Non abonné' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    @if($restaurant->validation_status === 'pending')
                                        <form action="{{ route('admin.restaurants.approve', $restaurant) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approuver">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.restaurants.reject', $restaurant) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Rejeter">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.restaurants.toggle-subscription', $restaurant) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-purple-600 hover:text-purple-900" title="{{ $restaurant->is_subscribed ? 'Désabonner' : 'Abonner' }}">
                                            <i data-lucide="{{ $restaurant->is_subscribed ? 'star' : 'star-off' }}" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('restaurants.public.show', $restaurant) }}" class="text-blue-600 hover:text-blue-900" title="Voir">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t">
            {{ $restaurants->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="utensils-crossed" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">Aucun restaurant trouvé</p>
        </div>
    @endif
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

