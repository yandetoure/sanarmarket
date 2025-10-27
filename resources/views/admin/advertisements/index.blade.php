@extends('layouts.admin')

@section('title', 'Gestion des Publicités')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Publicités</h1>
        <p class="text-gray-600 mt-2">Créez et gérez les publicités de votre plateforme</p>
    </div>
    <a href="{{ route('admin.advertisements.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Nouvelle Publicité
    </a>
</div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i data-lucide="eye" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Publicités</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $advertisements->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Actives</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $advertisements->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i data-lucide="image" class="w-6 h-6 text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Bannières Hero</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $advertisements->where('position', 'hero')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i data-lucide="popup" class="w-6 h-6 text-orange-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Popups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $advertisements->where('type', 'popup')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des publicités -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Liste des Publicités</h2>
        </div>
        
        @if($advertisements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publicité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($advertisements as $advertisement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($advertisement->image)
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ $advertisement->image_url }}" alt="{{ $advertisement->title }}">
                                        @else
                                            <div class="h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $advertisement->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($advertisement->content, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $advertisement->type === 'popup' ? 'bg-orange-100 text-orange-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $advertisement->type === 'popup' ? 'Popup' : 'Bannière' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $advertisement->position === 'hero' ? 'Section Hero' : 'Popup' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $advertisement->formatted_duration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $advertisement->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $advertisement->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.advertisements.show', $advertisement) }}" class="text-blue-600 hover:text-blue-900">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.advertisements.edit', $advertisement) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.advertisements.toggle', $advertisement) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-{{ $advertisement->is_active ? 'red' : 'green' }}-600 hover:text-{{ $advertisement->is_active ? 'red' : 'green' }}-900">
                                                <i data-lucide="{{ $advertisement->is_active ? 'pause' : 'play' }}" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.advertisements.destroy', $advertisement) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publicité ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $advertisements->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i data-lucide="image" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune publicité</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre première publicité.</p>
                <a href="{{ route('admin.advertisements.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Créer une publicité
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
