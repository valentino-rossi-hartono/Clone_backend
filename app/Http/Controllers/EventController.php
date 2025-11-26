<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $userId = Auth::id();
        $userEvents = Event::where('user_id', $userId)->get();
        return response()->json($userEvents);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required',
            'location' => 'required',
            'quota' => 'required',
        ]);

        $userId = Auth::id();
        $event = Event::create([
            'user_id' => $userId,
            'event_name' => $validatedData['event_name'],
            'location' => $validatedData['location'],
            'quota' => $validatedData['quota'],
        ]);

        return response()->json([
            'message' => 'Post created successfully.',
            'post' => $event,
        ], 201);
    }

    // Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'event_name' => 'required',
            'location' => 'required',
            'quota' => 'required',
        ]);

        $userId = Auth::id();
        $event = Event::find($id);

        if (!$event || $event->user_id != $userId) {
            return response()->json(['message' => 'Event tidak ditemukan'], 403);
        }

        $event->update($validatedData);
        return response()->json($event);
    }

    // Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $userId = Auth::id();
        $event = Event::find($id);

        if (!$event || $event->user_id != $userId) {
            return response()->json(['message' => 'Event tidak ditemukan atau anda tidak login'], 403);
        }

        $event->delete();
        return response()->json(['message' => 'Event berhasil di hapus.']);
    }

    public function show(string $id)
{
    $userId = Auth::id();
    $event = Event::where('id', $id)->where('user_id', $userId)->first();

    if (!$event) {
        return response()->json(['message' => 'Event tidak ditemukan atau bukan milik Anda.'], 404);
    }
    
    return response()->json($event);
}
}