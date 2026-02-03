@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.campus-spotlight') }}"
                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <h1 class="text-2xl font-display font-bold text-slate-900">Nouvel Article À la Une</h1>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50">
            <form action="{{ route('admin.campus-spotlight.store') }}" method="POST" class="space-y-6">
                @csrf

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

                <!-- Type -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Type</label>
                    <select name="type"
                        class="select select-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('type') select-error @enderror"
                        required>
                        <option value="" disabled selected>Sélectionner un type</option>
                        @foreach(['news' => 'Actualité', 'event' => 'Événement', 'info' => 'Information'] as $key => $label)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Contenu</label>
                    <textarea name="content" rows="6"
                        class="textarea textarea-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('content') textarea-error @enderror"
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <a href="{{ route('admin.campus-spotlight') }}" class="btn btn-ghost rounded-xl">Annuler</a>
                    <button type="submit" class="btn btn-primary rounded-xl px-8">Publier l'article</button>
                </div>
            </form>
        </div>
    </div>
@endsection