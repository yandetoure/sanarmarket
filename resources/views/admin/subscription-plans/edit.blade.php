@extends('layouts.dashboard')

@section('content')
    <div class="px-8 py-5">
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.subscription-plans.index') }}"
                class="btn btn-ghost btn-circle mr-4 text-slate-500 hover:bg-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-black text-slate-900">Modifier le Plan d'abonnement</h1>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <form action="{{ route('admin.subscription-plans.update', $plan) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-bold text-slate-700">Nom du plan</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $plan->name) }}"
                            class="input input-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') input-error @enderror"
                            placeholder="Ex: Plan Premium, Business...">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-bold text-slate-700">Description</span>
                        </label>
                        <textarea name="description" rows="3"
                            class="textarea textarea-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500"
                            placeholder="Avantages du plan...">{{ old('description', $plan->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-bold text-slate-700">Prix (FCFA)</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price', $plan->price) }}" min="0" step="1"
                                class="input input-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 @error('price') input-error @enderror">
                            @error('price')
                                <label class="label">
                                    <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-bold text-slate-700">Durée (Jours)</span>
                            </label>
                            <input type="number" name="duration_days"
                                value="{{ old('duration_days', $plan->duration_days) }}" min="1"
                                class="input input-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 @error('duration_days') input-error @enderror">
                        </div>
                    </div>

                    <div class="divider">Limitations</div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-bold text-slate-700">Max Annonces</span>
                            </label>
                            <input type="number" name="max_announcements"
                                value="{{ old('max_announcements', $plan->max_announcements) }}" min="1"
                                class="input input-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <label class="label">
                                <span class="label-text-alt text-slate-400">Nombre d'annonces simultanées</span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-bold text-slate-700">Photos par annonce</span>
                            </label>
                            <input type="number" name="max_photos_per_announcement"
                                value="{{ old('max_photos_per_announcement', $plan->max_photos_per_announcement) }}" min="1"
                                class="input input-bordered w-full rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="divider">Options</div>

                    <div class="flex items-center space-x-8">
                        <label class="cursor-pointer label space-x-3">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }} class="checkbox checkbox-warning rounded-lg">
                            <span class="label-text font-semibold text-slate-700">Mettre en avant (Populaire)</span>
                        </label>

                        <label class="cursor-pointer label space-x-3">
                            <!-- Hidden input to allow unchecking -->
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="checkbox checkbox-primary rounded-lg">
                            <span class="label-text font-semibold text-slate-700">Actif</span>
                        </label>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button type="submit"
                            class="btn btn-primary rounded-xl px-8 font-bold text-lg bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 border-0 shadow-lg hover:shadow-xl transition-all duration-300">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection