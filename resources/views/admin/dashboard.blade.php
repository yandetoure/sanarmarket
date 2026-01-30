@extends('layouts.dashboard')

@section('content')
<div class="space-y-10">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-900">Console d'Administration</h1>
            <p class="text-slate-500 mt-1">Gérez l'ensemble de l'écosystème SanarWeb.</p>
        </div>
        <div class="flex items-center space-x-3">
            <x-button href="#" variant="secondary" size="md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2-8H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2z"></path></svg>
                Exporter Rapports
            </x-button>
        </div>
    </div>

    <!-- Main Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
            </div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Utilisateurs</p>
            <p class="text-3xl font-display font-bold text-slate-900 mt-1">{{ $totalUsers }}</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-lg">{{ $pendingAnnouncements }} attente</span>
            </div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Annonces</p>
            <p class="text-3xl font-display font-bold text-slate-900 mt-1">{{ $totalAnnouncements }}</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-lg">{{ $subscribedBoutiques }} premium</span>
            </div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Boutiques</p>
            <p class="text-3xl font-display font-bold text-slate-900 mt-1">{{ $totalBoutiques }}</p>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-lg">{{ $pendingRestaurants }} attente</span>
            </div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Restaurants</p>
            <p class="text-3xl font-display font-bold text-slate-900 mt-1">{{ $totalRestaurants }}</p>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-display font-bold text-slate-900">Nouveaux Utilisateurs</h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-bold text-primary-600 uppercase tracking-wider hover:text-primary-700">Tout voir</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Utilisateur</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Rôle</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentUsers as $user)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 leading-none">{{ $user->name }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge variant="{{ $user->role === 'admin' ? 'purple' : ($user->role === 'premium' ? 'primary' : 'slate') }}" size="xs">
                                        {{ $user->role }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#" class="text-slate-400 hover:text-slate-900 transition-colors">
                                        <svg class="w-5 h-5 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-display font-bold text-slate-900">Dernières Annonces</h3>
                <a href="{{ route('admin.announcements') }}" class="text-xs font-bold text-primary-600 uppercase tracking-wider hover:text-primary-700">Tout voir</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Annonce</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Statut</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Validation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentAnnouncements as $announcement)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden">
                                            <img src="{{ storage_url($announcement->media->first()?->path) }}" alt="" class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-900 leading-none truncate">{{ $announcement->title }}</p>
                                            <p class="text-[10px] text-slate-400 mt-1">par {{ $announcement->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge variant="{{ $announcement->status === 'active' ? 'emerald' : 'orange' }}" size="xs">
                                        {{ $announcement->status }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($announcement->validation_status === 'pending')
                                        <div class="flex items-center justify-end space-x-2">
                                            <form action="{{ route('admin.announcements.approve', $announcement) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.announcements.reject', $announcement) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $announcement->validation_status }}</span>
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
