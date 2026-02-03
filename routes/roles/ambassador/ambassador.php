<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmbassadorController;

Route::middleware(['auth', 'verified'])->prefix('ambassador')->name('ambassador.')->group(function () {
    Route::get('/dashboard', [AmbassadorController::class, 'index'])->name('dashboard');

    // Validation des boutiques
    Route::get('/boutiques', [AmbassadorController::class, 'pendingBoutiques'])->name('boutiques.pending');
    Route::post('/boutiques/{boutique}/approve', [AmbassadorController::class, 'approveBoutique'])->name('boutiques.approve');
    Route::post('/boutiques/{boutique}/reject', [AmbassadorController::class, 'rejectBoutique'])->name('boutiques.reject');

    // Validation des restaurants
    Route::get('/restaurants', [AmbassadorController::class, 'pendingRestaurants'])->name('restaurants.pending');
    Route::post('/restaurants/{restaurant}/approve', [AmbassadorController::class, 'approveRestaurant'])->name('restaurants.approve');
    Route::post('/restaurants/{restaurant}/reject', [AmbassadorController::class, 'rejectRestaurant'])->name('restaurants.reject');

    // Menus des restaurants universitaires
    Route::resource('campus-menus', \App\Http\Controllers\CampusRestaurantMenuController::class)->only(['index', 'store']);
});
