<?php

use App\Http\Controllers\DesignerController;
use Illuminate\Support\Facades\Route;

Route::prefix('designer')->name('designer.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DesignerController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-designs', [DesignerController::class, 'myDesigns'])->name('my-designs');
    Route::get('/create', [DesignerController::class, 'create'])->name('create');
    Route::post('/store', [DesignerController::class, 'store'])->name('store');
    Route::get('/edit/{advertisement}', [DesignerController::class, 'edit'])->name('edit');
    Route::put('/update/{advertisement}', [DesignerController::class, 'update'])->name('update');
    Route::get('/customize', [DesignerController::class, 'customize'])->name('customize');
    Route::post('/customize', [DesignerController::class, 'saveCustomization'])->name('save-customization');
    Route::get('/profile/edit', [DesignerController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [DesignerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/password', [DesignerController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [DesignerController::class, 'updatePassword'])->name('profile.password.update');
});
