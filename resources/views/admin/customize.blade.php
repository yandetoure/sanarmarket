@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-display font-black text-slate-900">Personnalisation du Site</h1>
            <p class="text-slate-500 mt-1">Personnalisez l'apparence et les paramètres</p>
        </div>

        <!-- Customization Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Logo & Branding -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">🎨</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Logo & Marque</h2>
                        <p class="text-sm text-slate-500">Identité visuelle</p>
                    </div>
                </div>
                <form action="{{ route('admin.save-customization') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <input type="hidden" name="section" value="branding">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Logo principal</label>
                        <input type="file" name="logo" accept="image/*"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nom du site</label>
                        <input type="text" name="site_name" value="{{ $customization['site_name'] ?? 'SanarWeb' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Slogan</label>
                        <input type="text" name="tagline" value="{{ $customization['tagline'] ?? 'Espace Membre' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Enregistrer
                    </button>
                </form>
            </div>

            <!-- Colors -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">🌈</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Couleurs</h2>
                        <p class="text-sm text-slate-500">Palette de couleurs</p>
                    </div>
                </div>
                <form action="{{ route('admin.save-customization') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="section" value="colors">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Couleur principale</label>
                        <input type="color" name="primary_color" value="{{ $customization['primary_color'] ?? '#3b82f6' }}"
                            class="w-full h-12 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Couleur secondaire</label>
                        <input type="color" name="secondary_color"
                            value="{{ $customization['secondary_color'] ?? '#8b5cf6' }}"
                            class="w-full h-12 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Couleur accent</label>
                        <input type="color" name="accent_color" value="{{ $customization['accent_color'] ?? '#ec4899' }}"
                            class="w-full h-12 rounded-xl border-slate-200">
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Enregistrer
                    </button>
                </form>
            </div>

            <!-- General Settings -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">⚙️</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Paramètres Généraux</h2>
                        <p class="text-sm text-slate-500">Configuration du site</p>
                    </div>
                </div>
                <form action="{{ route('admin.save-customization') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="section" value="general">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email de contact</label>
                        <input type="email" name="contact_email" value="{{ $customization['contact_email'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="contact_phone" value="{{ $customization['contact_phone'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Adresse</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">{{ $customization['address'] ?? '' }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Enregistrer
                    </button>
                </form>
            </div>

            <!-- Social Media -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">📱</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Réseaux Sociaux</h2>
                        <p class="text-sm text-slate-500">Liens sociaux</p>
                    </div>
                </div>
                <form action="{{ route('admin.save-customization') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="section" value="social">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Facebook</label>
                        <input type="url" name="facebook_url" value="{{ $customization['facebook_url'] ?? '' }}"
                            placeholder="https://facebook.com/..." class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Instagram</label>
                        <input type="url" name="instagram_url" value="{{ $customization['instagram_url'] ?? '' }}"
                            placeholder="https://instagram.com/..." class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Twitter/X</label>
                        <input type="url" name="twitter_url" value="{{ $customization['twitter_url'] ?? '' }}"
                            placeholder="https://twitter.com/..." class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">LinkedIn</label>
                        <input type="url" name="linkedin_url" value="{{ $customization['linkedin_url'] ?? '' }}"
                            placeholder="https://linkedin.com/..." class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Enregistrer
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection