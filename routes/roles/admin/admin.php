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
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');

    Route::get('/announcements', [AdminController::class, 'announcements'])->name('announcements');
    Route::get('/announcements/create', [AdminController::class, 'createAnnouncement'])->name('announcements.create');
    Route::post('/announcements', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::get('/announcements/{announcement}', [AdminController::class, 'showAnnouncement'])->name('announcements.show');
    Route::get('/announcements/{announcement}/edit', [AdminController::class, 'editAnnouncement'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AdminController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::post('/announcements/{announcement}/hide', [AdminController::class, 'hideAnnouncement'])->name('announcements.hide');
    Route::post('/announcements/{announcement}/activate', [AdminController::class, 'activateAnnouncement'])->name('announcements.activate');
    Route::post('/announcements/{announcement}/pending', [AdminController::class, 'pendingAnnouncement'])->name('announcements.pending');
    Route::post('/announcements/{announcement}/approve', [AdminController::class, 'approveAnnouncement'])->name('announcements.approve');
    Route::post('/announcements/{announcement}/reject', [AdminController::class, 'rejectAnnouncement'])->name('announcements.reject');

    // Routes pour les boutiques
    Route::get('/boutiques', [AdminController::class, 'boutiques'])->name('boutiques');
    Route::get('/boutiques/create', [AdminController::class, 'createBoutique'])->name('boutiques.create'); // Add this BEFORE {boutique}
    Route::post('/boutiques', [AdminController::class, 'storeBoutique'])->name('boutiques.store');
    Route::get('/boutiques/{boutique}', [AdminController::class, 'showBoutique'])->name('boutiques.show');
    Route::get('/boutiques/{boutique}/edit', [AdminController::class, 'editBoutique'])->name('boutiques.edit');
    Route::put('/boutiques/{boutique}', [AdminController::class, 'updateBoutique'])->name('boutiques.update');
    Route::delete('/boutiques/{boutique}', [AdminController::class, 'destroyBoutique'])->name('boutiques.destroy');
    Route::post('/boutiques/{boutique}/approve', [AdminController::class, 'approveBoutique'])->name('boutiques.approve');
    Route::post('/boutiques/{boutique}/reject', [AdminController::class, 'rejectBoutique'])->name('boutiques.reject');
    Route::post('/boutiques/{boutique}/toggle-subscription', [AdminController::class, 'toggleBoutiqueSubscription'])->name('boutiques.toggle-subscription');

    // Routes pour les restaurants
    Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('restaurants');
    Route::get('/restaurants/create', [AdminController::class, 'createRestaurant'])->name('restaurants.create');
    Route::post('/restaurants', [AdminController::class, 'storeRestaurant'])->name('restaurants.store');
    Route::get('/restaurants/{restaurant}', [AdminController::class, 'showRestaurant'])->name('restaurants.show');
    Route::get('/restaurants/{restaurant}/edit', [AdminController::class, 'editRestaurant'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [AdminController::class, 'updateRestaurant'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [AdminController::class, 'destroyRestaurant'])->name('restaurants.destroy');
    Route::post('/restaurants/{restaurant}/approve', [AdminController::class, 'approveRestaurant'])->name('restaurants.approve');
    Route::post('/restaurants/{restaurant}/reject', [AdminController::class, 'rejectRestaurant'])->name('restaurants.reject');
    Route::post('/restaurants/{restaurant}/toggle-subscription', [AdminController::class, 'toggleRestaurantSubscription'])->name('restaurants.toggle-subscription');

    // Routes pour les événements
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::get('/events/create', [AdminController::class, 'createEvent'])->name('events.create');
    Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{event}/edit', [AdminController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{event}', [AdminController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{event}', [AdminController::class, 'destroyEvent'])->name('events.destroy');
    Route::post('/events/{event}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
    Route::post('/events/{event}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');

    // Routes pour "à la une au campus"
    Route::get('/campus-spotlight', [AdminController::class, 'campusSpotlight'])->name('campus-spotlight');
    Route::get('/campus-spotlight/create', [AdminController::class, 'createCampusSpotlight'])->name('campus-spotlight.create');
    Route::post('/campus-spotlight', [AdminController::class, 'storeCampusSpotlight'])->name('campus-spotlight.store');
    Route::get('/campus-spotlight/{campusSpotlight}/edit', [AdminController::class, 'editCampusSpotlight'])->name('campus-spotlight.edit');
    Route::put('/campus-spotlight/{campusSpotlight}', [AdminController::class, 'updateCampusSpotlight'])->name('campus-spotlight.update');
    Route::delete('/campus-spotlight/{campusSpotlight}', [AdminController::class, 'destroyCampusSpotlight'])->name('campus-spotlight.destroy');
    Route::post('/campus-spotlight/{campusSpotlight}/toggle', [AdminController::class, 'toggleCampusSpotlight'])->name('campus-spotlight.toggle');
    Route::post('/campus-spotlight/{campusSpotlight}/publish', [AdminController::class, 'publishCampusSpotlight'])->name('campus-spotlight.publish');

    // Routes pour les menus du campus
    Route::get('/campus-restaurant-menus', [AdminController::class, 'campusRestaurantMenus'])->name('campus-restaurant-menus');
    Route::resource('campus-menus', \App\Http\Controllers\CampusRestaurantMenuController::class)->only(['index', 'store']);

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
