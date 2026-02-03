<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();
        return view('admin.subscription-plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_announcements' => 'required|integer|min:1',
            'max_photos_per_announcement' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        SubscriptionPlan::create($validated);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement créé avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        // Parameter binding expects 'subscription_plan' in route, but resource usually passes 'subscription_plan'
        // If route is resource('subscription-plans'), parameter is subscription_plan
        return view('admin.subscription-plans.edit', ['plan' => $subscriptionPlan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_announcements' => 'required|integer|min:1',
            'max_photos_per_announcement' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $subscriptionPlan->update($validated);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement supprimé');
    }
}
