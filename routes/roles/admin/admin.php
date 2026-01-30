<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::post('/users/{user}/change-role', [AdminController::class, 'changeUserRole'])->name('users.change-role');
    Route::post('/users/{user}/toggle-premium', [AdminController::class, 'toggleUserPremium'])->name('users.toggle-premium');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');

    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::post('/announcements/{announcement}/hide', [AdminController::class, 'hideAnnouncement'])->name('announcements.hide');
    Route::post('/announcements/{announcement}/activate', [AdminController::class, 'activateAnnouncement'])->name('announcements.activate');
    Route::post('/announcements/{announcement}/pending', [AdminController::class, 'pendingAnnouncement'])->name('announcements.pending');
    Route::post('/announcements/{announcement}/approve', [AdminController::class, 'approveAnnouncement'])->name('announcements.approve');
    Route::post('/announcements/{announcement}/reject', [AdminController::class, 'rejectAnnouncement'])->name('announcements.reject');

    // Routes pour les boutiques
    Route::get('/boutiques', [AdminController::class, 'boutiques'])->name('boutiques');
    Route::post('/boutiques/{boutique}/approve', [AdminController::class, 'approveBoutique'])->name('boutiques.approve');
    Route::post('/boutiques/{boutique}/reject', [AdminController::class, 'rejectBoutique'])->name('boutiques.reject');
    Route::post('/boutiques/{boutique}/toggle-subscription', [AdminController::class, 'toggleBoutiqueSubscription'])->name('boutiques.toggle-subscription');

    // Routes pour les restaurants
    Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('restaurants');
    Route::post('/restaurants/{restaurant}/approve', [AdminController::class, 'approveRestaurant'])->name('restaurants.approve');
    Route::post('/restaurants/{restaurant}/reject', [AdminController::class, 'rejectRestaurant'])->name('restaurants.reject');
    Route::post('/restaurants/{restaurant}/toggle-subscription', [AdminController::class, 'toggleRestaurantSubscription'])->name('restaurants.toggle-subscription');

    // Routes pour les événements
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::post('/events/{event}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
    Route::post('/events/{event}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');

    // Routes pour "à la une au campus"
    Route::get('/campus-spotlight', [AdminController::class, 'campusSpotlight'])->name('campus-spotlight');
    Route::post('/campus-spotlight/{campusSpotlight}/toggle', [AdminController::class, 'toggleCampusSpotlight'])->name('campus-spotlight.toggle');
    Route::post('/campus-spotlight/{campusSpotlight}/publish', [AdminController::class, 'publishCampusSpotlight'])->name('campus-spotlight.publish');

    // Routes pour les menus du campus
    Route::get('/campus-restaurant-menus', [AdminController::class, 'campusRestaurantMenus'])->name('campus-restaurant-menus');

    // Routes pour les infos utiles (admin uniquement)
    Route::get('/useful-info', [AdminController::class, 'usefulInfo'])->name('useful-info');
    Route::post('/useful-info/prayer-times', [AdminController::class, 'updatePrayerTimes'])->name('useful-info.prayer-times');
    Route::post('/useful-info/university-contact', [AdminController::class, 'storeUniversityContact'])->name('useful-info.university-contact');
    Route::delete('/useful-info/university-contact/{usefulInfo}', [AdminController::class, 'deleteUniversityContact'])->name('useful-info.university-contact.delete');
    Route::post('/useful-info/pharmacy-on-duty', [AdminController::class, 'updatePharmacyOnDuty'])->name('useful-info.pharmacy-on-duty');
    Route::post('/useful-info/campus-map', [AdminController::class, 'updateCampusMap'])->name('useful-info.campus-map');

    // Routes pour les sous-catégories
    Route::get('/subcategories', [AdminController::class, 'subcategories'])->name('subcategories');
    Route::get('/subcategories/create', [AdminController::class, 'createSubcategory'])->name('subcategories.create');
    Route::post('/subcategories', [AdminController::class, 'storeSubcategory'])->name('subcategories.store');
    Route::get('/subcategories/{subcategory}/edit', [AdminController::class, 'editSubcategory'])->name('subcategories.edit');
    Route::put('/subcategories/{subcategory}', [AdminController::class, 'updateSubcategory'])->name('subcategories.update');
    Route::delete('/subcategories/{subcategory}', [AdminController::class, 'destroySubcategory'])->name('subcategories.destroy');

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

    // Route personnalisation admin
    Route::get('/customize', [AdminController::class, 'customize'])->name('customize');
    Route::post('/customize', [AdminController::class, 'saveCustomization'])->name('save-customization');
});
