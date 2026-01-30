@extends('layouts.designer')
@section('title', 'Personnaliser le Thème')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Personnaliser le Thème</h1>
    <p class="text-gray-600 mt-2">Personnalisez l'apparence de votre espace designer</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('designer.save-customization') }}" enctype="multipart/form-data" class="space-y-6">
@csrf

<!-- Identité du site -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
        <i data-lucide="image" class="w-5 h-5 mr-2"></i>
        Identité du Site
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
            @if($settings->logo_url)
                <div class="mb-4">
                    <img src="{{ $settings->logo_url }}" alt="Logo actuel" class="w-32 h-32 object-contain border rounded">
                </div>
            @endif
            <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
            <p class="text-xs text-gray-500 mt-2">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</p>
        </div>
    </div>
</div>

<!-- Navbar -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
        <i data-lucide="sidebar" class="w-5 h-5 mr-2"></i>
        Barre de Navigation
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur de fond</label>
            <input type="color" name="navbar_bg_color" value="{{ $settings->navbar_bg_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur du texte</label>
            <input type="color" name="navbar_text_color" value="{{ $settings->navbar_text_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur d'accent</label>
            <input type="color" name="navbar_accent_color" value="{{ $settings->navbar_accent_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
    </div>
</div>

<!-- Sidebar -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
        <i data-lucide="layout" class="w-5 h-5 mr-2"></i>
        Barre Latérale
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur de fond</label>
            <input type="color" name="sidebar_bg_color" value="{{ $settings->sidebar_bg_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur du texte</label>
            <input type="color" name="sidebar_text_color" value="{{ $settings->sidebar_text_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur active (fond)</label>
            <input type="color" name="sidebar_active_bg" value="{{ $settings->sidebar_active_bg }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur active (texte)</label>
            <input type="color" name="sidebar_active_text" value="{{ $settings->sidebar_active_text }}" class="w-full h-12 rounded cursor-pointer">
        </div>
    </div>
</div>

<!-- Couleurs Principales -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
        <i data-lucide="palette" class="w-5 h-5 mr-2"></i>
        Couleurs Principales
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur Primaire</label>
            <input type="color" name="primary_color" value="{{ $settings->primary_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur Secondaire</label>
            <input type="color" name="secondary_color" value="{{ $settings->secondary_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Couleur Accent</label>
            <input type="color" name="accent_color" value="{{ $settings->accent_color }}" class="w-full h-12 rounded cursor-pointer">
        </div>
    </div>
</div>

<!-- Typographie -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="text-xl font-semibold mb-4 flex items-center">
        <i data-lucide="type" class="w-5 h-5 mr-2"></i>
        Typographie
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Police de caractères</label>
            <select name="font_family" class="w-full border rounded px-3 py-2">
        <option value="Inter" {{ $settings->font_family === 'Inter' ? 'selected' : '' }}>Inter</option>
                <option value="Roboto" {{ $settings->font_family === 'Roboto' ? 'selected' : '' }}>Roboto</option>
                <option value="Poppins" {{ $settings->font_family === 'Poppins' ? 'selected' : '' }}>Poppins</option>
                <option value="Open Sans" {{ $settings->font_family === 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                <option value="Montserrat" {{ $settings->font_family === 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Taille de police: <span id="fontSizeValue">{{ $settings->font_size }}px</span></label>
            <input type="range" name="font_size" min="12" max="24" value="{{ $settings->font_size }}" class="w-full" oninput="document.getElementById('fontSizeValue').textContent = this.value + 'px'">
        </div>
    </div>
</div>

<!-- Boutons -->
<div class="flex items-center justify-end gap-4">
    <a href="{{ route('designer.dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
        Annuler
    </a>
    <button type="submit" class="px-6 py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors flex items-center">
        <i data-lucide="save" class="w-4 h-4 mr-2"></i>
        Enregistrer les modifications
    </button>
</div>
</form>

<script>lucide.createIcons();</script>
@endsection

