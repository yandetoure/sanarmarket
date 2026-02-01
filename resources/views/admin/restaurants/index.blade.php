@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Gestion des Restaurants</h1>
                <p class="text-slate-500 mt-1">Tous les restaurants de la plateforme</p>
            </div>
        </div>

        <!-- Restaurants List -->
        <div class="glass rounded-3xl border border-white shadow-2xl overflow-hidden">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Restaurant</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                            Propriétaire</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Menu</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-slate-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($restaurants as $restaurant)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($restaurant->logo)
                                        <img src="{{ asset('storage/' . $restaurant->logo) }}"
                                            class="w-12 h-12 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $restaurant->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $restaurant->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-semibold text-slate-700">{{ $restaurant->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $restaurant->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-bold">
                                    {{ $restaurant->menu_items_count }} plats
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($restaurant->is_subscribed)
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">✓
                                        Abonné</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Non
                                        abonné</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $restaurant->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('restaurants.public.show', $restaurant) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-900">Voir</a>
                                <form action="{{ route('admin.restaurants.toggle-subscription', $restaurant) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-900">
                                        {{ $restaurant->is_subscribed ? 'Désabonner' : 'Abonner' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                Aucun restaurant trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $restaurants->links() }}
        </div>
    </div>
@endsection