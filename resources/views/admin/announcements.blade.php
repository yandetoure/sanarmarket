@extends('layouts.admin')

@section('title', 'Gestion des Annonces')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Annonces</h1>
        <p class="text-gray-600 mt-2">Modérez et gérez toutes les annonces</p>
    </div>
    <a href="{{ route('announcements.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Nouvelle Annonce
    </a>
</div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Actives</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $announcements->where('status', 'active')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i data-lucide="eye-off" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Masquées</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $announcements->where('status', 'hidden')->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $announcements->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i data-lucide="file-text" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $announcements->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des annonces -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Toutes les Annonces</h2>
        </div>
        
        @if($announcements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonce</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($announcements as $announcement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-4">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-lg object-cover" src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}">
                                        <div class="ml-2">
                                            <div class="text-xs font-medium text-gray-900 truncate max-w-xs">{{ Str::limit($announcement->title, 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $announcement->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $announcement->category->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $announcement->price }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcement->status === 'active' ? 'bg-green-100 text-green-800' : ($announcement->status === 'hidden' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $announcement->status === 'active' ? 'Active' : ($announcement->status === 'hidden' ? 'Masquée' : 'En attente') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('announcements.show', $announcement) }}" class="text-blue-600 hover:text-blue-900">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        
                                        @if($announcement->status === 'active')
                                            <form method="POST" action="{{ route('admin.announcements.hide', $announcement) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Masquer">
                                                    <i data-lucide="eye-off" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @elseif($announcement->status === 'hidden')
                                            <form method="POST" action="{{ route('admin.announcements.activate', $announcement) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Activer">
                                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($announcement->status === 'pending')
                                            <form method="POST" action="{{ route('admin.announcements.activate', $announcement) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900" title="Approuver">
                                                    <i data-lucide="check" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.announcements.pending', $announcement) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Mettre en attente">
                                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $announcements->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune annonce</h3>
                <p class="text-gray-500 mb-6">Aucune annonce trouvée.</p>
                <a href="{{ route('announcements.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors inline-flex items-center gap-2">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Créer une annonce
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
