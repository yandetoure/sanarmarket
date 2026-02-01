@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('admin.announcements') }}"
                    class="text-blue-600 hover:text-blue-800 text-sm font-semibold mb-2 inline-block">
                    ← Retour aux annonces
                </a>
                <h1 class="text-3xl font-display font-black text-slate-900">{{ $announcement->title }}</h1>
                <p class="text-slate-500 mt-1">Publié le {{ $announcement->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div class="flex space-x-3">
                @if($announcement->status === 'pending')
                    <form action="{{ route('admin.announcements.approve', $announcement) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            ✓ Approuver
                        </button>
                    </form>
                    <form action="{{ route('admin.announcements.reject', $announcement) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                            ✗ Rejeter
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Status Badge -->
        <div>
            @if($announcement->status === 'active')
                <span class="px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-bold">✓ Active</span>
            @elseif($announcement->status === 'pending')
                <span class="px-4 py-2 bg-yellow-100 text-yellow-600 rounded-full text-sm font-bold">⏳ En attente</span>
            @elseif($announcement->status === 'expired')
                <span class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full text-sm font-bold">⌛ Expirée</span>
            @else
                <span class="px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-bold">✗ Rejetée</span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Images -->
                @if($announcement->media->count() > 0)
                    <div class="glass rounded-3xl border border-white shadow-2xl p-6">
                        <h2 class="text-xl font-black text-slate-900 mb-4">📸 Images</h2>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($announcement->media as $media)
                                @if($media->type === 'image')
                                    <img src="{{ $media->url }}" alt="Image" class="w-full h-48 object-cover rounded-xl">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                <div class="glass rounded-3xl border border-white shadow-2xl p-8">
                    <h2 class="text-xl font-black text-slate-900 mb-4">📝 Description</h2>
                    <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $announcement->description }}</p>
                </div>

                <!-- Details -->
                <div class="glass rounded-3xl border border-white shadow-2xl p-8">
                    <h2 class="text-xl font-black text-slate-900 mb-6">ℹ️ Détails</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Prix</p>
                            <p class="text-2xl font-black text-slate-900">
                                {{ number_format($announcement->price, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Localisation</p>
                            <p class="text-lg font-bold text-slate-900">{{ $announcement->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Catégorie</p>
                            <span
                                class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-bold">
                                {{ $announcement->category->name }}
                            </span>
                        </div>
                        @if($announcement->subcategory)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Sous-catégorie</p>
                                <span
                                    class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm font-bold">
                                    {{ $announcement->subcategory->name }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Téléphone</p>
                            <p class="text-lg font-bold text-slate-900">{{ $announcement->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Date de publication</p>
                            <p class="text-lg font-bold text-slate-900">{{ $announcement->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- User Info -->
                <div class="glass rounded-3xl border border-white shadow-2xl p-6">
                    <h3 class="text-lg font-black text-slate-900 mb-4">👤 Utilisateur</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-500">Nom</p>
                            <p class="text-lg font-bold text-slate-900">{{ $announcement->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="text-sm text-slate-700">{{ $announcement->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Rôle</p>
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $announcement->user->roleColorClass() }}">
                                {{ $announcement->user->roleLabel() }}
                            </span>
                        </div>
                        @if($announcement->user->is_premium)
                            <div>
                                <span
                                    class="inline-block px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-bold">
                                    ⭐ Premium
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Validation Info -->
                @if($announcement->validated_by)
                    <div class="glass rounded-3xl border border-white shadow-2xl p-6">
                        <h3 class="text-lg font-black text-slate-900 mb-4">✓ Validation</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-slate-500">Validé par</p>
                                <p class="text-lg font-bold text-slate-900">{{ $announcement->validator->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Date</p>
                                <p class="text-sm text-slate-700">{{ $announcement->validated_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="glass rounded-3xl border border-white shadow-2xl p-6">
                    <h3 class="text-lg font-black text-slate-900 mb-4">⚡ Actions</h3>
                    <div class="space-y-3">
                        @if($announcement->status === 'active')
                            <form action="{{ route('admin.announcements.hide', $announcement) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-yellow-100 text-yellow-700 font-bold rounded-xl hover:bg-yellow-200 transition-all">
                                    Masquer
                                </button>
                            </form>
                        @endif

                        @if($announcement->status === 'hidden')
                            <form action="{{ route('admin.announcements.activate', $announcement) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-3 bg-green-100 text-green-700 font-bold rounded-xl hover:bg-green-200 transition-all">
                                    Activer
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('announcements.show', $announcement) }}" target="_blank"
                            class="block w-full px-4 py-3 bg-blue-100 text-blue-700 font-bold rounded-xl hover:bg-blue-200 transition-all text-center">
                            Voir en public
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection