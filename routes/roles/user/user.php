<?php

use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Routes pour les annonces de l'utilisateur
    Route::get('/dashboard/annonces', [UserDashboardController::class, 'myAnnouncements'])->name('dashboard.announcements');
});
