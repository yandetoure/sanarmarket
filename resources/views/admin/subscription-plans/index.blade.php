@extends('layouts.dashboard')

@section('content')
    <div class="px-8 py-5">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-black text-slate-900">Plans d'abonnement</h1>
            <a href="{{ route('admin.subscription-plans.create') }}"
                class="btn btn-primary rounded-xl shadow-lg border-0 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouveau Plan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-lg mb-6 rounded-2xl text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($plans as $plan)
                <div class="card bg-white shadow-xl rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="card-body p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="card-title text-xl font-bold text-slate-800">{{ $plan->name }}</h2>
                                <span class="text-sm text-slate-500">{{ $plan->duration_days }} jours</span>
                            </div>
                            @if ($plan->is_featured)
                                <span class="badge badge-warning gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Populaire
                                </span>
                            @endif
                        </div>

                        <div class="text-3xl font-black text-primary-600 mb-2">
                            {{ number_format($plan->price, 0, ',', ' ') }} FCFA
                        </div>

                        <p class="text-slate-600 mb-6 text-sm">{{ $plan->description }}</p>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <strong>{{ $plan->max_announcements }}</strong> &nbsp;annonces max
                            </div>
                            <div class="flex items-center text-sm text-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <strong>{{ $plan->max_photos_per_announcement }}</strong> &nbsp;photos/annonce
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                            <span class="badge {{ $plan->is_active ? 'badge-success text-white' : 'badge-ghost' }}">
                                {{ $plan->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.subscription-plans.edit', $plan) }}"
                                    class="btn btn-sm btn-outline btn-primary rounded-lg">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plan ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline btn-error rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Aucun plan d'abonnement</h3>
                        <p class="text-slate-500 max-w-sm mx-auto mb-6">Commencez par créer des plans pour permettre aux
                            utilisateurs de souscrire.</p>
                        <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary rounded-xl">
                            Créer un plan maintenant
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection