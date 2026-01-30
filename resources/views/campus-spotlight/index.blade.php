@extends('layouts.app')

@section('title', 'Campus Spotlight - L\'Actu du Campus')

@section('content')
<div class="bg-slate-50 min-h-screen">
    <!-- Hero Section -->
    <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1523050853063-913a3e60c868?auto=format&fit=crop&q=80&w=2000" alt="" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div data-aos="fade-up">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black bg-primary-500/20 text-primary-400 border border-primary-500/30 backdrop-blur-md mb-6 uppercase tracking-widest">
                    📣 Officiel
                </span>
                <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                    Campus <span class="text-gradient">Spotlight</span>.
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Les dernières annonces officielles, les assemblées générales et les informations cruciales pour la vie à l'UGB.
                </p>
                @auth @if(auth()->user()->isAmbassador())
                    <x-button onclick="document.getElementById('spotlight-form').classList.toggle('hidden')" variant="primary" size="lg" class="mt-8 shadow-2xl shadow-primary-500/20">
                        Publier une information
                    </x-button>
                @endif @endauth
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @auth @if(auth()->user()->isAmbassador())
            <form id="spotlight-form" action="{{ route('campus-spotlight.store') }}" method="POST" class="hidden mb-16 glass p-10 rounded-[3rem] border-white/60 shadow-2xl shadow-primary-100/30" data-aos="zoom-in">
                @csrf
                <div class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Titre de l'annonce</label>
                            <input type="text" name="title" required placeholder="ex: Modification des horaires de bus" class="w-full px-5 py-4 bg-white border-slate-100 rounded-2xl focus:ring-primary-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Type d'information</label>
                            <select name="type" required class="w-full px-5 py-4 bg-white border-slate-100 rounded-2xl focus:ring-primary-500 shadow-sm appearance-none">
                                <option value="info">📢 Information générale</option>
                                <option value="ag">⚖️ Assemblée Générale</option>
                                <option value="opening">🔑 Ouverture campus</option>
                                <option value="other">⚙️ Autre</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Contenu du message</label>
                        <textarea name="content" rows="4" required placeholder="Détaillez l'information ici..." class="w-full px-5 py-4 bg-white border-slate-100 rounded-2xl focus:ring-primary-500 shadow-sm"></textarea>
                    </div>
                    <div class="flex gap-4">
                        <x-button type="submit" variant="primary" class="flex-1">Publier l'annonce</x-button>
                        <x-button type="button" onclick="document.getElementById('spotlight-form').classList.add('hidden')" variant="secondary" class="flex-1 bg-slate-100 border-transparent text-slate-600">Annuler</x-button>
                    </div>
                </div>
            </form>
        @endif @endauth

        <div class="space-y-12">
            @forelse($spotlights as $index => $spotlight)
                <div class="relative group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <!-- Indicator Line -->
                    <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-primary-500 via-primary-500 to-transparent rounded-full hidden md:block opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="glass p-8 md:p-10 rounded-[3rem] border-white/60 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500">
                        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-4">
                                    <x-badge variant="primary" size="md" class="glass border-primary-100 text-primary-600">
                                        {{ [
                                            'info' => 'Annonce',
                                            'ag' => 'Assemblée Générale',
                                            'opening' => 'Ouverture',
                                            'other' => 'Divers'
                                        ][$spotlight->type] ?? 'Info' }}
                                    </x-badge>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $spotlight->published_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h3 class="text-2xl font-display font-black text-slate-900 group-hover:text-primary-600 transition-colors mb-4 leading-tight">
                                    {{ $spotlight->title }}
                                </h3>
                                <div class="text-slate-600 font-medium whitespace-pre-line leading-relaxed pb-6 border-b border-slate-100">
                                    {{ $spotlight->content }}
                                </div>
                            </div>
                            @auth @if(auth()->user()->isAmbassador())
                                <form action="{{ route('campus-spotlight.destroy', $spotlight) }}" method="POST" class="self-end md:self-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="p-3 bg-red-50 text-red-500 rounded-2xl hover:bg-red-100 transition-colors shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif @endauth
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center font-display font-black text-[10px] text-primary-600 border-2 border-white shadow-sm overflow-hidden">
                                {{ strtoupper(substr($spotlight->user->name, 0, 2)) }}
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Par Ambassadeur <span class="text-slate-900">{{ $spotlight->user->name }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.297A1.707 1.707 0 019.412 21H2.143A1.714 1.714 0 01.429 19.286V5.571a1.714 1.714 0 011.714-1.714h7.271a1.703 1.703 0 011.586.882zM11 5.882l2.293-2.293a1 1 0 011.414 0l2.293 2.293a1 1 0 010 1.414l-2.293 2.293a1 1 0 01-1.414 0L11 5.882z"></path></svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucun Spotlight à l'affiche</h3>
                    <p class="text-slate-500 mb-8 max-w-xs mx-auto">Vérifiez plus tard pour les actualités du campus.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
