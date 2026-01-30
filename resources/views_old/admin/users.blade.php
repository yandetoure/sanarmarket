@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Utilisateurs</h1>
            <p class="text-gray-600 mt-2">Gérez les comptes utilisateurs et leurs rôles</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all flex items-center gap-2 shadow-md">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Ajouter un utilisateur
        </a>
    </div>
</div>

    <!-- Liste des utilisateurs -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Liste des Utilisateurs</h2>
        </div>

        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Premium</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonces</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <i data-lucide="user" class="w-5 h-5 text-gray-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">Inscrit {{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role_color }}">
                                        {{ $user->role_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="{{ route('admin.users.toggle-premium', $user) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $user->isPremium() ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $user->isPremium() ? 'Premium' : 'Standard' }}
                                        </span>
                                        @if(in_array($user->role, ['user', 'premium']))
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                {{ $user->isPremium() ? 'Retirer' : 'Activer' }}
                                            </button>
                                        @else
                                            <span class="text-[11px] text-gray-400">N/A</span>
                                        @endif
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->announcements_count }} annonce{{ $user->announcements_count > 1 ? 's' : '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <!-- Changer le rôle -->
                                        <form method="POST" action="{{ route('admin.users.change-role', $user) }}" class="inline">
                                            @csrf
                                            <select name="role" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded px-2 py-1">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                                <option value="premium" {{ $user->role === 'premium' ? 'selected' : '' }}>Premium</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="designer" {{ $user->role === 'designer' ? 'selected' : '' }}>Designer</option>
                                                <option value="marketing" {{ $user->role === 'marketing' ? 'selected' : '' }}>Marketing</option>
                                            </select>
                                        </form>

                                        <!-- Activer/Désactiver -->
                                        <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-{{ $user->is_active ? 'red' : 'green' }}-600 hover:text-{{ $user->is_active ? 'red' : 'green' }}-900 text-xs">
                                                {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $users->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i data-lucide="users" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun utilisateur</h3>
                <p class="text-gray-500">Aucun utilisateur trouvé.</p>
            </div>
        @endif
    </div>
</div>

@endsection
