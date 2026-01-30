@extends('layouts.designer')
@section('title', 'Mon Profil')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Mon Profil</h1>
</div>
@if(session('success'))
    <div class="bg-green-100 p-4 mb-6 rounded">{{ session('success') }}</div>
@endif

<!-- Formulaire de modification du profil -->
<div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Informations personnelles</h2>
    <form method="POST" action="{{ route('designer.profile.update') }}">
    @csrf
    @method('PUT')
    <div class="mb-6">
        <label class="block mb-2">Nom: <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full border rounded px-3 py-2" required></label>
    </div>
    <div class="mb-6">
        <label class="block mb-2">Email: <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border rounded px-3 py-2" required></label>
    </div>
    <button type="submit" class="bg-pink-600 text-white px-6 py-3 rounded">Enregistrer les modifications</button>
    </form>
</div>

<!-- Formulaire de modification du mot de passe -->
<div class="bg-white rounded-lg shadow-sm border p-6">
    <h2 class="text-xl font-semibold mb-4">Modifier le mot de passe</h2>
    <form method="POST" action="{{ route('designer.profile.password.update') }}">
    @csrf
    @method('PUT')
    <div class="mb-6">
        <label class="block mb-2">Mot de passe actuel: <input type="password" name="current_password" class="w-full border rounded px-3 py-2" required></label>
        @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="mb-6">
        <label class="block mb-2">Nouveau mot de passe: <input type="password" name="password" class="w-full border rounded px-3 py-2" required></label>
        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="mb-6">
        <label class="block mb-2">Confirmer le nouveau mot de passe: <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required></label>
    </div>
    <button type="submit" class="bg-pink-600 text-white px-6 py-3 rounded">Changer le mot de passe</button>
    </form>
</div>

<a href="{{ route('designer.dashboard') }}" class="mt-6 inline-block bg-gray-200 text-gray-800 px-6 py-3 rounded">Retour au tableau de bord</a>

<script>lucide.createIcons();</script>
@endsection