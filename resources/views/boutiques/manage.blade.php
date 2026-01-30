@extends('layouts.dashboard')

@section('title', 'Gestion Boutique - ' . $boutique->name)

@section('content')
    <div class="space-y-10" x-data="{ currentTab: 'overview' }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6" data-aos="fade-down">
            <div class="flex items-center space-x-4">
                <div
                    class="w-16 h-16 rounded-[2rem] bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-display font-black text-2xl shadow-lg">
                    {{ strtoupper(substr($boutique->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-display font-black text-slate-900 leading-tight">{{ $boutique->name }}</h1>
                    <div class="flex items-center space-x-3 mt-1">
                        <x-badge variant="{{ $boutique->status === 'active' ? 'emerald' : 'orange' }}" size="sm">
                            {{ ucfirst($boutique->status) }}
                        </x-badge>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Boutique ID:
                            #{{ $boutique->id }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <x-button href="{{ route('boutiques.show', $boutique) }}" variant="secondary" size="md">Aperçu
                    Public</x-button>
                <x-button href="{{ route('boutiques.edit', $boutique) }}" variant="primary" size="md">Paramètres</x-button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" data-aos="fade-up">
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-slate-100/50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Catégories</p>
                <p class="text-3xl font-display font-black text-slate-900">{{ $boutique->categories_count }}</p>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-indigo-50/50">
                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-1">Articles</p>
                <p class="text-3xl font-display font-black text-slate-900">{{ $boutique->articles_count }}</p>
            </div>
            <div class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-emerald-50/50">
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Stock Total</p>
                <p class="text-3xl font-display font-black text-slate-900">{{ $boutique->articles->sum('stock') }}</p>
            </div>
            <div
                class="glass-light p-8 rounded-[2.5rem] border-white/60 shadow-lg shadow-slate-100/50 bg-gradient-to-br from-white to-slate-50">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Visites</p>
                <p class="text-3xl font-display font-black text-slate-900">--</p>
            </div>
        </div>

        <!-- Management Console -->
        <div class="glass rounded-[3rem] border-white/60 shadow-2xl shadow-slate-200/50 overflow-hidden" data-aos="fade-up"
            data-aos-delay="100">
            <!-- Tabs Nav -->
            <div class="flex border-b border-slate-100 bg-slate-50/50 backdrop-blur-md sticky top-0 z-10 px-6">
                <button @click="currentTab = 'overview'"
                    :class="currentTab === 'overview' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent'"
                    class="px-8 py-6 text-sm font-black uppercase tracking-widest border-b-2 transition-all">Overview</button>
                <button @click="currentTab = 'articles'"
                    :class="currentTab === 'articles' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent'"
                    class="px-8 py-6 text-sm font-black uppercase tracking-widest border-b-2 transition-all">Articles</button>
                <button @click="currentTab = 'categories'"
                    :class="currentTab === 'categories' ? 'text-primary-600 border-primary-600' : 'text-slate-400 border-transparent'"
                    class="px-8 py-6 text-sm font-black uppercase tracking-widest border-b-2 transition-all">Catégories</button>
            </div>

            <div class="p-10">
                <!-- Overview Tab -->
                <div x-show="currentTab === 'overview'" class="space-y-10 animate-fade-in">
                    <div class="grid md:grid-cols-2 gap-12">
                        <div class="space-y-6">
                            <h3 class="text-xl font-display font-black text-slate-900">Infos Commerciales</h3>
                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <span
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest">Téléphone</span>
                                    <span class="text-sm font-black text-slate-900">{{ $boutique->phone ?? 'NR' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Adresse</span>
                                    <span class="text-sm font-black text-slate-900">{{ $boutique->address ?? 'NR' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <h3 class="text-xl font-display font-black text-slate-900">Description</h3>
                            <p
                                class="text-sm text-slate-600 font-medium leading-relaxed bg-white p-6 rounded-[2rem] border border-slate-100 italic">
                                {{ $boutique->description ?? 'Aucune description fournie.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Articles Tab -->
                <div x-show="currentTab === 'articles'" class="animate-fade-in">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-display font-black text-slate-900">Catalogue Produits</h3>
                        <x-button href="{{ route('boutiques.articles.create', $boutique) }}" variant="primary" size="sm">+
                            Ajouter Article</x-button>
                    </div>

                    <div class="overflow-x-auto -mx-10">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Article
                                    </th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Catégorie</th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Prix
                                    </th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Stock
                                    </th>
                                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Status
                                    </th>
                                    <th
                                        class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($boutique->articles as $article)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="p-6">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shadow-sm">
                                                    @if($article->image)
                                                        <img src="{{ storage_url($article->image) }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-sm font-black text-slate-900 group-hover:text-primary-600 transition-colors">{{ $article->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-6"><span
                                                class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $article->category->name ?? '--' }}</span>
                                        </td>
                                        <td class="p-6"><span
                                                class="text-sm font-black text-slate-900">{{ number_format($article->price, 0, ',', ' ') }}
                                                FCFA</span></td>
                                        <td class="p-6">
                                            <div
                                                class="inline-flex items-center px-2 py-1 rounded-lg {{ $article->stock > 5 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} text-[10px] font-black uppercase tracking-widest">
                                                {{ $article->stock }} en stock
                                            </div>
                                        </td>
                                        <td class="p-6">
                                            <x-badge variant="{{ $article->status === 'active' ? 'emerald' : 'slate' }}"
                                                size="xs">{{ ucfirst($article->status) }}</x-badge>
                                        </td>
                                        <td class="p-6 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <x-button variant="ghost" size="xs"
                                                    class="hover:bg-white shadow-sm border border-slate-100">Modifier</x-button>
                                                <form action="#" method="POST"
                                                    onsubmit="return confirm('Supprimer cet article ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" variant="ghost" size="xs"
                                                        class="text-red-500 hover:bg-red-50 border border-transparent">×</x-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Categories Tab -->
                <div x-show="currentTab === 'categories'" class="animate-fade-in">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-display font-black text-slate-900">Catégories de Produits</h3>
                        <x-button href="{{ route('boutiques.categories.create', $boutique) }}" variant="primary" size="sm">+
                            Nouvelle Catégorie</x-button>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($boutique->categories as $category)
                            <div
                                class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm group hover:border-primary-200 transition-all">
                                <div class="flex items-start justify-between mb-4">
                                    <div
                                        class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-primary-50 group-hover:text-primary-500 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16"></path>
                                        </svg>
                                    </div>
                                    <span
                                        class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $category->articles_count }}
                                        articles</span>
                                </div>
                                <h4 class="text-lg font-display font-black text-slate-900 mb-2">{{ $category->name }}</h4>
                                <p class="text-xs text-slate-500 font-medium mb-6 line-clamp-2 leading-relaxed">
                                    {{ $category->description ?? 'Aucune description.' }}</p>
                                <div class="flex items-center space-x-2">
                                    <x-button variant="secondary" size="xs" class="flex-1">Modifier</x-button>
                                    <form action="#" method="POST" class="flex-1"> @csrf <x-button variant="ghost" size="xs"
                                            class="w-full text-red-500">Supprimer</x-button> </form>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full py-20 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                                <p class="text-slate-400 font-bold italic">Aucune catégorie créée.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection