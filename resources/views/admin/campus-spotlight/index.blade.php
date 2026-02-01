@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Campus Spotlight</h1>
                <p class="text-slate-500 mt-1">Gérez les contenus à la une du campus</p>
            </div>
            <a href="{{ route('admin.campus-spotlight.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-pink-600 to-rose-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                + Nouveau Spotlight
            </a>
        </div>

        <!-- Spotlights List -->
        <div class="glass rounded-3xl border border-white shadow-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Contenu
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Auteur
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-slate-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($spotlights as $spotlight)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($spotlight->image_url)
                                        <img src="{{ $spotlight->image_url }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $spotlight->title }}</p>
                                        <p class="text-xs text-slate-500">{{ Str::limit($spotlight->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-bold">
                                    {{ ucfirst($spotlight->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-semibold text-slate-700">{{ $spotlight->user->name }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($spotlight->is_published)
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Publié</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Brouillon</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $spotlight->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <form action="{{ route('admin.campus-spotlight.toggle', $spotlight) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-900">
                                        {{ $spotlight->is_published ? 'Dépublier' : 'Publier' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.campus-spotlight.destroy', $spotlight) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Aucun contenu spotlight trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $spotlights->links() }}
        </div>
    </div>
@endsection