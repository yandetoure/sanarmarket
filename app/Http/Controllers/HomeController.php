<?php declare(strict_types=1); 

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\BoutiqueArticle;
use App\Models\RestaurantMenuItem;
use App\Models\CampusSpotlight;
use App\Models\CampusRestaurantMenu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with(['user', 'category', 'media'])->visible()->latest();

        // Filtrage par catégorie
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Recherche par titre ou description
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $announcements = $query->take(12)->get();
        $featuredAnnouncements = Announcement::where('featured', true)->visible()->with(['user', 'category', 'media'])->take(3)->get();
        $categories = \App\Models\Category::all();

        // Récupérer les articles de boutique actifs (uniquement des boutiques approuvées)
        $boutiqueArticles = BoutiqueArticle::with(['boutique.user', 'category'])
            ->where('status', 'active')
            ->whereHas('boutique', function($q) {
                $q->whereIn('status', ['active', 'draft'])
                  ->where('validation_status', 'approved'); // Uniquement les boutiques approuvées
            })
            ->latest()
            ->take(6)
            ->get();

        // Récupérer les menus de restaurant actifs (uniquement des restaurants approuvés)
        $restaurantMenuItems = RestaurantMenuItem::with(['restaurant.user'])
            ->where('is_available', true)
            ->whereHas('restaurant', function($q) {
                $q->whereIn('status', ['active', 'draft'])
                  ->where('validation_status', 'approved'); // Uniquement les restaurants approuvés
            })
            ->latest()
            ->take(6)
            ->get();

        // Récupérer les informations "à la une au campus"
        $campusSpotlights = CampusSpotlight::where('is_active', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Récupérer les menus du jour des restaurants du campus
        $today = now()->toDateString();
        $restau1Dejeuner = CampusRestaurantMenu::where('restaurant_name', CampusRestaurantMenu::RESTAURANT_1)
            ->where('meal_type', CampusRestaurantMenu::MEAL_DEJEUNER)
            ->where('menu_date', $today)
            ->latest()
            ->first();
        
        $restau1Diner = CampusRestaurantMenu::where('restaurant_name', CampusRestaurantMenu::RESTAURANT_1)
            ->where('meal_type', CampusRestaurantMenu::MEAL_DINER)
            ->where('menu_date', $today)
            ->latest()
            ->first();
        
        $restau2Dejeuner = CampusRestaurantMenu::where('restaurant_name', CampusRestaurantMenu::RESTAURANT_2)
            ->where('meal_type', CampusRestaurantMenu::MEAL_DEJEUNER)
            ->where('menu_date', $today)
            ->latest()
            ->first();
        
        $restau2Diner = CampusRestaurantMenu::where('restaurant_name', CampusRestaurantMenu::RESTAURANT_2)
            ->where('meal_type', CampusRestaurantMenu::MEAL_DINER)
            ->where('menu_date', $today)
            ->latest()
            ->first();

        // Récupérer les infos utiles pour l'accueil
        $prayerTimes = \App\Models\UsefulInfo::where('type', \App\Models\UsefulInfo::TYPE_PRAYER_TIMES)
            ->where('is_active', true)
            ->latest()
            ->first();
        
        $universityContacts = \App\Models\UsefulInfo::where('type', \App\Models\UsefulInfo::TYPE_UNIVERSITY_CONTACT)
            ->where('is_active', true)
            ->take(3)
            ->get();

        // Si c'est une requête AJAX, retourner JSON
        if ($request->ajax()) {
            return response()->json([
                'announcements' => $announcements->map(function ($announcement) {
                    return [
                        'title' => $announcement->title,
                        'description' => $announcement->description,
                        'price' => $announcement->price,
                        'location' => $announcement->location,
                        'image_url' => $announcement->image_url,
                        'featured' => $announcement->featured,
                        'formatted_date' => $announcement->formatted_date,
                        'category' => [
                            'name' => $announcement->category->name,
                        ],
                        'show_url' => route('announcements.show', $announcement),
                    ];
                }),
                'count' => $announcements->count(),
            ]);
        }

        return view('home', compact(
            'announcements',
            'featuredAnnouncements',
            'categories',
            'boutiqueArticles',
            'restaurantMenuItems',
            'campusSpotlights',
            'restau1Dejeuner',
            'restau1Diner',
            'restau2Dejeuner',
            'restau2Diner',
            'prayerTimes',
            'universityContacts'
        ));
    }
}
