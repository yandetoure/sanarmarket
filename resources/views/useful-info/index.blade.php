@extends('layouts.app')

@section('title', 'Infos Utiles - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <!-- Hero Section -->
        <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=2000"
                    alt="" class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div data-aos="fade-up">
                    <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                        Le Guide du <span class="text-gradient">Campus</span>.
                    </h1>
                    <p class="text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                        Tout ce dont vous avez besoin pour faciliter votre quotidien à l'UGB : contacts, prières, pharmacie
                        et plus.
                    </p>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Main Content Area -->
                <div class="lg:col-span-12 space-y-16">

                    <!-- Prayer Times & Pharmacy Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Prayer Times Card -->
                        <section class="glass p-10 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                            data-aos="fade-up">
                            <div class="flex items-center justify-between mb-10">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-primary-100 rounded-2xl flex items-center justify-center text-primary-600 mr-4">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-display font-black text-slate-900">Heures de Prière</h2>
                                </div>
                                @auth @if(auth()->user()->isAmbassador())
                                    <button onclick="document.getElementById('prayer-times-form').classList.toggle('hidden')"
                                        class="text-xs font-black uppercase tracking-widest text-primary-600 hover:text-primary-700">Modifier</button>
                                @endif @endauth
                            </div>

                            @auth @if(auth()->user()->isAmbassador())
                                <form id="prayer-times-form" action="{{ route('useful-info.prayer-times') }}" method="POST"
                                    class="hidden mb-10 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                                    @csrf
                                    <div class="grid grid-cols-3 gap-4 mb-4">
                                        @foreach(['fajr', 'dhuhr', 'asr', 'maghrib', 'isha'] as $prayer)
                                            <div>
                                                <label
                                                    class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">{{ $prayer }}</label>
                                                <input type="time" name="data[{{ $prayer }}]"
                                                    value="{{ $prayerTimes->data[$prayer] ?? '' }}"
                                                    class="w-full px-4 py-3 bg-white border-slate-100 rounded-xl text-sm focus:ring-primary-500">
                                            </div>
                                        @endforeach
                                    </div>
                                    <x-button type="submit" variant="primary" size="sm" class="w-full">Mettre à jour</x-button>
                                </form>
                            @endif @endauth

                            <div class="grid grid-cols-5 gap-3">
                                @foreach(['Fajr' => 'fajr', 'Dhuhr' => 'dhuhr', 'Asr' => 'asr', 'Maghrib' => 'maghrib', 'Isha' => 'isha'] as $label => $key)
                                    <div
                                        class="text-center p-4 bg-white/50 rounded-2xl border border-white hover:border-primary-100 transition-colors">
                                        <p class="text-[10px] font-black uppercase tracking-tighter text-slate-400 mb-1">
                                            {{ $label }}</p>
                                        <p class="text-lg font-display font-black text-slate-900">
                                            {{ $prayerTimes->data[$key] ?? '--:--' }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 mt-6 text-center uppercase tracking-[0.2em]">
                                Source : Grande Mosquée de l'UGB</p>
                        </section>

                        <!-- Pharmacy Card -->
                        <section class="glass p-10 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                            data-aos="fade-up" data-aos-delay="100">
                            <div class="flex items-center justify-between mb-10">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mr-4">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a2 2 0 00-1.996 1.389l-.131.462a2 2 0 01-1.263 1.383l-4.238 1.413a2 2 0 01-2.417-1.127l-5.419-12a2 2 0 011.127-2.417l12-5.419a2 2 0 012.417 1.127l2.583 3.691a2 2 0 001.248.883l3.238 1.079a2 2 0 011.413 2.417l-1.413 4.238a2 2 0 01-1.383 1.263l-.462.131a2 2 0 00-1.389 1.996l.477 2.387a2 2 0 001.122 1.569l2 .8c.3.12.55.3.75.5">
                                            </path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-display font-black text-slate-900">Pharmacie de Garde</h2>
                                </div>
                                @auth @if(auth()->user()->isAmbassador())
                                    <form action="{{ route('useful-info.pharmacy-on-duty') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="image" accept="image/*" required onchange="this.form.submit()"
                                            class="hidden" id="pharmacy-upload">
                                        <label for="pharmacy-upload"
                                            class="text-xs font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-700 cursor-pointer">Actualiser</label>
                                    </form>
                                @endif @endauth
                            </div>

                            <div
                                class="relative group aspect-[16/9] bg-slate-100 rounded-3xl overflow-hidden shadow-inner border border-slate-100">
                                @if($pharmacyOnDuty && $pharmacyOnDuty->image)
                                    <img src="{{ asset('storage/' . $pharmacyOnDuty->image) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/60 to-transparent">
                                        <x-button href="{{ asset('storage/' . $pharmacyOnDuty->image) }}" target="_blank"
                                            variant="secondary" size="sm"
                                            class="bg-white/20 backdrop-blur-md border-white/20 text-white w-full">Agrandir
                                            l'affiche</x-button>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-slate-400">
                                        <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-xs font-bold uppercase tracking-widest">Non disponible</p>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                    <!-- Contacts Section -->
                    <section class="glass p-12 rounded-[3.5rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up">
                        <div class="flex items-center justify-between mb-12">
                            <div class="flex items-center">
                                <div
                                    class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mr-6">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-display font-black text-slate-900">Services d'Urgence &
                                        Administratifs</h2>
                                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Répertoire
                                        officiel de l'université</p>
                                </div>
                            </div>
                            @auth @if(auth()->user()->isAmbassador())
                                <button onclick="document.getElementById('contact-form').classList.toggle('hidden')"
                                    class="px-6 py-3 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-100">+
                                    Ajouter un contact</button>
                            @endif @endauth
                        </div>

                        @auth @if(auth()->user()->isAmbassador())
                            <form id="contact-form" action="{{ route('useful-info.university-contact') }}" method="POST"
                                class="hidden mb-12 bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Service</label>
                                        <input type="text" name="title" required placeholder="ex: Service Médical"
                                            class="w-full px-5 py-4 bg-white border-slate-100 rounded-2xl focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Description
                                            / Contact</label>
                                        <input type="text" name="content" required placeholder="77 000 00 00"
                                            class="w-full px-5 py-4 bg-white border-slate-100 rounded-2xl focus:ring-indigo-500">
                                    </div>
                                </div>
                                <x-button type="submit" variant="primary"
                                    class="bg-indigo-600 hover:bg-indigo-700 w-full">Enregistrer le contact</x-button>
                            </form>
                        @endif @endauth

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @forelse($universityContacts as $contact)
                                <div
                                    class="group bg-white/50 p-8 rounded-[2rem] border border-white hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-50/50 transition-all duration-500 relative overflow-hidden">
                                    <div
                                        class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 group-hover:scale-125 transition-all">
                                        <svg class="w-6 h-6 text-indigo-200" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-display font-bold text-slate-900 mb-4">{{ $contact->title }}</h3>
                                    <div class="text-slate-600 font-medium whitespace-pre-line leading-relaxed pb-4">
                                        {{ $contact->content }}
                                    </div>
                                    @if(str_contains($contact->content, '77') || str_contains($contact->content, '78') || str_contains($contact->content, '70'))
                                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $contact->content) }}"
                                            class="inline-flex items-center text-xs font-black uppercase tracking-widest text-indigo-600 hover:indigo-700">Appeler
                                            maintenant →</a>
                                    @endif
                                </div>
                            @empty
                                <p class="col-span-full text-center py-12 text-slate-400 font-bold italic">Aucun contact
                                    enregistré pour le moment.</p>
                            @endforelse
                        </div>
                    </section>

                    <!-- Map & Support Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Campus Map -->
                        <section
                            class="lg:col-span-2 glass p-10 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                            data-aos="fade-right">
                            <div class="flex items-center justify-between mb-8">
                                <h2 class="text-2xl font-display font-black text-slate-900 flex items-center">
                                    <svg class="w-6 h-6 mr-3 text-primary-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z">
                                        </path>
                                    </svg>
                                    Plan Interactif
                                </h2>
                                @auth @if(auth()->user()->isAmbassador())
                                    <form action="{{ route('useful-info.campus-map') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="image" accept="image/*" required onchange="this.form.submit()"
                                            class="hidden" id="map-upload">
                                        <label for="map-upload"
                                            class="text-xs font-black uppercase tracking-widest text-primary-600 cursor-pointer">Recharger</label>
                                    </form>
                                @endif @endauth
                            </div>

                            <div class="aspect-video bg-slate-900 rounded-[2rem] overflow-hidden relative group">
                                @if($campusMap && $campusMap->image)
                                    <img src="{{ asset('storage/' . $campusMap->image) }}" class="w-full h-full object-contain">
                                    <div
                                        class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <x-button href="{{ asset('storage/' . $campusMap->image) }}" target="_blank"
                                            variant="secondary">Voir en haute définition</x-button>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center h-full text-slate-500 font-bold italic">Plan
                                        non chargé</div>
                                @endif
                            </div>
                        </section>

                        <!-- Support Card -->
                        <section
                            class="bg-slate-900 p-10 rounded-[3rem] border border-slate-800 shadow-2xl relative overflow-hidden"
                            data-aos="fade-left">
                            <div
                                class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-emerald-500 rounded-full blur-3xl opacity-20">
                            </div>
                            <div class="relative z-10 flex flex-col h-full">
                                <h2 class="text-2xl font-display font-black text-white mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Support Client
                                </h2>
                                <p class="text-slate-400 mb-10 leading-relaxed font-medium">Vous rencontrez un problème
                                    technique ou avez une question ? Notre équipe est disponible sur WhatsApp 24/7.</p>

                                <div class="mt-auto space-y-4">
                                    <a href="https://wa.me/221772319878" target="_blank"
                                        class="flex items-center justify-center gap-3 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black uppercase tracking-widest text-xs py-5 rounded-2xl transition-all shadow-xl shadow-emerald-900/20">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                        </svg>
                                        WhatsApp Support
                                    </a>
                                    <p class="text-[10px] text-center text-slate-500 font-bold uppercase tracking-widest">
                                        Temps de réponse moyen : < 15 min</p>
                                </div>
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </main>
    </div>
@endsection