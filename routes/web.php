<?php declare(strict_types=1); 

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\MarketingController;
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
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::post('/announcements/{announcement}/hide', [AdminController::class, 'hideAnnouncement'])->name('announcements.hide');
    Route::post('/announcements/{announcement}/activate', [AdminController::class, 'activateAnnouncement'])->name('announcements.activate');
    Route::post('/announcements/{announcement}/pending', [AdminController::class, 'pendingAnnouncement'])->name('announcements.pending');
    
    // Routes des publicités
    Route::resource('advertisements', AdvertisementController::class);
    Route::post('/advertisements/{advertisement}/toggle', [AdvertisementController::class, 'toggle'])->name('advertisements.toggle');
    
    // Routes des catégories
    Route::resource('categories', CategoryController::class);
    
    // Route profil admin
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/password', [AdminController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password.update');
});

// Routes pour Designer
Route::prefix('designer')->name('designer.')->group(function () {
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

// Routes pour Marketing
Route::prefix('marketing')->name('marketing.')->group(function () {
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

// API pour récupérer les publicités actives (accessible sans authentification)
Route::get('/api/advertisements/active', [AdvertisementController::class, 'getActiveAdvertisements'])->name('api.advertisements.active');
