<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ForumGroupController;
use App\Http\Controllers\ForumReplyController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ForumThreadController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CampusSpotlightController;
use App\Http\Controllers\CampusRestaurantMenuController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsefulInfoController;

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

// Routes publiques pour les boutiques
Route::get('/boutiques', [BoutiqueController::class, 'publicIndex'])->name('boutiques.index');
Route::get('/boutiques/{boutique:slug}', [BoutiqueController::class, 'publicShow'])->name('boutiques.public.show');

// Routes publiques pour les restaurants
Route::get('/restaurants', [RestaurantController::class, 'publicIndex'])->name('restaurants.index');
Route::get('/restaurants/{restaurant:slug}', [RestaurantController::class, 'publicShow'])->name('restaurants.public.show');

// Routes d'administration
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

Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Routes pour les annonces de l'utilisateur
Route::get('/dashboard/annonces', [UserDashboardController::class, 'myAnnouncements'])
    ->middleware('auth')
    ->name('dashboard.announcements');

// Routes pour les boutiques
Route::get('/dashboard/boutiques', [BoutiqueController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard.boutiques');
Route::get('/dashboard/boutiques/create', [BoutiqueController::class, 'create'])
    ->middleware('auth')
    ->name('boutiques.create');
Route::post('/dashboard/boutiques', [BoutiqueController::class, 'store'])
    ->middleware('auth')
    ->name('boutiques.store');

// Routes spécifiques pour les boutiques (doivent être avant la route générique {boutique})
Route::get('/dashboard/boutiques/{boutique}/manage', [BoutiqueController::class, 'manage'])
    ->middleware('auth')
    ->name('boutiques.manage');
Route::get('/dashboard/boutiques/{boutique}/edit', [BoutiqueController::class, 'edit'])
    ->middleware('auth')
    ->name('boutiques.edit');
Route::put('/dashboard/boutiques/{boutique}', [BoutiqueController::class, 'update'])
    ->middleware('auth')
    ->name('boutiques.update');

// Routes pour les catégories de boutique
Route::get('/dashboard/boutiques/{boutique}/categories/create', [BoutiqueController::class, 'createCategory'])
    ->middleware('auth')
    ->name('boutiques.categories.create');
Route::post('/dashboard/boutiques/{boutique}/categories', [BoutiqueController::class, 'storeCategory'])
    ->middleware('auth')
    ->name('boutiques.categories.store');

// Routes pour les articles de boutique
Route::get('/dashboard/boutiques/{boutique}/articles/create', [BoutiqueController::class, 'createArticle'])
    ->middleware('auth')
    ->name('boutiques.articles.create');
Route::post('/dashboard/boutiques/{boutique}/articles', [BoutiqueController::class, 'storeArticle'])
    ->middleware('auth')
    ->name('boutiques.articles.store');

// Route générique pour afficher une boutique (doit être en dernier)
Route::get('/dashboard/boutiques/{boutique}', [BoutiqueController::class, 'show'])
    ->middleware('auth')
    ->name('boutiques.show');

Route::get('/dashboard/restaurants', [RestaurantController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard.restaurants');
Route::get('/dashboard/restaurants/create', [RestaurantController::class, 'create'])
    ->middleware('auth')
    ->name('restaurants.create');
Route::post('/dashboard/restaurants', [RestaurantController::class, 'store'])
    ->middleware('auth')
    ->name('restaurants.store');

// Routes spécifiques pour les restaurants (doivent être avant la route générique {restaurant})
Route::get('/dashboard/restaurants/{restaurant}/manage', [RestaurantController::class, 'manage'])
    ->middleware('auth')
->name('restaurants.manage');
Route::get('/dashboard/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])
    ->middleware('auth')
    ->name('restaurants.edit');
Route::put('/dashboard/restaurants/{restaurant}', [RestaurantController::class, 'update'])
    ->middleware('auth')
    ->name('restaurants.update');

// Routes pour les plats du menu
Route::get('/dashboard/restaurants/{restaurant}/menu-items/create', [RestaurantController::class, 'createMenuItem'])
    ->middleware('auth')
->name('restaurants.menu-items.create');
Route::post('/dashboard/restaurants/{restaurant}/menu-items', [RestaurantController::class, 'storeMenuItem'])
    ->middleware('auth')
    ->name('restaurants.menu-items.store');

// Routes pour les horaires
Route::get('/dashboard/restaurants/{restaurant}/schedules/create', [RestaurantController::class, 'createSchedule'])
    ->middleware('auth')
    ->name('restaurants.schedules.create');
Route::post('/dashboard/restaurants/{restaurant}/schedules', [RestaurantController::class, 'storeSchedule'])
    ->middleware('auth')
    ->name('restaurants.schedules.store');

// Route générique pour afficher un restaurant (doit être en dernier)
Route::get('/dashboard/restaurants/{restaurant}', [RestaurantController::class, 'show'])
    ->middleware('auth')
    ->name('restaurants.show');

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

// Routes pour "à la une au campus"
Route::get('/campus-spotlight', [CampusSpotlightController::class, 'index'])->name('campus-spotlight.index');
Route::post('/campus-spotlight', [CampusSpotlightController::class, 'store'])->middleware('auth')->name('campus-spotlight.store');
Route::put('/campus-spotlight/{campusSpotlight}', [CampusSpotlightController::class, 'update'])->middleware('auth')->name('campus-spotlight.update');
Route::delete('/campus-spotlight/{campusSpotlight}', [CampusSpotlightController::class, 'destroy'])->middleware('auth')->name('campus-spotlight.destroy');

// Routes pour les menus du jour des restaurants du campus (Restau 1, Restau 2)
Route::get('/campus-restaurant-menu', [CampusRestaurantMenuController::class, 'index'])->name('campus-restaurant-menu.index');
Route::post('/campus-restaurant-menu', [CampusRestaurantMenuController::class, 'store'])->middleware('auth')->name('campus-restaurant-menu.store');

// Routes pour les événements
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth')->name('events.create');
Route::post('/events', [EventController::class, 'store'])->middleware('auth')->name('events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/approve', [EventController::class, 'approve'])->middleware('auth')->name('events.approve');
Route::post('/events/{event}/reject', [EventController::class, 'reject'])->middleware('auth')->name('events.reject');

// Routes pour les infos utiles
Route::get('/useful-info', [UsefulInfoController::class, 'index'])->name('useful-info.index');
Route::post('/useful-info/prayer-times', [UsefulInfoController::class, 'updatePrayerTimes'])->middleware('auth')->name('useful-info.prayer-times');
Route::post('/useful-info/university-contact', [UsefulInfoController::class, 'updateUniversityContact'])->middleware('auth')->name('useful-info.university-contact');
Route::post('/useful-info/pharmacy-on-duty', [UsefulInfoController::class, 'updatePharmacyOnDuty'])->middleware('auth')->name('useful-info.pharmacy-on-duty');
Route::post('/useful-info/campus-map', [UsefulInfoController::class, 'updateCampusMap'])->middleware('auth')->name('useful-info.campus-map');

Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumThreadController::class, 'index'])->name('index');
    Route::get('/create', [ForumThreadController::class, 'create'])->middleware('auth')->name('create');
    Route::post('/', [ForumThreadController::class, 'store'])->middleware('auth')->name('store');

    // Routes pour les groupes (doivent être avant /{thread} pour éviter les conflits)
    Route::get('/groups', [ForumGroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [ForumGroupController::class, 'create'])->middleware('auth')->name('groups.create');
    Route::post('/groups', [ForumGroupController::class, 'store'])->middleware('auth')->name('groups.store');
    Route::get('/groups/{group}/edit', [ForumGroupController::class, 'edit'])->middleware('auth')->name('groups.edit');
    Route::put('/groups/{group}', [ForumGroupController::class, 'update'])->middleware('auth')->name('groups.update');
    Route::get('/groups/{group}', [ForumGroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{group}/join', [ForumGroupController::class, 'join'])->middleware('auth')->name('groups.join');
    Route::post('/groups/{group}/members/{user}/ban', [ForumGroupController::class, 'banMember'])->middleware('auth')->name('groups.members.ban');
    Route::post('/groups/{group}/members/{user}/unban', [ForumGroupController::class, 'unbanMember'])->middleware('auth')->name('groups.members.unban');

    // Routes pour les threads (doivent être après /groups pour éviter les conflits)
    Route::get('/{thread}', [ForumThreadController::class, 'show'])->name('show');
    Route::get('/{thread}/replies', [ForumReplyController::class, 'index'])->name('replies.index');
    Route::post('/{thread}/reply', [ForumReplyController::class, 'store'])->middleware('auth')->name('reply.store');
});
