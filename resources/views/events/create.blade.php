@extends('layouts.app')

@section('title', 'Créer un événement - Sanar Market')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Créer un événement</h1>
        <p class="text-muted-foreground">
            Publiez un événement qui aura lieu au sein du campus
        </p>
    </div>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg border border-slate-200 p-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-semibold text-slate-900 mb-2">Titre *</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title') }}"
                   required
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-900 mb-2">Description *</label>
            <textarea id="description" 
                      name="description" 
                      rows="5"
                      required
                      class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-sm font-semibold text-slate-900 mb-2">Date de début *</label>
                <input type="datetime-local" 
                       id="start_date" 
                       name="start_date" 
                       value="{{ old('start_date') }}"
                       required
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_date" class="block text-sm font-semibold text-slate-900 mb-2">Date de fin</label>
                <input type="datetime-local" 
                       id="end_date" 
                       name="end_date" 
                       value="{{ old('end_date') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="location" class="block text-sm font-semibold text-slate-900 mb-2">Lieu</label>
            <input type="text" 
                   id="location" 
                   name="location" 
                   value="{{ old('location') }}"
                   placeholder="Ex: Amphi A, Terrasse du restaurant..."
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-semibold text-slate-900 mb-2">Image</label>
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/*"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-primary text-primary-foreground px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Créer l'événement
            </button>
            <a href="{{ route('events.index') }}" class="bg-slate-200 text-slate-700 px-6 py-2 rounded-lg hover:bg-slate-300 transition-colors">
                Annuler
            </a>
        </div>
    </form>
</div>

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

