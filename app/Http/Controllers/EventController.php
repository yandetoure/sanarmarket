<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['user', 'approver']);

        // Filtrage par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', Event::STATUS_APPROVED);
        }

        // Filtrage par date (événements à venir)
        if ($request->has('upcoming') && $request->upcoming) {
            $query->where('start_date', '>=', now());
        }

        $events = $query->latest('start_date')->paginate(12);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        if (!Auth::user()->isAmbassador() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('events.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAmbassador() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $isAdmin = Auth::user()->isAdmin();
        
        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'image' => $request->hasFile('image') ? $request->file('image')->store('events', 'public') : null,
            'status' => $isAdmin ? Event::STATUS_APPROVED : Event::STATUS_PENDING,
            'approved_by' => $isAdmin ? Auth::id() : null,
            'approved_at' => $isAdmin ? now() : null,
        ]);

        $message = $isAdmin 
            ? 'Événement créé et approuvé avec succès' 
            : 'Événement créé et en attente de validation';
            
        return redirect()->route('events.index')->with('success', $message);
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function approve(Event $event)
    {
        if (!Auth::user()->isModerator()) {
            abort(403);
        }

        $event->update([
            'status' => Event::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('events.index')->with('success', 'Événement approuvé');
    }

    public function reject(Event $event)
    {
        if (!Auth::user()->isModerator()) {
            abort(403);
        }

        $event->update([
            'status' => Event::STATUS_REJECTED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('events.index')->with('success', 'Événement rejeté');
    }
}
