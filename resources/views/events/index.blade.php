@extends('layouts.app')

@section('title', 'Événements Campus')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <!-- Hero Section -->
    <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1540575861501-7ad060e39fe5?auto=format&fit=crop&q=80&w=2000" alt="" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div data-aos="fade-up">
                <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                    Vivez le <span class="text-gradient">Campus</span>.
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Ne manquez aucun événement : conférences, soirées, sports et culture. L'agenda complet de la vie étudiante.
                </p>
                @auth
                    @if(auth()->user()->isAmbassador())
                        <x-button href="{{ route('events.create') }}" variant="primary" size="lg" class="shadow-2xl shadow-primary-500/20">
                            + Créer un événement
                        </x-button>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-12" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-display font-bold text-slate-900">Agenda Sanarois</h2>
                <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">
                    {{ $events->count() }} événement{{ $events->count() > 1 ? 's' : '' }} à venir
                </p>
            </div>
        </div>

        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($events as $index => $event)
                    <a href="{{ route('events.show', $event) }}" 
                       class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500 flex flex-col h-full"
                       data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="aspect-[16/10] relative overflow-hidden bg-slate-100">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" 
                                     alt="{{ $event->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-indigo-100/50">
                                    <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-6 left-6">
                                <div class="bg-white/90 backdrop-blur-md rounded-2xl p-2 text-center min-w-[50px] shadow-lg border border-white/50">
                                    <p class="text-[10px] font-black text-primary-600 uppercase tracking-tighter">{{ $event->start_date->format('M') }}</p>
                                    <p class="text-xl font-display font-black text-slate-900 leading-none">{{ $event->start_date->format('d') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="text-2xl font-display font-bold text-slate-900 group-hover:text-primary-600 transition-colors mb-4 line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            
                            <p class="text-sm text-slate-500 line-clamp-2 mb-8 font-medium leading-relaxed flex-grow">
                                {{ $event->description }}
                            </p>
                            
                            <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
                                <div class="flex items-center text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                                    <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $event->start_date->format('H:i') }}
                                </div>
                                @if($event->location)
                                    <div class="flex items-center text-slate-400 font-bold text-[10px] uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $event->location }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $events->links() }}
            </div>
        @else
            <div class="py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                </div>
                <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucun événement prévu</h3>
                <p class="text-slate-500 mb-8 max-w-xs mx-auto">Le campus est calme pour l'instant. Revenez bientôt !</p>
            </div>
        @endif

        @auth
            @if(auth()->user()->isModerator())
                @php
                    $pendingEvents = \App\Models\Event::where('status', 'pending')->with('user')->latest()->get();
                @endphp
                @if($pendingEvents->count() > 0)
                    <div class="mt-32 p-12 bg-white rounded-[3.5rem] border border-orange-100 shadow-xl shadow-orange-50" data-aos="fade-up">
                        <h2 class="text-2xl font-display font-black text-slate-900 mb-8 flex items-center">
                            <span class="w-4 h-4 bg-orange-500 rounded-full mr-4 animate-pulse"></span>
                            Modération : Événements en attente
                        </h2>
                        <div class="space-y-6">
                            @foreach($pendingEvents as $event)
                                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-display font-bold text-slate-900 mb-2">{{ $event->title }}</h3>
                                        <p class="text-sm text-slate-500 mb-4 line-clamp-1">{{ $event->description }}</p>
                                        <div class="flex items-center text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            <span>Par {{ $event->user->name }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $event->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <form action="{{ route('events.approve', $event) }}" method="POST">
                                            @csrf
                                            <x-button type="submit" variant="primary" size="sm" class="bg-emerald-600 hover:bg-emerald-700">Approuver</x-button>
                                        </form>
                                        <form action="{{ route('events.reject', $event) }}" method="POST">
                                            @csrf
                                            <x-button type="submit" variant="secondary" size="sm" class="text-red-600 border-red-100 hover:bg-red-50">Rejeter</x-button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        @endauth
    </main>
</div>
@endsection
