@extends('layouts.app')

@section('title', 'Créer une Publicité - Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Créer une Publicité</h1>
            <p class="text-gray-600 mt-2">Ajoutez une nouvelle publicité à votre plateforme</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-6">
            <form method="POST" action="{{ route('admin.advertisements.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Titre -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre de la publicité</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenu</label>
                    <textarea id="content" name="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image (optionnel)</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lien -->
                <div class="mb-6">
                    <label for="link" class="block text-sm font-medium text-gray-700 mb-2">Lien (optionnel)</label>
                    <input type="url" id="link" name="link" value="{{ old('link') }}" placeholder="https://example.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('link')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type et Position -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="banner" {{ old('type') === 'banner' ? 'selected' : '' }}>Bannière</option>
                            <option value="popup" {{ old('type') === 'popup' ? 'selected' : '' }}>Popup</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                        <select id="position" name="position" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="hero" {{ old('position') === 'hero' ? 'selected' : '' }}>Section Hero</option>
                            <option value="popup" {{ old('position') === 'popup' ? 'selected' : '' }}>Popup</option>
                        </select>
                        @error('position')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Durées -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="display_duration" class="block text-sm font-medium text-gray-700 mb-2">Durée d'affichage (jours)</label>
                        <input type="number" id="display_duration" name="display_duration" value="{{ old('display_duration', 7) }}" min="1" max="365" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('display_duration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="popup_duration_field" style="display: none;">
                        <label for="popup_duration" class="block text-sm font-medium text-gray-700 mb-2">Durée popup (secondes)</label>
                        <input type="number" id="popup_duration" name="popup_duration" value="{{ old('popup_duration') }}" min="1" max="60" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('popup_duration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Date de début (optionnel)</label>
                        <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Date de fin (optionnel)</label>
                        <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Publicité active</span>
                    </label>
                </div>

                <!-- Boutons -->
                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Créer la publicité
                    </button>
                    <a href="{{ route('admin.advertisements.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
    
    // Afficher/masquer le champ durée popup selon le type
    document.getElementById('type').addEventListener('change', function() {
        const popupDurationField = document.getElementById('popup_duration_field');
        const popupDurationInput = document.getElementById('popup_duration');
        
        if (this.value === 'popup') {
            popupDurationField.style.display = 'block';
            popupDurationInput.required = true;
        } else {
            popupDurationField.style.display = 'none';
            popupDurationInput.required = false;
        }
    });
    
    // Initialiser l'état au chargement
    document.getElementById('type').dispatchEvent(new Event('change'));
</script>
@endsection






