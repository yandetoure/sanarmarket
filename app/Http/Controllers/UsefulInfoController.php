<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UsefulInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsefulInfoController extends Controller
{
    public function index()
    {
        $prayerTimes = UsefulInfo::where('type', UsefulInfo::TYPE_PRAYER_TIMES)
            ->where('is_active', true)
            ->latest()
            ->first();
        
        $universityContacts = UsefulInfo::where('type', UsefulInfo::TYPE_UNIVERSITY_CONTACT)
            ->where('is_active', true)
            ->get();
        
        $pharmacyOnDuty = UsefulInfo::where('type', UsefulInfo::TYPE_PHARMACY_ON_DUTY)
            ->where('is_active', true)
            ->latest()
            ->first();
        
        $campusMap = UsefulInfo::where('type', UsefulInfo::TYPE_CAMPUS_MAP)
            ->where('is_active', true)
            ->latest()
            ->first();

        return view('useful-info.index', compact('prayerTimes', 'universityContacts', 'pharmacyOnDuty', 'campusMap'));
    }

    public function updatePrayerTimes(Request $request)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $request->validate([
            'data' => 'required|array',
        ]);

        UsefulInfo::updateOrCreate(
            ['type' => UsefulInfo::TYPE_PRAYER_TIMES],
            [
                'title' => 'Heures de prière',
                'data' => $request->data,
                'user_id' => Auth::id(),
                'is_active' => true,
            ]
        );

        return redirect()->route('useful-info.index')->with('success', 'Heures de prière mises à jour');
    }

    public function updateUniversityContact(Request $request)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        UsefulInfo::create([
            'type' => UsefulInfo::TYPE_UNIVERSITY_CONTACT,
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('useful-info.index')->with('success', 'Contact ajouté');
    }

    public function updatePharmacyOnDuty(Request $request)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('useful-info', 'public');

        UsefulInfo::updateOrCreate(
            ['type' => UsefulInfo::TYPE_PHARMACY_ON_DUTY],
            [
                'title' => 'Pharmacie de garde',
                'image' => $imagePath,
                'user_id' => Auth::id(),
                'is_active' => true,
            ]
        );

        return redirect()->route('useful-info.index')->with('success', 'Affiche de pharmacie de garde mise à jour');
    }

    public function updateCampusMap(Request $request)
    {
        if (!Auth::user()->isAmbassador()) {
            abort(403);
        }

        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $imagePath = $request->file('image')->store('useful-info', 'public');

        UsefulInfo::updateOrCreate(
            ['type' => UsefulInfo::TYPE_CAMPUS_MAP],
            [
                'title' => 'Plan du campus',
                'image' => $imagePath,
                'user_id' => Auth::id(),
                'is_active' => true,
            ]
        );

        return redirect()->route('useful-info.index')->with('success', 'Plan du campus mis à jour');
    }
}

