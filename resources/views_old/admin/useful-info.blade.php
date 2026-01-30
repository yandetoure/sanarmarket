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
            <button type="button" onclick="openModal('prayer-times-modal')" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="{{ $prayerTimes ? 'edit' : 'plus' }}" class="w-4 h-4"></i>
                {{ $prayerTimes ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>

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
            <button type="button" onclick="openModal('contact-modal')" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Ajouter
            </button>
        </div>

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
            <button type="button" onclick="openModal('pharmacy-modal')" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="{{ $pharmacyOnDuty ? 'edit' : 'plus' }}" class="w-4 h-4"></i>
                {{ $pharmacyOnDuty ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>

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
            <button type="button" onclick="openModal('campus-map-modal')" class="text-sm bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
                <i data-lucide="{{ $campusMap ? 'edit' : 'plus' }}" class="w-4 h-4"></i>
                {{ $campusMap ? 'Modifier' : 'Ajouter' }}
            </button>
        </div>

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

<!-- Modal Heures de Prière -->
<div id="prayer-times-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal('prayer-times-modal')"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.useful-info.prayer-times') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Heures de Prière</h3>
                        <button type="button" onclick="closeModal('prayer-times-modal')" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fajr</label>
                            <input type="text" name="data[fajr]" value="{{ $prayerTimes->data['fajr'] ?? '' }}" placeholder="05:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dhuhr</label>
                            <input type="text" name="data[dhuhr]" value="{{ $prayerTimes->data['dhuhr'] ?? '' }}" placeholder="12:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asr</label>
                            <input type="text" name="data[asr]" value="{{ $prayerTimes->data['asr'] ?? '' }}" placeholder="15:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Maghrib</label>
                            <input type="text" name="data[maghrib]" value="{{ $prayerTimes->data['maghrib'] ?? '' }}" placeholder="18:30" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Isha</label>
                            <input type="text" name="data[isha]" value="{{ $prayerTimes->data['isha'] ?? '' }}" placeholder="20:00" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-medium text-white hover:bg-sky-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal('prayer-times-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Contact Universitaire -->
<div id="contact-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal('contact-modal')"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.useful-info.university-contact') }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Ajouter un Contact Universitaire</h3>
                        <button type="button" onclick="closeModal('contact-modal')" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                        <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
                        <textarea name="content" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required></textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-medium text-white hover:bg-sky-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Ajouter
                    </button>
                    <button type="button" onclick="closeModal('contact-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pharmacie de Garde -->
<div id="pharmacy-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal('pharmacy-modal')"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.useful-info.pharmacy-on-duty') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Pharmacies de Garde</h3>
                        <button type="button" onclick="closeModal('pharmacy-modal')" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-medium text-white hover:bg-sky-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal('pharmacy-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Plan du Campus -->
<div id="campus-map-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal('campus-map-modal')"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.useful-info.campus-map') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Plan du Campus</h3>
                        <button type="button" onclick="closeModal('campus-map-modal')" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (max 5MB)</p>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
                        <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">{{ $campusMap && $campusMap->data && isset($campusMap->data['description']) ? $campusMap->data['description'] : '' }}</textarea>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sky-600 text-base font-medium text-white hover:bg-sky-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeModal('campus-map-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
    
    // Définir les fonctions globalement pour qu'elles soient accessibles depuis onclick
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            lucide.createIcons();
            console.log('Modal opened:', modalId);
        } else {
            console.error('Modal not found:', modalId);
        }
    };
    
    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    };
    
    // Fermer la modale avec la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[id$="-modal"]');
            modals.forEach(modal => {
                if (!modal.classList.contains('hidden')) {
                    window.closeModal(modal.id);
                }
            });
        }
    });
</script>
@endsection
