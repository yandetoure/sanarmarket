@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-display font-black text-slate-900">Informations Utiles Campus</h1>
            <p class="text-slate-500 mt-1">Gérez les informations essentielles du campus</p>
        </div>

        <!-- Sections Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Prayer Times -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">🕌</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Horaires de Prière</h2>
                        <p class="text-sm text-slate-500">Heures de prière du jour</p>
                    </div>
                </div>
                <form action="{{ route('admin.useful-info.prayer-times') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Fajr</label>
                            <input type="time" name="fajr" value="{{ $prayerTimes['fajr'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border-slate-200">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Dhuhr</label>
                            <input type="time" name="dhuhr" value="{{ $prayerTimes['dhuhr'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border-slate-200">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Asr</label>
                            <input type="time" name="asr" value="{{ $prayerTimes['asr'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border-slate-200">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Maghrib</label>
                            <input type="time" name="maghrib" value="{{ $prayerTimes['maghrib'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border-slate-200">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Isha</label>
                            <input type="time" name="isha" value="{{ $prayerTimes['isha'] ?? '' }}"
                                class="w-full px-4 py-3 rounded-xl border-slate-200">
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Mettre à jour
                    </button>
                </form>
            </div>

            <!-- Pharmacy on Duty -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">💊</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Pharmacie de Garde</h2>
                        <p class="text-sm text-slate-500">Pharmacie disponible</p>
                    </div>
                </div>
                <form action="{{ route('admin.useful-info.pharmacy-on-duty') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nom de la pharmacie</label>
                        <input type="text" name="name" value="{{ $pharmacy['name'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200" placeholder="Pharmacie Centrale">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Adresse</label>
                        <input type="text" name="address" value="{{ $pharmacy['address'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200" placeholder="Av. Bourguiba">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="phone" value="{{ $pharmacy['phone'] ?? '' }}"
                            class="w-full px-4 py-3 rounded-xl border-slate-200" placeholder="+221 77 123 45 67">
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Mettre à jour
                    </button>
                </form>
            </div>

            <!-- University Contact -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">📞</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Contacts Université</h2>
                        <p class="text-sm text-slate-500">Numéros importants</p>
                    </div>
                </div>
                <form action="{{ route('admin.useful-info.university-contact') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nom du contact</label>
                        <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border-slate-200"
                            placeholder="Service Scolarité">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="phone" class="w-full px-4 py-3 rounded-xl border-slate-200"
                            placeholder="+221 77 123 45 67">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border-slate-200"
                            placeholder="scolarite@universite.sn">
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Ajouter Contact
                    </button>
                </form>

                <!-- Contacts List -->
                @if(isset($contacts) && count($contacts) > 0)
                    <div class="mt-6 space-y-2">
                        <p class="text-sm font-bold text-slate-600">Contacts enregistrés:</p>
                        @foreach($contacts as $contact)
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $contact->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $contact->phone }} • {{ $contact->email }}</p>
                                </div>
                                <form action="{{ route('admin.useful-info.university-contact.delete', $contact) }}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-red-600 hover:bg-red-50"
                                        title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Campus Map -->
            <div class="glass rounded-3xl border border-white shadow-xl p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-3xl">🗺️</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Plan du Campus</h2>
                        <p class="text-sm text-slate-500">Carte interactive</p>
                    </div>
                </div>
                <form action="{{ route('admin.useful-info.campus-map') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Image du plan</label>
                        <input type="file" name="map_image" accept="image/*"
                            class="w-full px-4 py-3 rounded-xl border-slate-200">
                    </div>
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        Mettre à jour
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection