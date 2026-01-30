<?php

use App\Http\Controllers\MarketingController;
use Illuminate\Support\Facades\Route;

Route::prefix('marketing')->name('marketing.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [MarketingController::class, 'dashboard'])->name('dashboard');
    Route::get('/advertisements', [MarketingController::class, 'advertisements'])->name('advertisements');
    Route::post('/advertisements/{advertisement}/toggle', [MarketingController::class, 'toggleAdvertisement'])->name('advertisements.toggle');
    Route::get('/statistics', [MarketingController::class, 'statistics'])->name('statistics');
    Route::post('/announcements/{announcement}/promote', [MarketingController::class, 'promoteAnnouncement'])->name('announcements.promote');
    Route::get('/profile/edit', [MarketingController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [MarketingController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/password', [MarketingController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [MarketingController::class, 'updatePassword'])->name('profile.password.update');
});
