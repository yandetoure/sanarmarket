@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center space-x-4 mb-8">
        <a href="{{ route('admin.users') }}" 
           class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-display font-bold text-slate-900">Nouvel Utilisateur</h1>
    </div>

    <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('name') input-error @enderror" 
                           required>
                    @error('name')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('email') input-error @enderror" 
                           required>
                    @error('email')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Rôle -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Rôle</label>
                    <select name="role" class="select select-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('role') select-error @enderror">
                        @foreach(['user', 'premium', 'admin', 'ambassador', 'marketing', 'designer', 'moderator'] as $role)
                            <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('phone') input-error @enderror">
                    @error('phone')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="divider">Sécurité</div>

            <!-- Mot de passe -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Mot de passe</label>
                    <input type="password" name="password" 
                           class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('password') input-error @enderror" required>
                    @error('password')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label font-bold text-slate-700">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" 
                           class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500" required>
                </div>
            </div>

            <div class="form-control">
                <label class="label cursor-pointer justify-start space-x-4">
                    <input type="checkbox" name="is_active" 
                           class="checkbox checkbox-primary rounded-lg" 
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="label-text font-bold text-slate-700">Compte actif</span>
                </label>
            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.users') }}" class="btn btn-ghost rounded-xl">Annuler</a>
                <button type="submit" class="btn btn-primary rounded-xl px-8">Créer l'utilisateur</button>
            </div>
        </form>
    </div>
</div>
@endsection
