@extends('layouts.admin')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Créer un Utilisateur</h1>
    <p class="text-gray-600 mt-2">Ajoutez un nouveau compte utilisateur avec un rôle spécifique</p>
</div>

<div class="bg-white rounded-lg shadow-sm border overflow-hidden">
    <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
        @csrf
        
        <div class="space-y-6">
            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation mot de passe -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Rôle -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                <select name="role" id="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Sélectionner un rôle</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="premium" {{ old('role') === 'premium' ? 'selected' : '' }}>Premium</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="designer" {{ old('role') === 'designer' ? 'selected' : '' }}>Designer</option>
                    <option value="marketing" {{ old('role') === 'marketing' ? 'selected' : '' }}>Marketing</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Compte actif
                </label>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all flex items-center gap-2 shadow-md">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Créer l'utilisateur
            </button>
            <a href="{{ route('admin.users') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-all">
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
@endsection

