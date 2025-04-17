<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function showList()
    {
        $data = Event::paginate(15);
        $title = "Wydarzenia";
        $type = "event";

        return view('list', ['data' => $data, 'title' => $title, 'type' => $type]);
    }

    public function showCreateOrUpdateForm($id = null)
    {
        $event = null;
        $title = "Dane Wydarzenia";

        if ($id) {
            $event = Event::findOrFail($id);        
        }
        
        return view('events.createOrUpdate', ['event' => $event, 'title' => $title]);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'color' => 'required|string|max:7'
        ]);

        if ($request->id) {
            $event = Event::findOrFail($request->id);
            $event->update($validatedData);
        } else {
            $event = Event::create($validatedData);
        }

        if ($request->action === 'save_and_close') {
            return redirect()->route('events.list')->with('success', 'Wydarzenie zostało zapisane.');
        }

        return redirect()->route('events.edit', [ 'id' => $event->id])
            ->with('success', 'Wydarzenie zostało zapisane.');
        
    }
}