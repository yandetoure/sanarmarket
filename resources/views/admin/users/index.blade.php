@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Gestion des Utilisateurs</h1>
                <p class="text-slate-500 mt-1">Tous les utilisateurs de la plateforme</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                + Nouvel Utilisateur
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass rounded-3xl border border-white shadow-xl p-6">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-2xl">👥</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total</p>
                        <p class="text-2xl font-black text-slate-900">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="glass rounded-3xl border border-white shadow-xl p-6">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-2xl">✅</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Actifs</p>
                        <p class="text-2xl font-black text-green-600">{{ $stats['active'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="glass rounded-3xl border border-white shadow-xl p-6">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-2xl">⭐</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Premium</p>
                        <p class="text-2xl font-black text-purple-600">{{ $stats['premium'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="glass rounded-3xl border border-white shadow-xl p-6">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center">
                        <span class="text-white text-2xl">👑</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Admins</p>
                        <p class="text-2xl font-black text-orange-600">{{ $stats['admins'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="glass rounded-3xl border border-white shadow-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Utilisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Abonnement
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Inscription</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-slate-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <span
                                            class="text-gray-600 font-bold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->roleColorClass() }}">
                                    {{ $user->roleLabel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Actif</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Inactif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->activeSubscription)
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-indigo-600">{{ $user->activeSubscription->plan->name }}</span>
                                        <span class="text-xs text-slate-400">Fin:
                                            {{ $user->activeSubscription->ends_at->format('d/m/Y') }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-slate-500">Gratuit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- View Details -->
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-blue-600 hover:bg-blue-50"
                                        title="Voir détails">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-amber-600 hover:bg-amber-50"
                                        title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Êtes-vous sûr ?');">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-ghost btn-circle {{ $user->is_active ? 'text-slate-500 hover:text-red-600 hover:bg-red-50' : 'text-slate-500 hover:text-green-600 hover:bg-green-50' }}"
                                            title="{{ $user->is_active ? 'Bloquer' : 'Activer' }}">
                                            @if($user->is_active)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.toggle-premium', $user) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-purple-600 hover:bg-purple-50"
                                            title="Basculer Premium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Aucun utilisateur trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection