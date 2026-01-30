@extends('layouts.app')

@section('title', 'Groupes de Discussion - Sanar Market')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <!-- Hero Section -->
        <header class="relative py-20 overflow-hidden bg-slate-900 text-center">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1529156069898-49953e39b30c?auto=format&fit=crop&q=80&w=2000"
                    alt="" class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div data-aos="fade-up">
                    <h1 class="text-4xl md:text-6xl font-display font-black text-white mb-6">
                        Vos <span class="text-gradient">Communautés</span>.
                    </h1>
                    <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                        Rejoignez des groupes thématiques pour échanger avec des étudiants partageant vos centres d'intérêt,
                        vos cours ou vos passions.
                    </p>
                    @auth
                        <x-button href="{{ route('forum.groups.create') }}" variant="primary" size="lg"
                            class="shadow-2xl shadow-primary-500/20">
                            + Créer un groupe
                        </x-button>
                    @endauth
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-center justify-between mb-12" data-aos="fade-up">
                <div>
                    <h2 class="text-2xl font-display font-bold text-slate-900">Explorer les Groupes</h2>
                    <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">
                        {{ $groups->count() }} communauté{{ $groups->count() > 1 ? 's' : '' }}
                        active{{ $groups->count() > 1 ? 's' : '' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($groups as $index => $group)
                    <div class="glass p-8 rounded-[3rem] border-white/60 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-primary-100 transition-all duration-500 flex flex-col group relative overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">

                        <!-- Decorative Background element -->
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-primary-100 rounded-full blur-3xl opacity-0 group-hover:opacity-40 transition-opacity">
                        </div>

                        <div class="flex items-start justify-between mb-6 relative z-10">
                            <div
                                class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-display font-black text-2xl shadow-lg shadow-primary-100">
                                {{ strtoupper(substr($group->name, 0, 1)) }}
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Membres</span>
                                <p class="text-lg font-display font-black text-slate-900">{{ $group->members_count ?? 0 }}</p>
                            </div>
                        </div>

                        <div class="flex-grow relative z-10">
                            <h3
                                class="text-2xl font-display font-bold text-slate-900 mb-3 group-hover:text-primary-600 transition-colors line-clamp-1">
                                {{ $group->name }}
                            </h3>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed line-clamp-3 mb-8">
                                {{ $group->description ?? 'Aucune description disponible pour ce groupe.' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3 relative z-10">
                            <x-button href="{{ route('forum.index', ['group' => $group->slug]) }}" variant="primary" size="sm"
                                class="flex-1">Discussion</x-button>
                            <x-button href="{{ route('forum.groups.show', $group) }}" variant="secondary" size="sm"
                                class="flex-1">Profil</x-button>
                        </div>

                        @if(isset($userGroupIds) && in_array($group->id, $userGroupIds))
                            <div class="mt-4 text-center">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-emerald-500 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                        </path>
                                    </svg>
                                    Vous êtes membre
                                </span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center glass rounded-[3rem] border-slate-100" data-aos="zoom-in">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-bold text-slate-900 mb-2">Aucun groupe trouvé</h3>
                        <p class="text-slate-500 mb-8 max-w-xs mx-auto">Soyez le premier à créer une communauté sur Sanar
                            Market.</p>
                        @auth
                            <x-button href="{{ route('forum.groups.create') }}" variant="primary">Créer un groupe</x-button>
                        @endauth
                    </div>
                @endforelse
            </div>

            <div class="mt-16 flex justify-center">
                {{ $groups->links() }}
            </div>
        </main>
    </div>
@endsection