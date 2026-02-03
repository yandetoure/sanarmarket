@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Gestion des Boutiques</h1>
                <p class="text-slate-500 mt-1">Toutes les boutiques de la plateforme</p>
            </div>
            <a href="{{ route('admin.boutiques.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                + Nouvelle Boutique
            </a>
        </div>

        <!-- Boutiques List -->
        <div class="glass rounded-3xl border border-white shadow-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Boutique
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Propriétaire</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Articles
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-slate-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($boutiques as $boutique)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($boutique->logo)
                                        <img src="{{ asset('storage/' . $boutique->logo) }}"
                                            class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $boutique->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $boutique->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-semibold text-slate-700">{{ $boutique->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $boutique->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold">
                                    {{ $boutique->articles_count }} articles
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($boutique->is_subscribed)
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">✓
                                        Abonné</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Non
                                        abonné</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $boutique->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.boutiques.edit', $boutique) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                <a href="{{ route('admin.boutiques.show', $boutique) }}"
                                    class="text-blue-600 hover:text-blue-900">Voir</a>
                                <form action="{{ route('admin.boutiques.toggle-subscription', $boutique) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-900">
                                        {{ $boutique->is_subscribed ? 'Désabonner' : 'Abonner' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Aucune boutique trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $boutiques->links() }}
        </div>
    </div>
@endsection