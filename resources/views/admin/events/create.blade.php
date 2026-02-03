@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.events') }}"
                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <h1 class="text-2xl font-display font-bold text-slate-900">Nouvel Événement</h1>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Organisateur -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Organisateur</label>
                    <select name="user_id"
                        class="select select-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('user_id') select-error @enderror"
                        required>
                        <option value="" disabled selected>Sélectionner un utilisateur</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Titre -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Titre de l'événement</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('title') input-error @enderror"
                        required>
                    @error('title')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Date début -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Date de début</label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                            class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('start_date') input-error @enderror"
                            required>
                        @error('start_date')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date fin -->
                    <div class="form-control">
                        <label class="label font-bold text-slate-700">Date de fin</label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                            class="input input-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('end_date') input-error @enderror"
                            required>
                        @error('end_date')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

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

                <!-- Description -->
                <div class="form-control">
                    <label class="label font-bold text-slate-700">Description</label>
                    <textarea name="description" rows="5"
                        class="textarea textarea-bordered rounded-xl focus:ring-2 focus:ring-primary-500 @error('description') textarea-error @enderror"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6 flex justify-end space-x-4">
                    <a href="{{ route('admin.events') }}" class="btn btn-ghost rounded-xl">Annuler</a>
                    <button type="submit" class="btn btn-primary rounded-xl px-8">Créer l'événement</button>
                </div>
            </form>
        </div>
    </div>
@endsection