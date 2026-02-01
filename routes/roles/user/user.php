<?php

use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Routes pour les annonces de l'utilisateur
    Route::get('/dashboard/annonces', [UserDashboardController::class, 'myAnnouncements'])->name('dashboard.announcements');

    // Routes pour les boutiques de l'utilisateur
    Route::get('/dashboard/boutiques', [BoutiqueController::class, 'index'])->name('dashboard.boutiques');
    Route::get('/boutiques/create', [BoutiqueController::class, 'create'])->name('boutiques.create');
    Route::post('/boutiques', [BoutiqueController::class, 'store'])->name('boutiques.store');
    Route::get('/boutiques/{boutique}/edit', [BoutiqueController::class, 'edit'])->name('boutiques.edit');
    Route::put('/boutiques/{boutique}', [BoutiqueController::class, 'update'])->name('boutiques.update');
    Route::delete('/boutiques/{boutique}', [BoutiqueController::class, 'destroy'])->name('boutiques.destroy');
    Route::get('/boutiques/{boutique}/manage', [BoutiqueController::class, 'manage'])->name('boutiques.manage');

    // Routes pour les restaurants de l'utilisateur
    Route::get('/dashboard/restaurants', [RestaurantController::class, 'index'])->name('dashboard.restaurants');
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
    Route::get('/restaurants/{restaurant}/manage', [RestaurantController::class, 'manage'])->name('restaurants.manage');
});
