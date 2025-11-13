<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Route pour obtenir l'utilisateur actuel
Route::middleware('auth')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

// Routes d'authentification API
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/logout', [AuthController::class, 'apiLogout'])->middleware('auth');

// Routes des annonces (API)
Route::prefix('announcements')->group(function () {
    Route::get('/', [AnnouncementController::class, 'apiIndex']);
    Route::get('/{id}', [AnnouncementController::class, 'apiShow']);
    Route::post('/', [AnnouncementController::class, 'apiStore'])->middleware('auth');
    Route::put('/{id}', [AnnouncementController::class, 'apiUpdate'])->middleware('auth');
    Route::delete('/{id}', [AnnouncementController::class, 'apiDestroy'])->middleware('auth');
});

// Routes des catégories (API)
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'apiIndex']);
    Route::get('/{id}', [CategoryController::class, 'apiShow']);
});

// Routes des publicités (API)
Route::prefix('advertisements')->group(function () {
    Route::get('/active', [AdvertisementController::class, 'getActiveAdvertisements']);
});

