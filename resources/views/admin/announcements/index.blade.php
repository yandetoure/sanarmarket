@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Gestion des Annonces</h1>
                <p class="text-slate-500 mt-1">Toutes les annonces de la plateforme</p>
            </div>
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.announcements.show', $announcement) }}"
                                    class="text-blue-600 hover:text-blue-900">Voir</a>
                                @if($announcement->status === 'pending')
                                    <form action="{{ route('admin.announcements.approve', $announcement) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Approuver</button>
                                    </form>
                                    <form action="{{ route('admin.announcements.reject', $announcement) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Rejeter</button>
                                    </form>
                                @endif
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