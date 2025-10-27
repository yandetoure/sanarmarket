<?php declare(strict_types=1); 

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes des annonces
Route::resource('announcements', AnnouncementController::class);
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create')->middleware('auth');
Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store')->middleware('auth');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit')->middleware('auth');
Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update')->middleware('auth');
Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy')->middleware('auth');

// Routes d'administration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/change-role', [AdminController::class, 'changeUserRole'])->name('users.change-role');
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::post('/announcements/{announcement}/hide', [AdminController::class, 'hideAnnouncement'])->name('announcements.hide');
    Route::post('/announcements/{announcement}/activate', [AdminController::class, 'activateAnnouncement'])->name('announcements.activate');
    Route::post('/announcements/{announcement}/pending', [AdminController::class, 'pendingAnnouncement'])->name('announcements.pending');
    
    // Routes des publicités
    Route::resource('advertisements', AdvertisementController::class);
    Route::post('/advertisements/{advertisement}/toggle', [AdvertisementController::class, 'toggle'])->name('advertisements.toggle');
    
    // Routes des catégories
    Route::resource('categories', CategoryController::class);
});

// API pour récupérer les publicités actives (accessible sans authentification)
Route::get('/api/advertisements/active', [AdvertisementController::class, 'getActiveAdvertisements'])->name('api.advertisements.active');
