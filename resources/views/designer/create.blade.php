@extends('layouts.designer')

@section('title', 'Créer une Publicité')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Créer une Publicité</h1>
    <p class="text-gray-600 mt-2">Ajoutez une nouvelle publicité à votre plateforme</p>
</div>

<div class="bg-white rounded-lg shadow-sm border p-6">
    <form method="POST" action="{{ route('designer.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Titre -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre de la publicité</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Catégorie -->
        <div class="mb-6">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
            <select id="category_id" name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500" required>
                <option value="">Sélectionner une catégorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image (optionnel)</label>
            <input type="file" id="image" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Statut -->
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Publicité active</span>
            </label>
        </div>

        <!-- Boutons -->
        <div class="flex items-center gap-4">
            <button type="submit" class="bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Créer la publicité
            </button>
            <a href="{{ route('designer.dashboard') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
    lucide.createIcons();
</script>
@endsection
