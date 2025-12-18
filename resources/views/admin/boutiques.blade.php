@extends('layouts.admin')

@section('title', 'Gestion des Boutiques')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Boutiques</h1>
        <p class="text-gray-600 mt-2">Modérez et gérez toutes les boutiques</p>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-indigo-100 rounded-lg">
                <i data-lucide="store" class="w-6 h-6 text-indigo-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Boutiques</p>
                <p class="text-2xl font-bold text-gray-900">{{ $boutiques->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Approuvées</p>
                <p class="text-2xl font-bold text-gray-900">{{ $boutiques->where('validation_status', 'approved')->count() }}</p>
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
                <p class="text-2xl font-bold text-gray-900">{{ $boutiques->where('validation_status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i data-lucide="star" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Abonnées</p>
                <p class="text-2xl font-bold text-gray-900">{{ $boutiques->where('is_subscribed', true)->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Liste des boutiques -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Liste des Boutiques</h2>
    </div>
    
    @if($boutiques->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Boutique</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propriétaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Articles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abonnement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($boutiques as $boutique)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($boutique->cover_image)
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $boutique->cover_image) }}" alt="{{ $boutique->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                <i data-lucide="store" class="w-5 h-5 text-indigo-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $boutique->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($boutique->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $boutique->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $boutique->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $boutique->articles_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($boutique->status === 'active') bg-green-100 text-green-800
                                    @elseif($boutique->status === 'draft') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($boutique->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($boutique->validation_status === 'approved') bg-green-100 text-green-800
                                    @elseif($boutique->validation_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($boutique->validation_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $boutique->is_subscribed ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $boutique->is_subscribed ? 'Abonnée' : 'Non abonnée' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    @if($boutique->validation_status === 'pending')
                                        <form action="{{ route('admin.boutiques.approve', $boutique) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approuver">
                                                <i data-lucide="check" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.boutiques.reject', $boutique) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Rejeter">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.boutiques.toggle-subscription', $boutique) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-purple-600 hover:text-purple-900" title="{{ $boutique->is_subscribed ? 'Désabonner' : 'Abonner' }}">
                                            <i data-lucide="{{ $boutique->is_subscribed ? 'star' : 'star-off' }}" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('boutiques.public.show', $boutique) }}" class="text-blue-600 hover:text-blue-900" title="Voir">
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
            {{ $boutiques->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="store" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">Aucune boutique trouvée</p>
        </div>
    @endif
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
