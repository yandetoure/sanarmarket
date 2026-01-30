@extends('layouts.app')

@section('title', 'Modifier la Catégorie - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier la Catégorie</h1>
            <p class="text-gray-600 mt-2">Modifiez les informations de la catégorie</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-6">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')
                
                <!-- Nom -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug (URL)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    <p class="text-gray-500 text-sm mt-1">Utilisé dans l'URL (ex: livres, electronique)</p>
                    @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icône -->
                <div class="mb-6">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icône Lucide</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="book-open, laptop, etc." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                    <p class="text-gray-500 text-sm mt-1">Nom de l'icône Lucide (voir <a href="https://lucide.dev/icons" target="_blank" class="text-orange-600 hover:text-orange-800">lucide.dev</a>)</p>
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition-colors flex items-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection









