@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Gestion des Annonces</h1>
                <p class="text-slate-500 mt-1">Toutes les annonces de la plateforme</p>
            </div>
            <a href="{{ route('admin.announcements.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                + Nouvelle Annonce
            </a>
        </div>

        <!-- Filters -->
        <div class="glass rounded-3xl border border-white shadow-2xl p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                    class="px-4 py-3 rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500">

                <select name="status"
                    class="px-4 py-3 rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirée</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetée</option>
                </select>

                <select name="category"
                    class="px-4 py-3 rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Toutes catégories</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                    Filtrer
                </button>
            </form>
        </div>

        <!-- Announcements List -->
        <div class="glass rounded-3xl border border-white shadow-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Annonce
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Utilisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Catégorie
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Prix</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-slate-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($announcement->primaryMedia())
                                        <img src="{{ $announcement->primaryMedia()->url }}"
                                            class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900">{{ Str::limit($announcement->title, 40) }}</p>
                                        <p class="text-xs text-slate-500">{{ $announcement->location }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-semibold text-slate-700">{{ $announcement->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $announcement->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-bold">
                                    {{ $announcement->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-900">
                                {{ number_format($announcement->price, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($announcement->status === 'active')
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Active</span>
                                @elseif($announcement->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold">En
                                        attente</span>
                                @elseif($announcement->status === 'expired')
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Expirée</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Rejetée</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $announcement->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.announcements.show', $announcement) }}"
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

                                    <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                        class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-indigo-600 hover:bg-indigo-50"
                                        title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    @if($announcement->status === 'pending')
                                        <form action="{{ route('admin.announcements.approve', $announcement) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm btn-ghost btn-circle text-green-500 hover:text-green-700 hover:bg-green-50"
                                                title="Approuver">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.announcements.reject', $announcement) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm btn-ghost btn-circle text-red-500 hover:text-red-700 hover:bg-red-50"
                                                title="Rejeter">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                Aucune annonce trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    </div>
@endsection