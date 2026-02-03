@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.announcements') }}"
                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <h1 class="text-2xl font-display font-bold text-slate-900">Nouvelle Annonce</h1>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50">
            <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Titre</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('title') input-error @enderror"
                            required>
                        @error('title')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Prix -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Prix (FCFA)</label>
                        <input type="number" name="price" value="{{ old('price') }}"
                            class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('price') input-error @enderror"
                            required>
                        @error('price')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Catégorie -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Catégorie</label>
                        <select name="category_id"
                            class="select select-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('category_id') select-error @enderror"
                            required>
                            <option value="" disabled selected>Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Sous-catégorie -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Sous-catégorie (Optionnel)</label>
                        <select name="sub_category_id"
                            class="select select-bordered rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="">Aucune</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ old('sub_category_id') == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Lieu -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Lieu</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('location') input-error @enderror"
                            required>
                        @error('location')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Téléphone de contact</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('phone') input-error @enderror">
                        @error('phone')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <a href="{{ route('admin.announcements') }}" class="btn btn-ghost rounded-xl">Annuler</a>
                    <button type="submit" class="btn btn-primary rounded-xl px-8">Créer l'annonce</button>
                </div>
            </form>
        </div>
    </div>
@endsection