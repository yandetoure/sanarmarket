@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-display font-bold text-slate-900">Ravi de vous revoir,
                    {{ explode(' ', auth()->user()->name)[0] }} ! 👋</h1>
                <p class="text-slate-500 mt-1">Voici ce qui se passe sur votre compte aujourd'hui.</p>
            </div>
            <div class="flex items-center space-x-3">
                <x-button href="{{ route('announcements.create') }}" variant="primary" size="md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouvelle Annonce
                </x-button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-5">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Mes Annonces</p>
                    <p class="text-2xl font-display font-bold text-slate-900">{{ auth()->user()->announcements()->count() }}
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-5">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Boutiques</p>
                    <p class="text-2xl font-display font-bold text-slate-900">{{ auth()->user()->boutiques()->count() }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-5">
                <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Discussions</p>
                    <p class="text-2xl font-display font-bold text-slate-900">{{ auth()->user()->forumReplies()->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Recent Announcements -->
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-display font-bold text-slate-900">Mes dernières annonces</h3>
                    <a href="{{ route('dashboard.announcements') }}"
                        class="text-xs font-bold text-primary-600 uppercase tracking-wider hover:text-primary-700">Tout
                        voir</a>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse(auth()->user()->announcements()->latest()->take(5)->get() as $announcement)
                        <div class="p-4 flex items-center space-x-4 hover:bg-slate-50 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow min-w-0">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $announcement->title }}</p>
                                <p class="text-xs text-slate-500">{{ $announcement->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                <x-badge
                                    variant="{{ $announcement->status === 'active' ? 'emerald' : ($announcement->status === 'pending' ? 'orange' : 'slate') }}"
                                    size="xs">
                                    {{ $announcement->status }}
                                </x-badge>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-400 text-sm">Vous n'avez pas encore publié d'annonce.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Tips or Campus Info -->
            <div class="space-y-6">
                <div class="bg-primary-600 rounded-[2rem] p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                    <h3 class="text-xl font-display font-bold relative z-10">Devenez Annonceur Premium</h3>
                    <p class="mt-2 text-primary-100 text-sm relative z-10">Mettez vos annonces en avant et débloquez des
                        fonctionnalités exclusives pour vendre plus vite.</p>
                    <x-button variant="secondary" size="sm" class="mt-6 border-none">En savoir plus</x-button>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8">
                    <h3 class="font-display font-bold text-slate-900">Centre d'aide</h3>
                    <p class="mt-2 text-slate-500 text-sm">Besoin d'aide pour utiliser la plateforme ? Consultez nos guides
                        ou contactez l'équipe de modération.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="#"
                            class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">Comment
                            vendre ?</a>
                        <a href="#"
                            class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">Règles
                            du forum</a>
                        <a href="#"
                            class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-colors">Nous
                            contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection