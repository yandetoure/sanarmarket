<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class AmbassadorController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_boutiques' => Boutique::where('validation_status', 'pending')->count(),
            'pending_restaurants' => Restaurant::where('validation_status', 'pending')->count(),
            'approved_boutiques' => Boutique::where('validation_status', 'approved')->count(),
            'approved_restaurants' => Restaurant::where('validation_status', 'approved')->count(),
        ];

        $recent_boutiques = Boutique::with('user')->latest()->take(5)->get();
        $recent_restaurants = Restaurant::with('user')->latest()->take(5)->get();

        return view('ambassador.dashboard', compact('stats', 'recent_boutiques', 'recent_restaurants'));
    }

    public function pendingBoutiques()
    {
        $boutiques = Boutique::with('user')->where('validation_status', 'pending')->latest()->paginate(10);
        return view('ambassador.boutiques.pending', compact('boutiques'));
    }

    public function approveBoutique(Boutique $boutique)
    {
        $boutique->update([
            'validation_status' => 'approved',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'status' => 'active'
        ]);

        return back()->with('success', 'Boutique approuvée avec succès.');
    }

    public function rejectBoutique(Boutique $boutique, Request $request)
    {
        $boutique->update([
            'validation_status' => 'rejected',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'status' => 'inactive'
        ]);

        return back()->with('error', 'Boutique rejetée.');
    }

    public function pendingRestaurants()
    {
        $restaurants = Restaurant::with('user')->where('validation_status', 'pending')->latest()->paginate(10);
        return view('ambassador.restaurants.pending', compact('restaurants'));
    }

    public function approveRestaurant(Restaurant $restaurant)
    {
        $restaurant->update([
            'validation_status' => 'approved',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'status' => 'active'
        ]);

        return back()->with('success', 'Restaurant approuvé avec succès.');
    }

    public function rejectRestaurant(Restaurant $restaurant, Request $request)
    {
        $restaurant->update([
            'validation_status' => 'rejected',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'status' => 'inactive'
        ]);

        return back()->with('error', 'Restaurant rejeté.');
    }
}
