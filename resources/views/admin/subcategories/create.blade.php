@extends('layouts.admin')

@section('title', 'Créer une Sous-catégorie')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Créer une Sous-catégorie</h1>
    <p class="text-gray-600 mt-2">Ajoutez une nouvelle sous-catégorie à votre plateforme</p>
</div>

<div class="bg-white rounded-lg shadow-sm border p-6 max-w-2xl">
    <form action="{{ route('admin.subcategories.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie Parente *</label>
            <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                <option value="">Sélectionnez une catégorie</option>
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
        
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la Sous-catégorie *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
            <p class="mt-1 text-sm text-gray-500">L'URL-friendly version du nom (ex: livres-scolaires)</p>
            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icône (optionnel)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="book" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
            <p class="mt-1 text-sm text-gray-500">Nom de l'icône Lucide (ex: book, laptop, etc.)</p>
            @error('icon')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (optionnel)</label>
            <textarea name="description" id="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.subcategories') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Créer la Sous-catégorie
            </button>
        </div>
    </form>
</div>

@section('scripts')
<script>
    lucide.createIcons();
    
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection

