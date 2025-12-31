@extends('layouts.admin')

@section('title', 'Gestion des Infos Utiles')

@section('content')
@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Infos Utiles</h1>
        <p class="text-gray-600 mt-2">Gérez les informations utiles du campus</p>
    </div>
    <a href="{{ route('useful-info.index') }}" class="bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
        <i data-lucide="external-link" class="w-5 h-5"></i>
        Voir la page publique
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Heures de prière -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <i data-lucide="clock" class="w-5 h-5 text-sky-600"></i>
            Heures de Prière
        </h2>
            <button onclick="togglePrayerTimesForm()" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="{{ $prayerTimes ? 'edit' : 'plus' }}" class="w-4 h-4"></i>
                {{ $prayerTimes ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>
        
        <form id="prayer-times-form" action="{{ route('admin.useful-info.prayer-times') }}" method="POST" class="hidden mb-4 bg-slate-50 p-4 rounded-lg">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Fajr</label>
                    <input type="text" name="data[fajr]" value="{{ $prayerTimes->data['fajr'] ?? '' }}" placeholder="05:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Dhuhr</label>
                    <input type="text" name="data[dhuhr]" value="{{ $prayerTimes->data['dhuhr'] ?? '' }}" placeholder="12:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Asr</label>
                    <input type="text" name="data[asr]" value="{{ $prayerTimes->data['asr'] ?? '' }}" placeholder="15:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Maghrib</label>
                    <input type="text" name="data[maghrib]" value="{{ $prayerTimes->data['maghrib'] ?? '' }}" placeholder="18:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Isha</label>
                    <input type="text" name="data[isha]" value="{{ $prayerTimes->data['isha'] ?? '' }}" placeholder="20:00" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="flex-1 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors text-sm">Enregistrer</button>
                <button type="button" onclick="togglePrayerTimesForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors text-sm">Annuler</button>
            </div>
        </form>

        @if($prayerTimes && $prayerTimes->data)
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Fajr</p>
                    <p class="font-semibold text-gray-900">{{ $prayerTimes->data['fajr'] ?? '--:--' }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Dhuhr</p>
                    <p class="font-semibold text-gray-900">{{ $prayerTimes->data['dhuhr'] ?? '--:--' }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Asr</p>
                    <p class="font-semibold text-gray-900">{{ $prayerTimes->data['asr'] ?? '--:--' }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Maghrib</p>
                    <p class="font-semibold text-gray-900">{{ $prayerTimes->data['maghrib'] ?? '--:--' }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Isha</p>
                    <p class="font-semibold text-gray-900">{{ $prayerTimes->data['isha'] ?? '--:--' }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-3">Dernière mise à jour : {{ $prayerTimes->updated_at->format('d/m/Y H:i') }}</p>
        @else
            <p class="text-gray-600">Les heures de prière ne sont pas encore définies.</p>
        @endif
    </div>

    <!-- Contacts universitaires -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <i data-lucide="phone" class="w-5 h-5 text-sky-600"></i>
            Contacts Universitaires
        </h2>
            <button onclick="toggleContactForm()" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Ajouter
            </button>
        </div>
        
        <form id="contact-form" action="{{ route('admin.useful-info.university-contact') }}" method="POST" class="hidden mb-4 bg-slate-50 p-4 rounded-lg">
            @csrf
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Contenu</label>
                <textarea name="content" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required></textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors text-sm">Ajouter</button>
                <button type="button" onclick="toggleContactForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors text-sm">Annuler</button>
            </div>
        </form>

        @if($universityContacts && $universityContacts->count() > 0)
            <div class="space-y-2">
                @foreach($universityContacts as $contact)
                    <div class="p-3 bg-gray-50 rounded-lg flex items-start justify-between">
                        <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $contact->title }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($contact->content, 80) }}</p>
                        </div>
                        <form action="{{ route('admin.useful-info.university-contact.delete', $contact) }}" method="POST" class="ml-2" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Aucun contact universitaire défini.</p>
        @endif
    </div>

    <!-- Pharmacies de garde -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <i data-lucide="hospital" class="w-5 h-5 text-sky-600"></i>
            Pharmacies de Garde
        </h2>
            <button onclick="togglePharmacyForm()" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="{{ $pharmacyOnDuty ? 'edit' : 'plus' }}" class="w-4 h-4"></i>
                {{ $pharmacyOnDuty ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>
        
        <form id="pharmacy-form" action="{{ route('admin.useful-info.pharmacy-on-duty') }}" method="POST" enctype="multipart/form-data" class="hidden mb-4 bg-slate-50 p-4 rounded-lg">
            @csrf
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors text-sm">Enregistrer</button>
                <button type="button" onclick="togglePharmacyForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors text-sm">Annuler</button>
            </div>
        </form>

        @if($pharmacyOnDuty && $pharmacyOnDuty->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $pharmacyOnDuty->image) }}" alt="Pharmacies de garde" class="w-full h-auto rounded-lg max-h-64 object-contain">
            </div>
            <p class="text-xs text-gray-500">Dernière mise à jour : {{ $pharmacyOnDuty->updated_at->format('d/m/Y H:i') }}</p>
        @else
            <p class="text-gray-600">L'image des pharmacies de garde n'est pas encore disponible.</p>
        @endif
    </div>

    <!-- Plan du campus -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <i data-lucide="map" class="w-5 h-5 text-sky-600"></i>
            Plan du Campus
        </h2>
            <button onclick="toggleCampusMapForm()" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="{{ $campusMap ? 'edit' : 'plus' }}" class="w-4 h-4"></i>
                {{ $campusMap ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>
        
        <form id="campus-map-form" action="{{ route('admin.useful-info.campus-map') }}" method="POST" enctype="multipart/form-data" class="hidden mb-4 bg-slate-50 p-4 rounded-lg">
            @csrf
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (max 5MB)</p>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Description (optionnel)</label>
                <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">{{ $campusMap && $campusMap->data && isset($campusMap->data['description']) ? $campusMap->data['description'] : '' }}</textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors text-sm">Enregistrer</button>
                <button type="button" onclick="toggleCampusMapForm()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors text-sm">Annuler</button>
            </div>
        </form>

        @if($campusMap && $campusMap->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $campusMap->image) }}" alt="Plan du campus" class="w-full h-auto rounded-lg max-h-64 object-contain">
            </div>
            @if($campusMap->data && isset($campusMap->data['description']))
                <p class="text-sm text-gray-600 mb-2">{{ $campusMap->data['description'] }}</p>
            @endif
            <p class="text-xs text-gray-500">Dernière mise à jour : {{ $campusMap->updated_at->format('d/m/Y H:i') }}</p>
        @else
            <p class="text-gray-600">Le plan du campus n'est pas encore disponible.</p>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script>
    lucide.createIcons();
    
    function togglePrayerTimesForm() {
        const form = document.getElementById('prayer-times-form');
        form.classList.toggle('hidden');
    }
    
    function toggleContactForm() {
        const form = document.getElementById('contact-form');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.querySelector('input[name="title"]').focus();
        }
    }
    
    function togglePharmacyForm() {
        const form = document.getElementById('pharmacy-form');
        form.classList.toggle('hidden');
    }
    
    function toggleCampusMapForm() {
        const form = document.getElementById('campus-map-form');
        form.classList.toggle('hidden');
    }
</script>
@endsection

