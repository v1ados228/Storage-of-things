<?php

namespace App\Http\Controllers;

use App\Events\PlaceCreated;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlaceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Place::class);

        $places = Cache::remember('places:list', 60, function () {
            return Place::latest()->get();
        });

        return view('places.index', compact('places'));
    }

    public function create()
    {
        $this->authorize('create', Place::class);

        return view('places.create');
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

        Cache::forget('places:list');
        event(new PlaceCreated($place));

        return redirect()->route('places.index');
    }

    public function edit(Place $place)
    {
        $this->authorize('update', $place);

        return view('places.edit', compact('place'));
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

        Cache::forget('places:list');

        return redirect()->route('places.index');
    }

    public function destroy(Place $place)
    {
        $this->authorize('delete', $place);

        $place->delete();
        Cache::forget('places:list');

        return redirect()->route('places.index');
    }
}
