@extends('layouts.designer')
@section('title', 'Personnaliser le Thème')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Personnaliser le Thème</h1>
</div>
@if(session('success'))
    <div class="bg-green-100 p-4 mb-6 rounded">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('designer.save-customization') }}" enctype="multipart/form-data">
@csrf
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-4">Logo</h2>
    @if($settings->logo_url)<img src="{{ $settings->logo_url }}" alt="Logo" class="w-32 h-32 mb-4">@endif
    <input type="file" name="logo" accept="image/*">
</div>
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-4">Couleurs Sidebar</h2>
    <label>Fond: <input type="color" name="sidebar_bg_color" value="{{ $settings->sidebar_bg_color }}"></label>
    <label>Texte: <input type="color" name="sidebar_text_color" value="{{ $settings->sidebar_text_color }}"></label>
    <label>Actif BG: <input type="color" name="sidebar_active_bg" value="{{ $settings->sidebar_active_bg }}"></label>
    <label>Actif Texte: <input type="color" name="sidebar_active_text" value="{{ $settings->sidebar_active_text }}"></label>
</div>
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-4">Couleurs Navbar</h2>
    <label>Fond: <input type="color" name="navbar_bg_color" value="{{ $settings->navbar_bg_color }}"></label>
    <label>Texte: <input type="color" name="navbar_text_color" value="{{ $settings->navbar_text_color }}"></label>
    <label>Accent: <input type="color" name="navbar_accent_color" value="{{ $settings->navbar_accent_color }}"></label>
</div>
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-4">Couleurs Principales</h2>
    <label>Primaire: <input type="color" name="primary_color" value="{{ $settings->primary_color }}"></label>
    <label>Secondaire: <input type="color" name="secondary_color" value="{{ $settings->secondary_color }}"></label>
    <label>Accent: <input type="color" name="accent_color" value="{{ $settings->accent_color }}"></label>
</div>
<div class="mb-6">
    <label>Police: <select name="font_family">
        <option value="Inter" {{ $settings->font_family === 'Inter' ? 'selected' : '' }}>Inter</option>
        <option value="Roboto" {{ $settings->font_family === 'Roboto' ? 'selected' : '' }}>Roboto</option>
        <option value="Poppins" {{ $settings->font_family === 'Poppins' ? 'selected' : '' }}>Poppins</option>
    </select></label>
    <label>Taille: <input type="range" name="font_size" min="12" max="24" value="{{ $settings->font_size }}"></label>
</div>
<button type="submit" class="bg-pink-600 text-white px-6 py-3 rounded">Enregistrer</button>
<a href="{{ route('designer.dashboard') }}" class="bg-gray-200 px-6 py-3 rounded">Retour</a>
</form>
<script>lucide.createIcons();</script>
@endsection

