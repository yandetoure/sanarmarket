@extends('layouts.dashboard')

@section('content')
    <div class="space-y-12">
        <!-- Admin Command Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 pb-4" data-aos="fade-down">
            <div class="space-y-2">
                <div class="flex items-center space-x-3 mb-2">
                    <span
                        class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100">Super
                        Admin</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Système Global</span>
                </div>
                <h1 class="text-4xl font-display font-black text-slate-900 leading-tight">
                    Console <span class="text-gradient">Stratégique</span>
                </h1>
                <p class="text-slate-500 font-medium max-w-lg">Supervision complète de l'écosystème SanarWeb. Analysez,
                    modérez et optimisez la plateforme.</p>
            </div>
            <div class="flex items-center space-x-4">
                <x-button href="#" variant="secondary" size="lg"
                    class="rounded-2xl border-slate-100 shadow-xl shadow-slate-200/50 py-5 px-8 group font-black uppercase tracking-widest text-[10px]">
                    <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-primary-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2-8H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2z">
                        </path>
                    </svg>
                    <span>Générer Rapports</span>
                </x-button>
            </div>
        </div>

        <!-- Advanced Analytics Command Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">
            <!-- Users Pulse -->
            <div
                class="glass-light p-8 rounded-[3rem] border-white/60 shadow-2xl shadow-blue-100/30 group hover:bg-white transition-all duration-700">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">+12%</span>
                        <span class="text-[9px] font-bold text-slate-300 uppercase mt-2">Ce mois</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Utilisateurs Actifs</p>
                <p class="text-4xl font-display font-black text-slate-900 leading-none">{{ $totalUsers }}</p>
            </div>

            <!-- Content Flow -->
            <div
                class="glass-light p-8 rounded-[3rem] border-white/60 shadow-2xl shadow-purple-100/30 group hover:bg-white transition-all duration-700">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-black text-orange-500 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">{{ $pendingAnnouncements }}</span>
                        <span class="text-[9px] font-bold text-slate-300 uppercase mt-2">À Valider</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Annonces</p>
                <p class="text-4xl font-display font-black text-slate-900 leading-none">{{ $totalAnnouncements }}</p>
            </div>

            <!-- Marketplace Volume -->
            <div
                class="glass-light p-8 rounded-[3rem] border-white/60 shadow-2xl shadow-emerald-100/30 group hover:bg-white transition-all duration-700">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">{{ $subscribedBoutiques }}</span>
                        <span class="text-[9px] font-bold text-slate-300 uppercase mt-2">Premium</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Boutiques Indexées</p>
                <p class="text-4xl font-display font-black text-slate-900 leading-none">{{ $totalBoutiques }}</p>
            </div>

            <!-- Hospitality Pulse -->
            <div
                class="glass-light p-8 rounded-[3rem] border-white/60 shadow-2xl shadow-orange-100/30 group hover:bg-white transition-all duration-700">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex flex-col items-end">
                        <span
                            class="text-[10px] font-black text-purple-500 bg-purple-50 px-3 py-1 rounded-full border border-purple-100">{{ $pendingRestaurants }}</span>
                        <span class="text-[9px] font-bold text-slate-300 uppercase mt-2">Audit</span>
                    </div>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Restaurants Gastros</p>
                <p class="text-4xl font-display font-black text-slate-900 leading-none">{{ $totalRestaurants }}</p>
            </div>
        </div>

        <!-- Data Command Centers -->
        <div class="grid lg:grid-cols-2 gap-12" data-aos="fade-up">
            <!-- User Ecosystem -->
            <div class="glass rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/50 overflow-hidden">
                <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-white/40">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-black text-slate-900">Nouveaux Inscrits</h3>
                    </div>
                    <a href="{{ route('admin.users') }}"
                        class="text-[10px] font-black text-primary-600 uppercase tracking-widest hover:text-primary-700 transition-colors">Explorer
                        la base</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                    Identité</th>
                                <th class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">Type
                                    de Profil</th>
                                <th
                                    class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentUsers as $user)
                                <tr class="group hover:bg-primary-50/30 transition-all duration-300">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-10 h-10 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 font-black text-xs uppercase shadow-sm group-hover:scale-110 transition-transform">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p
                                                    class="text-sm font-black text-slate-900 group-hover:text-primary-600 transition-colors">
                                                    {{ $user->name }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <div class="flex">
                                            <x-badge
                                                variant="{{ $user->role === 'admin' ? 'purple' : ($user->role === 'premium' ? 'primary' : 'slate') }}"
                                                size="xs"
                                                class="rounded-xl px-4 py-1 font-black uppercase tracking-widest text-[8px] shadow-sm">
                                                {{ $user->role }}
                                            </x-badge>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <button
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all flex items-center justify-center ml-auto">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Moderation Center -->
            <div class="glass rounded-[3.5rem] border-white shadow-2xl shadow-slate-200/50 overflow-hidden">
                <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-white/40">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white shadow-xl shadow-primary-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-display font-black text-slate-900">Alertes Moderation</h3>
                    </div>
                    <a href="{{ route('admin.announcements') }}"
                        class="text-[10px] font-black text-primary-600 uppercase tracking-widest hover:text-primary-700 transition-colors">Vérifier
                        tout</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                    Publication</th>
                                <th class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest">État
                                    Actuel</th>
                                <th
                                    class="px-10 py-5 text-[9px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Décision</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentAnnouncements as $announcement)
                                <tr class="group hover:bg-orange-50/30 transition-all duration-300">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-slate-100 overflow-hidden shadow-sm group-hover:rotate-3 transition-transform duration-500">
                                                <img src="{{ storage_url($announcement->media->first()?->path) }}" alt=""
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-black text-slate-900 leading-none truncate mb-1">
                                                    {{ $announcement->title }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">par
                                                    {{ $announcement->user->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <div class="flex">
                                            <x-badge variant="{{ $announcement->status === 'active' ? 'emerald' : 'orange' }}"
                                                size="xs"
                                                class="rounded-xl px-4 py-1 font-black uppercase tracking-widest text-[8px] shadow-sm">
                                                {{ $announcement->status }}
                                            </x-badge>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        @if($announcement->validation_status === 'pending')
                                            <div class="flex items-center justify-end space-x-3">
                                                <form action="{{ route('admin.announcements.approve', $announcement) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center shadow-lg shadow-emerald-500/10 hover:shadow-emerald-500/25">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.announcements.reject', $announcement) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-10 h-10 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center shadow-lg shadow-red-500/10 hover:shadow-red-500/25">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div
                                                class="inline-flex items-center px-4 py-1.5 rounded-xl bg-slate-50 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                                {{ $announcement->validation_status }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection