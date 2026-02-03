<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CampusRestaurantMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Contrôleur pour les menus des restaurants du campus (Restau 1, Restau 2)
 * Ces restaurants sont différents des restaurants commerciaux
 */
class CampusRestaurantMenuController extends Controller
{
    public function index()
    {
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

        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isAmbassador())) {
            return view('admin.campus-restaurant-menus', compact(
                'restau1Dejeuner',
                'restau1Diner',
                'restau2Dejeuner',
                'restau2Diner'
            ));
        }

        return view('campus-restaurant-menu.index', compact(
            'restau1Dejeuner',
            'restau1Diner',
            'restau2Dejeuner',
            'restau2Diner'
        ));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAmbassador() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'restaurant_name' => 'required|string|in:Restau 1,Restau 2',
            'meal_type' => 'required|string|in:dejeuner,diner',
            'menu_content' => 'required|string',
            'menu_date' => 'required|date',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
        ]);

        CampusRestaurantMenu::updateOrCreate(
            [
                'restaurant_name' => $request->restaurant_name,
                'meal_type' => $request->meal_type,
                'menu_date' => $request->menu_date,
            ],
            [
                'menu_content' => $request->menu_content,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'user_id' => Auth::id(),
            ]
        );

        return redirect()->route('campus-restaurant-menu.index')->with('success', 'Menu du jour mis à jour');
    }
}
