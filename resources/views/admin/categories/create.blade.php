@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.categories.index') }}"
                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <h1 class="text-2xl font-display font-bold text-slate-900">Nouvelle Catégorie</h1>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nom -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Nom de la catégorie</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('name') input-error @enderror"
                        required>
                    @error('name')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Slug (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                        class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('slug') input-error @enderror"
                        placeholder="exemple-de-categorie" required>
                    @error('slug')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Icone -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Icône (Emoji ou classe CSS)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}"
                        class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('icon') input-error @enderror"
                        required>
                    @error('icon')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Description</label>
                    <textarea name="description" rows="4"
                        class="textarea textarea-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('description') textarea-error @enderror"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost rounded-xl">Annuler</a>
                    <button type="submit" class="btn btn-primary rounded-xl px-8">Créer la catégorie</button>
                </div>
            </form>
        </div>
    </div>
@endsection