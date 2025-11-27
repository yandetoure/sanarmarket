@extends('layouts.app')

@section('title', 'Modifier l\'annonce - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier l'annonce</h1>
        <p class="text-muted-foreground">
            Modifiez les informations de votre annonce.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-border p-6">
        <form method="POST" action="{{ route('announcements.update', $announcement) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       required 
                       value="{{ old('title', $announcement->title) }}"
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
                          placeholder="Décrivez votre annonce en détail...">{{ old('description', $announcement->description) }}</textarea>
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
                           value="{{ old('price', $announcement->price) }}"
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
                            <option value="{{ $category->id }}" {{ old('category_id', $announcement->category_id) == $category->id ? 'selected' : '' }}>
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
                       value="{{ old('location', $announcement->location) }}"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('location') border-red-500 @enderror"
                       placeholder="ex: Campus Jussieu, Paris">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Téléphone *
                </label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       required 
                       value="{{ old('phone', $announcement->phone) }}"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('phone') border-red-500 @enderror"
                       placeholder="+221 77 123 45 67">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @php
                $limit = $mediaLimit ?? 3;
                $accept = ($canUploadVideo ?? false)
                    ? 'image/*,video/mp4,video/quicktime,video/x-msvideo'
                    : 'image/*';
            @endphp
            <div class="space-y-4">
                <div>
                    <label for="media" class="block text-sm font-medium text-gray-700 mb-2">
                        Ajouter des médias (optionnel)
                    </label>
                    <input type="file" 
                           id="media" 
                           name="media[]" 
                           accept="{{ $accept }}"
                           multiple
                           class="w-full px-3 py-2 border border-border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('media') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-muted-foreground">
                        {{ ($canUploadVideo ?? false) ? 'Images (JPEG, PNG, JPG, GIF) et vidéos (MP4, MOV, AVI)' : 'Images (JPEG, PNG, JPG, GIF)' }} • Taille max 20MB par fichier • {{ $limit }} fichiers maximum par annonce.
                    </p>
                    @if(!($canUploadVideo ?? false))
                        <p class="mt-1 text-xs text-amber-600">
                            Passez en Premium pour ajouter des vidéos et jusqu'à 10 médias par annonce.
                        </p>
                    @endif
                    @error('media')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($errors->has('media.*'))
                        @foreach($errors->get('media.*') as $mediaErrors)
                            @foreach((array) $mediaErrors as $mediaError)
                                <p class="mt-1 text-sm text-red-600">{{ $mediaError }}</p>
                            @endforeach
                        @endforeach
                    @endif
                </div>

                @if($announcement->media->count())
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Médias existants (cliquez pour en supprimer) :</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($announcement->media as $media)
                                <label class="relative cursor-pointer group">
                                    <input type="checkbox" name="removed_media[]" value="{{ $media->id }}" class="sr-only peer">
                                    <div class="border border-border rounded-lg overflow-hidden peer-checked:ring-2 peer-checked:ring-red-500 peer-checked:border-red-500">
                                        @if($media->isVideo())
                                            <video src="{{ $media->url }}" class="w-full h-32 object-cover" controls muted></video>
                                        @else
                                            <img src="{{ $media->url }}" alt="Media" class="w-full h-32 object-cover">
                                        @endif
                                    </div>
                                    <span class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full opacity-0 peer-checked:opacity-100">
                                        Supprimer
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-muted-foreground">Cochez les médias à retirer avant de sauvegarder.</p>
                    </div>
                @endif
            </div>

            <div class="flex gap-4 pt-6">
                <a href="{{ route('announcements.show', $announcement) }}" 
                   class="flex-1 bg-white border border-border text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Annuler
                </a>
                <button type="submit" 
                        class="flex-1 bg-primary text-primary-foreground py-2 px-4 rounded-lg hover:bg-primary/90 transition-colors">
                    Mettre à jour l'annonce
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
