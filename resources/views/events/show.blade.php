@extends('layouts.app')

@section('title', $event->title . ' - Événement')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20">
        <!-- Event Hero -->
        <header class="relative h-[60vh] min-h-[400px] overflow-hidden bg-slate-900">
            <div class="absolute inset-0 z-0">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                        class="w-full h-full object-cover opacity-60">
                @else
                    <img src="https://images.unsplash.com/photo-1540575861501-7cf05a4b125a?auto=format&fit=crop&q=80&w=2000"
                        alt="" class="w-full h-full object-cover opacity-40">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative z-10 flex flex-col justify-end pb-16">
                <div data-aos="fade-up">
                    <a href="{{ route('events.index') }}"
                        class="inline-flex items-center space-x-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/70 hover:text-white transition-colors mb-8 group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        <span>Retour aux événements</span>
                    </a>

                    <div class="flex items-center space-x-3 mb-4">
                        <x-badge variant="{{ $event->status === 'approved' ? 'emerald' : 'orange' }}" size="sm"
                            class="backdrop-blur-md bg-white/10 border-white/20 text-white">
                            {{ $event->status === 'approved' ? 'Confirmé' : 'En attente' }}
                        </x-badge>
                        @if($event->start_date->isToday())
                            <span
                                class="bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest animate-pulse">Aujourd'hui</span>
                        @endif
                    </div>

                    <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6 leading-tight max-w-4xl">
                        {{ $event->title }}
                    </h1>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
            <div class="grid lg:grid-cols-3 gap-10">

                <!-- Details Column -->
                <div class="lg:col-span-2 space-y-10">
                    <article class="glass p-10 md:p-12 rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50"
                        data-aos="fade-up">
                        <h2 class="text-2xl font-display font-black text-slate-900 mb-8">Description de l'événement</h2>
                        <div
                            class="prose prose-slate prose-lg max-w-none text-slate-700 font-medium leading-relaxed whitespace-pre-line">
                            {{ $event->description }}
                        </div>
                    </article>

                    <div class="glass p-10 rounded-[3rem] border-white/60 shadow-xl shadow-slate-100/50" data-aos="fade-up">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-lg">
                                {{ strtoupper(substr($event->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p
                                    class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">
                                    Organisé par</p>
                                <p class="text-base font-black text-slate-900">{{ $event->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logistics Column -->
                <div class="space-y-8">
                    <div class="sticky top-32 space-y-8">
                        <!-- Date & Time Card -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-200/50"
                            data-aos="fade-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Quand</p>
                            <div class="space-y-6">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900">
                                            {{ $event->start_date->translatedFormat('d F Y') }}</p>
                                        <p class="text-xs font-bold text-slate-400">À partir de
                                            {{ $event->start_date->format('H:i') }}</p>
                                    </div>
                                </div>
                                @if($event->end_date)
                                    <div class="flex items-start space-x-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Se
                                                termine le</p>
                                            <p class="text-sm font-bold text-slate-600">
                                                {{ $event->end_date->translatedFormat('d F Y, H:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Location Card -->
                        @if($event->location)
                            <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-indigo-50/50 bg-gradient-to-br from-white to-indigo-50/20"
                                data-aos="fade-left" data-aos-delay="100">
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-6">Où</p>
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900">{{ $event->location }}</p>
                                        <a href="https://maps.google.com/?q={{ urlencode($event->location) }}" target="_blank"
                                            class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline mt-2 inline-block">Voir
                                            sur la carte →</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Actions Card -->
                        <div class="glass p-8 rounded-[2.5rem] border-white/60 shadow-xl shadow-slate-100/50"
                            data-aos="fade-left" data-aos-delay="200">
                            <x-button
                                href="https://wa.me/221772319878?text=Bonjour, je souhaite plus d'infos sur l'événement : {{ $event->title }}"
                                target="_blank" variant="primary" size="lg"
                                class="w-full shadow-xl shadow-primary-500/20">S'inscrire / Info</x-button>
                            <p class="mt-4 text-[10px] text-center text-slate-400 font-bold uppercase tracking-widest">
                                Places limitées</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection