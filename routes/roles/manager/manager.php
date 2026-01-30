<?php

use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Routes pour les boutiques
    Route::get('/dashboard/boutiques', [BoutiqueController::class, 'index'])->name('dashboard.boutiques');
    Route::get('/dashboard/boutiques/create', [BoutiqueController::class, 'create'])->name('boutiques.create');
    Route::post('/dashboard/boutiques', [BoutiqueController::class, 'store'])->name('boutiques.store');

    Route::get('/dashboard/boutiques/{boutique}/manage', [BoutiqueController::class, 'manage'])->name('boutiques.manage');
    Route::get('/dashboard/boutiques/{boutique}/edit', [BoutiqueController::class, 'edit'])->name('boutiques.edit');
    Route::put('/dashboard/boutiques/{boutique}', [BoutiqueController::class, 'update'])->name('boutiques.update');

    // Routes pour les catégories de boutique
    Route::get('/dashboard/boutiques/{boutique}/categories/create', [BoutiqueController::class, 'createCategory'])->name('boutiques.categories.create');
    Route::post('/dashboard/boutiques/{boutique}/categories', [BoutiqueController::class, 'storeCategory'])->name('boutiques.categories.store');

    // Routes pour les articles de boutique
    Route::get('/dashboard/boutiques/{boutique}/articles/create', [BoutiqueController::class, 'createArticle'])->name('boutiques.articles.create');
    Route::post('/dashboard/boutiques/{boutique}/articles', [BoutiqueController::class, 'storeArticle'])->name('boutiques.articles.store');

    Route::get('/dashboard/boutiques/{boutique}', [BoutiqueController::class, 'show'])->name('boutiques.show');

    // Routes pour les restaurants
    Route::get('/dashboard/restaurants', [RestaurantController::class, 'index'])->name('dashboard.restaurants');
    Route::get('/dashboard/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/dashboard/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');

    Route::get('/dashboard/restaurants/{restaurant}/manage', [RestaurantController::class, 'manage'])->name('restaurants.manage');
    Route::get('/dashboard/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/dashboard/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');

    // Routes pour les plats du menu
    Route::get('/dashboard/restaurants/{restaurant}/menu-items/create', [RestaurantController::class, 'createMenuItem'])->name('restaurants.menu-items.create');
    Route::post('/dashboard/restaurants/{restaurant}/menu-items', [RestaurantController::class, 'storeMenuItem'])->name('restaurants.menu-items.store');

    // Routes pour les horaires
    Route::get('/dashboard/restaurants/{restaurant}/schedules/create', [RestaurantController::class, 'createSchedule'])->name('restaurants.schedules.create');
    Route::post('/dashboard/restaurants/{restaurant}/schedules', [RestaurantController::class, 'storeSchedule'])->name('restaurants.schedules.store');

    Route::get('/dashboard/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
});
