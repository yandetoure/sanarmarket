@extends('layouts.admin')

@section('title', 'Gestion des Infos Utiles')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Infos Utiles</h1>
        <p class="text-gray-600 mt-2">Consultez les informations utiles du campus</p>
    </div>
    <a href="{{ route('useful-info.index') }}" class="bg-sky-600 text-white px-6 py-3 rounded-lg hover:bg-sky-700 transition-colors flex items-center gap-2">
        <i data-lucide="external-link" class="w-5 h-5"></i>
        Voir la page publique
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Heures de prière -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="clock" class="w-5 h-5 text-sky-600"></i>
            Heures de Prière
        </h2>
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
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="phone" class="w-5 h-5 text-sky-600"></i>
            Contacts Universitaires
        </h2>
        @if($universityContacts && $universityContacts->count() > 0)
            <div class="space-y-2">
                @foreach($universityContacts->take(5) as $contact)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold text-gray-900 text-sm">{{ $contact->title }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($contact->content, 80) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Aucun contact universitaire défini.</p>
        @endif
    </div>

    <!-- Pharmacies de garde -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="hospital" class="w-5 h-5 text-sky-600"></i>
            Pharmacies de Garde
        </h2>
        @if($pharmacyOnDuty && $pharmacyOnDuty->content)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $pharmacyOnDuty->content) }}" alt="Pharmacies de garde" class="w-full h-auto rounded-lg max-h-64 object-contain">
            </div>
            <p class="text-xs text-gray-500">Dernière mise à jour : {{ $pharmacyOnDuty->updated_at->format('d/m/Y H:i') }}</p>
        @else
            <p class="text-gray-600">L'image des pharmacies de garde n'est pas encore disponible.</p>
        @endif
    </div>

    <!-- Plan du campus -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="map" class="w-5 h-5 text-sky-600"></i>
            Plan du Campus
        </h2>
        @if($campusMap && $campusMap->content)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $campusMap->content) }}" alt="Plan du campus" class="w-full h-auto rounded-lg max-h-64 object-contain">
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

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection

