@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-display font-black text-slate-900">Menus du Campus</h1>
                <p class="text-slate-500 mt-1">Gestion des menus pour Restau 1 et Restau 2</p>
            </div>

            <!-- Modal Trigger Button -->
            <button onclick="document.getElementById('addMenuModal').showModal()"
                class="px-5 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-lg shadow-primary-200 hover:bg-primary-700 transition-all flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter un menu
            </button>
        </div>

        <!-- Menus Grid -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Restaurant 1 -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-primary-200">
                        1
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Restaurant 1</h2>
                </div>

                <!-- Dejeuner -->
                <div class="glass p-6 rounded-3xl border border-white shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-700 flex items-center">
                            <div
                                class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            Déjeuner
                        </h3>
                        <span class="text-xs font-bold text-slate-400">11:30 - 15:00</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 min-h-[100px]">
                        @if($restau1Dejeuner)
                            <div class="prose prose-sm prose-slate max-w-none">
                                {!! nl2br(e($restau1Dejeuner->menu_content)) !!}
                            </div>
                            <div
                                class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400">
                                <span>Mis à jour {{ $restau1Dejeuner->created_at->diffForHumans() }}</span>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-primary-600">{{ $restau1Dejeuner->user->name ?? 'Admin' }}</span>
                                    <button onclick='editMenu(@json($restau1Dejeuner))' class="btn btn-xs btn-circle btn-ghost text-primary-600 hover:bg-primary-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-4 space-y-2">
                                <p class="text-slate-400 text-sm italic">Aucun menu défini</p>
                                <button onclick="openModal('Restau 1', 'dejeuner')" class="btn btn-xs btn-ghost text-primary-600">Ajouter</button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Diner -->
                <div class="glass p-6 rounded-3xl border border-white shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-700 flex items-center">
                            <div
                                class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>
                            </div>
                            Dîner
                        </h3>
                        <span class="text-xs font-bold text-slate-400">19:00 - 22:30</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 min-h-[100px]">
                        @if($restau1Diner)
                            <div class="prose prose-sm prose-slate max-w-none">
                                {!! nl2br(e($restau1Diner->menu_content)) !!}
                            </div>
                            <div
                                class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400">
                                <span>Mis à jour {{ $restau1Diner->created_at->diffForHumans() }}</span>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-primary-600">{{ $restau1Diner->user->name ?? 'Admin' }}</span>
                                    <button onclick='editMenu(@json($restau1Diner))' class="btn btn-xs btn-circle btn-ghost text-indigo-600 hover:bg-indigo-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-4 space-y-2">
                                <p class="text-slate-400 text-sm italic">Aucun menu défini</p>
                                <button onclick="openModal('Restau 1', 'diner')" class="btn btn-xs btn-ghost text-indigo-600">Ajouter</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Restaurant 2 -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-secondary-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-secondary-200">
                        2
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Restaurant 2</h2>
                </div>

                <!-- Dejeuner -->
                <div class="glass p-6 rounded-3xl border border-white shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-700 flex items-center">
                            <div
                                class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            Déjeuner
                        </h3>
                        <span class="text-xs font-bold text-slate-400">11:30 - 15:00</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 min-h-[100px]">
                        @if($restau2Dejeuner)
                            <div class="prose prose-sm prose-slate max-w-none">
                                {!! nl2br(e($restau2Dejeuner->menu_content)) !!}
                            </div>
                            <div
                                class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400">
                                <span>Mis à jour {{ $restau2Dejeuner->created_at->diffForHumans() }}</span>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-primary-600">{{ $restau2Dejeuner->user->name ?? 'Admin' }}</span>
                                    <button onclick='editMenu(@json($restau2Dejeuner))' class="btn btn-xs btn-circle btn-ghost text-orange-600 hover:bg-orange-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-4 space-y-2">
                                <p class="text-slate-400 text-sm italic">Aucun menu défini</p>
                                <button onclick="openModal('Restau 2', 'dejeuner')" class="btn btn-xs btn-ghost text-orange-600">Ajouter</button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Diner -->
                <div class="glass p-6 rounded-3xl border border-white shadow-xl">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-slate-700 flex items-center">
                            <div
                                class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 mr-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>
                            </div>
                            Dîner
                        </h3>
                        <span class="text-xs font-bold text-slate-400">19:00 - 22:30</span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 min-h-[100px]">
                        @if($restau2Diner)
                            <div class="prose prose-sm prose-slate max-w-none">
                                {!! nl2br(e($restau2Diner->menu_content)) !!}
                            </div>
                            <div
                                class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400">
                                <span>Mis à jour {{ $restau2Diner->created_at->diffForHumans() }}</span>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-primary-600">{{ $restau2Diner->user->name ?? 'Admin' }}</span>
                                    <button onclick='editMenu(@json($restau2Diner))' class="btn btn-xs btn-circle btn-ghost text-indigo-600 hover:bg-indigo-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-4 space-y-2">
                                <p class="text-slate-400 text-sm italic">Aucun menu défini</p>
                                <button onclick="openModal('Restau 2', 'diner')" class="btn btn-xs btn-ghost text-indigo-600">Ajouter</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Menu Modal -->
    <dialog id="addMenuModal" class="modal bg-black/20 backdrop-blur-sm">
        <div class="modal-box w-11/12 max-w-2xl bg-white rounded-3xl p-0 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-lg text-slate-900" id="modalTitle">Mettre à jour le menu</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-slate-500 hover:bg-slate-200">✕</button>
                </form>
            </div>

            <form id="menuForm"
                action="{{ auth()->user()->isAdmin() ? route('admin.campus-menus.store') : route('ambassador.campus-menus.store') }}"
                method="POST" class="p-6 space-y-6">
                @csrf

                <input type="hidden" name="menu_date" value="{{ now()->toDateString() }}">

                <div class="grid grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-500 uppercase">Restaurant</label>
                        <select name="restaurant_name" id="restaurant_name" class="select select-bordered w-full rounded-xl" required>
                            <option value="Restau 1">Restaurant 1</option>
                            <option value="Restau 2">Restaurant 2</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-500 uppercase">Repas</label>
                        <select name="meal_type" id="meal_type" class="select select-bordered w-full rounded-xl" required>
                            <option value="dejeuner">Déjeuner</option>
                            <option value="diner">Dîner</option>
                        </select>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-500 uppercase">Contenu du menu</label>
                    <textarea name="menu_content" id="menu_content" class="textarea textarea-bordered h-32 rounded-xl text-base"
                        placeholder="Entrez le menu du jour..." required></textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-500 uppercase">Heure d'ouverture</label>
                        <input type="time" name="opening_time" id="opening_time" class="input input-bordered rounded-xl">
                    </div>

                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-500 uppercase">Heure de fermeture</label>
                        <input type="time" name="closing_time" id="closing_time" class="input input-bordered rounded-xl">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn btn-primary w-full rounded-xl normal-case text-lg font-bold">
                        Enregistrer le menu
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        function openModal(restaurant = 'Restau 1', meal = 'dejeuner') {
            document.getElementById('restaurant_name').value = restaurant;
            document.getElementById('meal_type').value = meal;
            document.getElementById('menu_content').value = '';
            document.getElementById('opening_time').value = '';
            document.getElementById('closing_time').value = '';
            document.getElementById('addMenuModal').showModal();
        }

        function editMenu(menu) {
            document.getElementById('restaurant_name').value = menu.restaurant_name;
            document.getElementById('meal_type').value = menu.meal_type;
            document.getElementById('menu_content').value = menu.menu_content;
            document.getElementById('opening_time').value = menu.opening_time ? menu.opening_time.substring(0, 5) : '';
            document.getElementById('closing_time').value = menu.closing_time ? menu.closing_time.substring(0, 5) : '';
            document.getElementById('addMenuModal').showModal();
        }
    </script>
@endsection