@extends('layouts.admin')

@section('title', 'Gestion des Sous-catégories')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Sous-catégories</h1>
        <p class="text-gray-600 mt-2">Organisez les sous-catégories de votre plateforme</p>
    </div>
    <a href="{{ route('admin.subcategories.create') }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors flex items-center gap-2">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Nouvelle Sous-catégorie
    </a>
</div>

<!-- Liste des sous-catégories -->
<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">Liste des Sous-catégories</h2>
    </div>
    
    @if($subcategories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-catégorie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie Parente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($subcategories as $subcategory)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="tags" class="w-5 h-5 text-amber-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $subcategory->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="tag" class="w-4 h-4 text-orange-600"></i>
                                    </div>
                                    <div class="ml-2">
                                        <div class="text-sm font-medium text-gray-900">{{ $subcategory->category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $subcategory->slug }}</code>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ Str::limit($subcategory->description, 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.subcategories.destroy', $subcategory) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette sous-catégorie ?')">
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
            {{ $subcategories->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="tags" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune sous-catégorie</h3>
            <p class="text-gray-500 mb-6">Commencez par créer votre première sous-catégorie.</p>
            <a href="{{ route('admin.subcategories.create') }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors inline-flex items-center gap-2">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Créer une sous-catégorie
            </a>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

