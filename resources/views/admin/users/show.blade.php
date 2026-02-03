@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users') }}"
                    class="btn btn-ghost btn-circle text-slate-500 hover:bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-display font-black text-slate-900">Détails utilisateur</h1>
                    <p class="text-slate-500">Gérez les informations et l'abonnement de {{ $user->name }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Info Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Info -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-8">
                    <div class="flex items-start justify-between mb-8">
                        <div class="flex items-center space-x-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2>
                                <p class="text-slate-500 mb-2">{{ $user->email }}</p>
                                <div class="flex gap-2">
                                    <span class="badge {{ $user->is_active ? 'badge-success text-white' : 'badge-error text-white' }}">
                                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                    <span class="badge badge-outline border-slate-300 text-slate-600 uppercase text-xs font-bold tracking-wider">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Téléphone</p>
                            <p class="font-semibold text-slate-700">{{ $user->phone ?? 'Non renseigné' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Inscrit le</p>
                            <p class="font-semibold text-slate-700">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Dernière connexion</p>
                            <p class="font-semibold text-slate-700">Aucune info</p>
                        </div>
                    </div>
                </div>

                <!-- Related Content -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-8">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 font-display">Contenu associé</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <span class="block text-2xl font-black text-indigo-600 mb-1">{{ $user->announcements->count() }}</span>
                            <span class="text-xs font-bold text-slate-500 uppercase">Annonces</span>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <span class="block text-2xl font-black text-purple-600 mb-1">{{ $user->boutiques->count() }}</span>
                            <span class="text-xs font-bold text-slate-500 uppercase">Boutiques</span>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <span class="block text-2xl font-black text-pink-600 mb-1">{{ $user->restaurants->count() }}</span>
                            <span class="text-xs font-bold text-slate-500 uppercase">Restaurants</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar / Subscription -->
            <div class="space-y-6">
                <!-- Current Subscription Status -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6 bg-gradient-to-br from-slate-800 to-slate-900 text-white">
                        <h3 class="text-lg font-bold font-display flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 5a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1V8a1 1 0 011-1zm5-5a1 1 0 011 1v1.5l1.33 2.66a1 1 0 01-1.33 1.33L11 8.5V11a1 1 0 11-2 0V8.5L7.67 9.83a1 1 0 01-1.33-1.33l1.33-2.66V3a1 1 0 011-1h2z" clip-rule="evenodd" />
                            </svg>
                            Abonnement Actuel
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if($user->activeSubscription)
                            <div class="text-center py-4">
                                <div class="inline-block px-4 py-1 rounded-full bg-yellow-100 text-yellow-800 font-black text-sm uppercase mb-3">
                                    {{ $user->activeSubscription->plan->name }}
                                </div>
                                <p class="text-slate-500 text-sm mb-4">
                                    Expire le 
                                    <strong class="text-slate-900">
                                        {{ $user->activeSubscription->ends_at->format('d/m/Y') }}
                                    </strong>
                                </p>
                                <div class="w-full bg-slate-100 rounded-full h-2 mb-2 overflow-hidden">
                                     @php
                                        $total = $user->activeSubscription->starts_at->diffInDays($user->activeSubscription->ends_at);
                                        $remaining = now()->diffInDays($user->activeSubscription->ends_at, false);
                                        $percent = $total > 0 ? max(0, min(100, ($remaining / $total) * 100)) : 0;
                                     @endphp
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                                <p class="text-xs text-slate-400">{{ (int)$remaining }} jours restants</p>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </div>
                                <p class="font-bold text-slate-700">Aucun abonnement actif</p>
                                <p class="text-sm text-slate-500">Cet utilisateur est en mode gratuit standard.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Assign Subscription -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900">Assigner un abonnement</h3>
                    </div>
                    <form action="{{ route('admin.users.assign-subscription', $user) }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-slate-600">Plan</span></label>
                            <select name="subscription_plan_id" class="select select-bordered w-full rounded-xl">
                                @foreach($subscriptionPlans as $plan)
                                    <option value="{{ $plan->id }}">
                                        {{ $plan->name }} ({{ number_format($plan->price, 0, ',', ' ') }} FCFA - {{ $plan->duration_days }}j)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-slate-600">Durée (Optionnel)</span></label>
                            <input type="number" name="duration_days" placeholder="Défaut du plan" class="input input-bordered w-full rounded-xl">
                            <label class="label">
                                <span class="label-text-alt text-slate-400">Laisser vide pour utiliser la durée par défaut du plan.</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-full rounded-xl">
                            Assigner l'abonnement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
