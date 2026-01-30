<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CampusSpotlightController;
use App\Http\Controllers\CampusRestaurantMenuController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UsefulInfoController;
use App\Http\Controllers\ForumGroupController;
use App\Http\Controllers\ForumReplyController;
use App\Http\Controllers\ForumThreadController;
use App\Http\Controllers\AdvertisementController;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes publiques pour les boutiques
Route::get('/boutiques', [BoutiqueController::class, 'publicIndex'])->name('boutiques.index');
Route::get('/boutiques/{boutique:slug}', [BoutiqueController::class, 'publicShow'])->name('boutiques.public.show');

// Routes publiques pour les restaurants
Route::get('/restaurants', [RestaurantController::class, 'publicIndex'])->name('restaurants.index');
Route::get('/restaurants/{restaurant:slug}', [RestaurantController::class, 'publicShow'])->name('restaurants.public.show');

// Inclusion des routes par rôles
require __DIR__ . '/roles/admin/admin.php';
require __DIR__ . '/roles/user/user.php';
require __DIR__ . '/roles/manager/manager.php';
require __DIR__ . '/roles/designer/designer.php';
require __DIR__ . '/roles/marketing/marketing.php';

// Routes des annonces (Héritées de sanarmarket mais gardées ici car semi-publiques)
Route::resource('announcements', AnnouncementController::class);
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

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

// Forum
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumThreadController::class, 'index'])->name('index');
    Route::get('/create', [ForumThreadController::class, 'create'])->middleware('auth')->name('create');
    Route::post('/', [ForumThreadController::class, 'store'])->middleware('auth')->name('store');

    Route::get('/groups', [ForumGroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [ForumGroupController::class, 'create'])->middleware('auth')->name('groups.create');
    Route::post('/groups', [ForumGroupController::class, 'store'])->middleware('auth')->name('groups.store');
    Route::get('/groups/{group}/edit', [ForumGroupController::class, 'edit'])->middleware('auth')->name('groups.edit');
    Route::put('/groups/{group}', [ForumGroupController::class, 'update'])->middleware('auth')->name('groups.update');
    Route::get('/groups/{group}', [ForumGroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{group}/join', [ForumGroupController::class, 'join'])->middleware('auth')->name('groups.join');
    Route::post('/groups/{group}/members/{user}/ban', [ForumGroupController::class, 'banMember'])->middleware('auth')->name('groups.members.ban');
    Route::post('/groups/{group}/members/{user}/unban', [ForumGroupController::class, 'unbanMember'])->middleware('auth')->name('groups.members.unban');

    Route::get('/{thread}', [ForumThreadController::class, 'show'])->name('show');
    Route::get('/{thread}/replies', [ForumReplyController::class, 'index'])->name('replies.index');
    Route::post('/{thread}/reply', [ForumReplyController::class, 'store'])->middleware('auth')->name('reply.store');
});
