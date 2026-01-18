<?php

namespace App\Http\Controllers\Api;

use App\Events\ThingCreated;
use App\Http\Controllers\Controller;
use App\Models\Thing;
use App\Models\ThingDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThingApiController extends Controller
{
    public function index()
    {
        return Thing::with(['master', 'currentDescription', 'uses.place', 'uses.user', 'uses.unit'])->latest()->get();
    }

    public function show(Thing $thing)
    {
        $this->authorize('view', $thing);

        return $thing->load(['master', 'descriptions', 'currentDescription', 'uses.place', 'uses.user', 'uses.unit']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'wrnt' => ['nullable', 'date_format:Y-m-d'],
            'description' => ['required', 'string'],
            'total_amount' => ['required', 'integer', 'min:1'],
            'unit_id' => ['nullable', 'exists:units,id'],
        ]);

        $thing = DB::transaction(function () use ($data, $request) {
            $thing = Thing::create([
                'name' => $data['name'],
                'wrnt' => $data['wrnt'] ?? null,
                'master_id' => $request->user()->id,
                'total_amount' => $data['total_amount'],
                'unit_id' => $data['unit_id'] ?? null,
            ]);

            $description = ThingDescription::create([
                'thing_id' => $thing->id,
                'description' => $data['description'],
                'created_by' => $request->user()->id,
            ]);

            $thing->current_description_id = $description->id;
            $thing->save();

            return $thing;
        });

        event(new ThingCreated($thing));

        return response()->json($thing, 201);
    }

    public function update(Request $request, Thing $thing)
    {
        $this->authorize('update', $thing);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'wrnt' => ['nullable', 'date_format:Y-m-d'],
            'total_amount' => ['required', 'integer', 'min:1'],
            'unit_id' => ['nullable', 'exists:units,id'],
        ]);

        $thing->update($data);

        return response()->json($thing);
    }

    public function destroy(Thing $thing)
    {
        $this->authorize('delete', $thing);

        $thing->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
