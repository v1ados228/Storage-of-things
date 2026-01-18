<?php

namespace App\Http\Controllers\Api;

use App\Events\PlaceCreated;
use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceApiController extends Controller
{
    public function index()
    {
        return Place::latest()->get();
    }

    public function show(Place $place)
    {
        $this->authorize('view', $place);

        return $place;
    }

    public function store(Request $request)
    {
        $this->authorize('create', Place::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'repair' => ['nullable', 'boolean'],
            'work' => ['nullable', 'boolean'],
        ]);

        $place = Place::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'repair' => (bool) ($data['repair'] ?? false),
            'work' => (bool) ($data['work'] ?? false),
        ]);

        event(new PlaceCreated($place));

        return response()->json($place, 201);
    }

    public function update(Request $request, Place $place)
    {
        $this->authorize('update', $place);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'repair' => ['nullable', 'boolean'],
            'work' => ['nullable', 'boolean'],
        ]);

        $place->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'repair' => (bool) ($data['repair'] ?? false),
            'work' => (bool) ($data['work'] ?? false),
        ]);

        return response()->json($place);
    }

    public function destroy(Place $place)
    {
        $this->authorize('delete', $place);

        $place->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
