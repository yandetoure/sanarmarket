@section('content')
    <div class="space-y-12">
        <!-- Premium Hub Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 pb-4" data-aos="fade-down">
            <div class="space-y-2">
                <div class="flex items-center space-x-3 mb-2">
                    <span
                        class="px-3 py-1 rounded-full bg-primary-50 text-primary-600 text-[10px] font-black uppercase tracking-widest border border-primary-100">Tableau
                        de bord</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                    Ravi de vous revoir,<br>
                    <span class="text-gradient">{{ explode(' ', auth()->user()->name)[0] }}</span> ! 👋
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <x-button href="{{ route('announcements.create') }}" variant="primary" size="lg"
                    class="rounded-2xl shadow-2xl shadow-primary-500/25 py-5 px-8 group">
                    <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Vendre quelque chose</span>
                </x-button>
            </div>
        </div>

        <!-- Metric Command Center -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Metric Tile: Announcements -->
            <div class="glass p-10 rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/50 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                data-aos="fade-up">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-blue-100 transition-colors">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2 leading-none">Annonces
                        Actives</p>
                    <div class="flex items-end space-x-2">
                        <span class="text-4xl font-display font-black text-slate-900 leading-none">
                            {{ auth()->user()->announcements()->where('status', 'active')->count() }}
                        </span>
                        <span class="text-xs font-bold text-slate-400 mb-1">/ {{ auth()->user()->announcements()->count() }}
                            total</span>
                    </div>
                </div>
            </div>

            <!-- Metric Tile: Forums -->
            <div class="glass p-10 rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/50 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                data-aos="fade-up" data-aos-delay="100">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-indigo-50/50 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-indigo-100 transition-colors">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2 leading-none">
                        Interactions Forum</p>
                    <div class="flex items-end space-x-2">
                        <span class="text-4xl font-display font-black text-slate-900 leading-none">
                            {{ auth()->user()->forumReplies()->count() + auth()->user()->forumThreads()->count() }}
                        </span>
                        <span class="text-xs font-bold text-slate-400 mb-1">Engagements</span>
                    </div>
                </div>
            </div>

            <!-- Metric Tile: Business -->
            <div class="glass p-10 rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/50 group hover:-translate-y-2 transition-all duration-500 relative overflow-hidden"
                data-aos="fade-up" data-aos-delay="200">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-emerald-50/50 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-emerald-100 transition-colors">
                </div>
                <div class="relative z-10">
                    <div
                        class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 mb-8 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-2 leading-none">Vos
                        Commerces</p>
                    <div class="flex items-end space-x-2">
                        <span class="text-4xl font-display font-black text-slate-900 leading-none">
                            {{ auth()->user()->boutiques()->count() + auth()->user()->restaurants()->count() }}
                        </span>
                        <span class="text-xs font-bold text-slate-400 mb-1">Enseignes</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-5 gap-10">
            <!-- Main Content Area: Recent Activity -->
            <div class="lg:col-span-3 space-y-8">
                <div class="glass rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/50 overflow-hidden"
                    data-aos="fade-right">
                    <div class="p-10 border-b border-slate-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-display font-black text-slate-900">Activité Récente</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Vos dernières
                                publications</p>
                        </div>
                        <x-button href="{{ route('dashboard.announcements') }}" variant="secondary" size="sm"
                            class="bg-white rounded-xl">
                            Voir tout
                        </x-button>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse(auth()->user()->announcements()->latest()->take(4)->get() as $announcement)
                            <div class="p-8 flex items-center space-x-6 hover:bg-slate-50/50 transition-all group">
                                <div
                                    class="w-20 h-20 rounded-2xl bg-slate-100 overflow-hidden flex-shrink-0 shadow-inner group-hover:scale-105 transition-transform duration-500">
                                    <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-grow min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <x-badge
                                            variant="{{ $announcement->status === 'active' ? 'emerald' : ($announcement->status === 'pending' ? 'orange' : 'slate') }}"
                                            size="sm" class="scale-90 origin-left">
                                            {{ ucfirst($announcement->status) }}
                                        </x-badge>
                                        <span
                                            class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $announcement->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p
                                        class="text-lg font-bold text-slate-900 truncate group-hover:text-primary-600 transition-colors">
                                        {{ $announcement->title }}</p>
                                    <p class="text-xs text-slate-400 font-medium truncate">
                                        {{ Str::limit($announcement->description, 60) }}</p>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('announcements.edit', $announcement) }}"
                                        class="p-3 bg-white rounded-xl shadow-sm text-slate-400 hover:text-primary-600 transition-colors block">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-20 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-bold italic">Rien à signaler pour le moment.</p>
                                <p class="text-xs text-slate-400 mt-2">Vos publications apparaîtront ici.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar: Premium & Engagement -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Exclusive Premium Invitation -->
                <div class="bg-slate-900 rounded-[3.5rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-slate-900/20 group"
                    data-aos="fade-left">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-primary-600/30 rounded-full -mr-32 -mt-32 blur-3xl group-hover:scale-150 transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center space-x-3 mb-8">
                            <span
                                class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center shadow-lg shadow-orange-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                            </span>
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-400">Offre
                                Exclusive</span>
                        </div>
                        <h3 class="text-3xl font-display font-black leading-tight">Accélérez vos <span
                                class="text-blue-400">Ventes</span></h3>
                        <p class="mt-4 text-slate-400 font-medium leading-relaxed">Boostez vos annonces en tête de liste et
                            profitez d'une visibilité prioritaire sur tout le campus.</p>
                        <x-button variant="secondary" size="lg"
                            class="mt-10 bg-white text-slate-900 border-none hover:bg-slate-50 shadow-xl shadow-white/10 w-full py-5 rounded-2xl group flex items-center justify-center">
                            <span>Devenir Premium</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </x-button>
                    </div>
                </div>

                <!-- Strategic Quick Links -->
                <div class="grid grid-cols-2 gap-6" data-aos="fade-up">
                    <a href="#"
                        class="glass-light p-8 rounded-[2.5rem] border-white shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:bg-white transition-all group">
                        <div
                            class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-display font-black text-slate-900 text-sm mb-1 leading-tight">Guide Vendeur</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Masterclass</p>
                    </a>
                    <a href="https://wa.me/221772319878" target="_blank"
                        class="glass-light p-8 rounded-[2.5rem] border-white shadow-xl shadow-slate-200/30 hover:shadow-2xl hover:bg-white transition-all group">
                        <div
                            class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-display font-black text-slate-900 text-sm mb-1 leading-tight">Concierge</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Support 24/7</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection