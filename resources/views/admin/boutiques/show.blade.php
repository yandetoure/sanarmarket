@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.boutiques') }}"
                    class="p-2 rounded-full bg-white text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-colors shadow-sm border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-display font-black text-slate-900">{{ $boutique->name }}</h1>
                    <p class="text-slate-500 mt-1">Détails de la boutique</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('admin.boutiques.toggle-subscription', $boutique) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $boutique->is_subscribed ? 'bg-purple-100 text-purple-700 hover:bg-purple-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $boutique->is_subscribed ? 'Désabonner' : 'Abonner' }}
                    </button>
                </form>

                @if ($boutique->validation_status === 'pending')
                    <form action="{{ route('admin.boutiques.approve', $boutique) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition-all shadow-lg shadow-green-500/30">
                            Approuver
                        </button>
                    </form>
                    <form action="{{ route('admin.boutiques.reject', $boutique) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 transition-all shadow-lg shadow-red-500/30">
                            Rejeter
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Cover & Details -->
                <div class="glass rounded-3xl border border-white shadow-xl overflow-hidden p-6 space-y-6">
                    <div class="aspect-video rounded-2xl overflow-hidden bg-slate-100 relative">
                        @if ($boutique->cover_image)
                            <img src="{{ asset('storage/' . $boutique->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute bottom-4 left-4">
                            @if ($boutique->logo)
                                <img src="{{ asset('storage/' . $boutique->logo) }}"
                                    class="w-20 h-20 rounded-2xl border-4 border-white shadow-lg object-cover bg-white">
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">À propos</h3>
                            <p class="text-slate-700">{{ $boutique->description ?? 'Aucune description' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Contact</h3>
                            <ul class="space-y-2 text-slate-700">
                                <li class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="mr-2 text-slate-400">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    {{ $boutique->address }}
                                </li>
                                <li class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="mr-2 text-slate-400">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                        </path>
                                    </svg>
                                    {{ $boutique->phone }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Articles -->
                <div>
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Articles récents</h2>
                    <div class="glass rounded-3xl border border-white shadow-xl overflow-hidden">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                                        Article</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                                        Prix</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-black text-slate-600 uppercase tracking-wider">
                                        Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($boutique->articles->take(5) as $article)
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if ($article->images && count($article->images) > 0)
                                                    <img src="{{ asset('storage/' . $article->images[0]) }}"
                                                        class="w-10 h-10 rounded-lg object-cover mr-3">
                                                @endif
                                                <span class="font-medium text-slate-900">{{ $article->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ number_format($article->price, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-bold {{ $article->is_available ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                {{ $article->is_available ? 'Disponible' : 'Indisponible' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-slate-400">
                                            Aucun article trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <!-- Status Card -->
                <div class="glass rounded-3xl border border-white shadow-xl p-6 space-y-6">
                    <h3 class="text-lg font-bold text-slate-900">État de la boutique</h3>

                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Validation</span>
                        @if ($boutique->validation_status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold">Approuvée</span>
                        @elseif($boutique->validation_status === 'rejected')
                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-bold">Rejetée</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold">En
                                attente</span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Abonnement</span>
                        @if ($boutique->is_subscribed)
                            <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-bold">Abonné</span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-bold">Standard</span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Créée le</span>
                        <span class="font-medium text-slate-900">{{ $boutique->created_at->format('d/m/Y') }}</span>
                    </div>

                    @if($boutique->validator)
                        <div class="pt-4">
                            <span class="block text-xs text-slate-400 mb-1">Validée par</span>
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-xs mr-2">
                                    {{ substr($boutique->validator->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">{{ $boutique->validator->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $boutique->validated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Owner Card -->
                <div class="glass rounded-3xl border border-white shadow-xl p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Propriétaire</h3>
                    <div class="flex items-center mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30 mr-4">
                            {{ substr($boutique->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ $boutique->user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $boutique->user->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users', ['search' => $boutique->user->email]) }}"
                        class="block w-full py-3 bg-slate-50 text-slate-600 font-bold text-center rounded-xl hover:bg-slate-100 transition-colors">
                        Voir le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection