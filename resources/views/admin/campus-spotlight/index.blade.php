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
                + Nouvel Article
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.campus-spotlight.edit', $spotlight) }}"
                                        class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-indigo-600 hover:bg-indigo-50"
                                        title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.campus-spotlight.toggle', $spotlight) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm btn-ghost btn-circle {{ $spotlight->is_published ? 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' : 'text-slate-300 hover:text-blue-600 hover:bg-blue-50' }}"
                                            title="{{ $spotlight->is_published ? 'Dépublier' : 'Publier' }}">
                                            @if($spotlight->is_published)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.campus-spotlight.destroy', $spotlight) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-ghost btn-circle text-slate-500 hover:text-red-600 hover:bg-red-50"
                                            title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
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