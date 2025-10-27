@extends('layouts.app')

@section('title', 'Créer une annonce - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Créer une nouvelle annonce</h1>
        <p class="text-muted-foreground">
            Remplissez les informations ci-dessous pour publier votre annonce.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-6">
        <form method="POST" action="{{ route('announcements.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       required 
                       value="{{ old('title') }}"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('title') border-red-500 @enderror"
                       placeholder="ex: Manuel de Mathématiques L1">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          required
                          class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('description') border-red-500 @enderror"
                          placeholder="Décrivez votre annonce en détail...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Prix *
                    </label>
                    <input type="text" 
                           id="price" 
                           name="price" 
                           required 
                           value="{{ old('price') }}"
                           class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('price') border-red-500 @enderror"
                           placeholder="ex: 15 000 FCFA">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie *
                    </label>
                    <select id="category_id" 
                            name="category_id" 
                            required
                            class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('category_id') border-red-500 @enderror">
                        <option value="">Choisir une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                    Campus / Ville *
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       required 
                       value="{{ old('location') }}"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('location') border-red-500 @enderror"
                       placeholder="ex: Campus Jussieu, Paris">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Image *
                </label>
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*"
                       required
                       class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-muted-foreground">
                    Formats acceptés : JPEG, PNG, JPG, GIF (max 2MB)
                </p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-6">
                <a href="{{ route('announcements.index') }}" 
                   class="flex-1 bg-white border border-border text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Annuler
                </a>
                <button type="submit" 
                        class="flex-1 bg-primary text-primary-foreground py-2 px-4 rounded-lg hover:bg-primary/90 transition-colors">
                    Publier l'annonce
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
