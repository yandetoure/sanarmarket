@extends('layouts.app')

@section('title', 'Détails de la Catégorie - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                    <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors flex items-center gap-2">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                        Modifier
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations de la catégorie -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <p class="text-gray-900">{{ $category->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $category->slug }}</code>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icône</label>
                    <div class="flex items-center gap-2">
                        <i data-lucide="{{ $category->icon }}" class="w-5 h-5 text-orange-600"></i>
                        <span class="text-gray-900">{{ $category->icon }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'annonces</label>
                    <p class="text-gray-900">{{ $category->announcements->count() }} annonce{{ $category->announcements->count() > 1 ? 's' : '' }}</p>
                </div>
            </div>
        </div>

        <!-- Annonces de cette catégorie -->
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Annonces dans cette catégorie</h2>
            </div>
            
            @if($category->announcements->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonce</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($category->announcements as $announcement)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-lg object-cover" src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($announcement->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $announcement->user->name }}
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
                                        <a href="{{ route('announcements.show', $announcement) }}" class="text-blue-600 hover:text-blue-900">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune annonce</h3>
                    <p class="text-gray-500">Aucune annonce dans cette catégorie pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection


