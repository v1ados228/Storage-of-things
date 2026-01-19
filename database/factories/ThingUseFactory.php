<?php

namespace App\Http\Controllers;

use App\Events\ThingCreated;
use App\Models\ArchivedThing;
use App\Models\Thing;
use App\Models\ThingDescription;
use App\Models\ThingUse;
use App\Notifications\ThingCreatedNotification;
use App\Notifications\ThingDescriptionChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ThingController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');
        $userId = $request->user()->id;
        $cacheKey = "things:list:{$tab}:{$userId}";

        $things = Cache::remember($cacheKey, 60, function () use ($tab, $userId) {
            $query = Thing::with([
                'master',
                'currentDescription',
                'uses.place',
                'uses.unit',
                'uses.user',
            ]);

            if ($tab === 'my') {
                $query->where('master_id', $userId);
            } elseif ($tab === 'assigned') {
                $query->whereHas('uses', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            } elseif ($tab === 'repair') {
                $query->whereHas('uses.place', function ($q) {
                    $q->where('repair', true);
                });
            } elseif ($tab === 'work') {
                $query->whereHas('uses.place', function ($q) {
                    $q->where('work', true);
                });
            } elseif ($tab === 'used') {
                $query->where('master_id', $userId)->whereHas('uses', function ($q) use ($userId) {
                    $q->where('user_id', '!=', $userId);
                });
            }

            return $query->latest()->get();
        });

        return view('things.index', compact('things', 'tab'));
    }

    public function show(Thing $thing)
    {
        $this->authorize('view', $thing);

        $thing->load(['master', 'descriptions.author', 'currentDescription', 'uses.place', 'uses.user', 'uses.unit']);

        return view('things.show', compact('thing'));
    }

    public function create()
    {
        $this->authorize('create', Thing::class);

        $units = \App\Models\Unit::orderBy('name')->get();

        return view('things.create', compact('units'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Thing::class);

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

        Cache::flush();
        event(new ThingCreated($thing));
        \App\Models\User::whereKeyNot($request->user()->id)
            ->each(function ($user) use ($thing) {
                $user->notify(new ThingCreatedNotification($thing));
            });

        return redirect()->route('things.show', $thing);
    }

    public function edit(Thing $thing)
    {
        $this->authorize('update', $thing);

        $units = \App\Models\Unit::orderBy('name')->get();

        return view('things.edit', compact('thing', 'units'));
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
        Cache::flush();

        return redirect()->route('things.show', $thing);
    }

    public function destroy(Thing $thing)
    {
        $this->authorize('delete', $thing);

        DB::transaction(function () use ($thing) {
            $lastUse = $thing->uses()->latest()->first();
            $archive = ArchivedThing::create([
                'name' => $thing->name,
                'description_text' => optional($thing->currentDescription)->description,
                'owner_name' => optional($thing->master)->name,
                'last_user_name' => optional(optional($lastUse)->user)->name,
                'place_name' => optional(optional($lastUse)->place)->name,
            ]);

            $thing->delete();
        });

        Cache::flush();

        return redirect()->route('things.index');
    }

    public function addDescription(Request $request, Thing $thing)
    {
        $this->authorize('update', $thing);

        $data = $request->validate([
            'description' => ['required', 'string'],
        ]);

        $description = ThingDescription::create([
            'thing_id' => $thing->id,
            'description' => $data['description'],
            'created_by' => $request->user()->id,
        ]);

        $thing->current_description_id = $description->id;
        $thing->save();

        $recipients = $thing->uses()->with('user')->get()->pluck('user')->push($thing->master)->unique('id');
        foreach ($recipients as $recipient) {
            $recipient->notify(new ThingDescriptionChangedNotification($thing, $description));
        }

        Cache::flush();

        return redirect()->route('things.show', $thing);
    }

    public function setCurrentDescription(Request $request, Thing $thing, ThingDescription $description)
    {
        $this->authorize('update', $thing);

        if ($description->thing_id !== $thing->id) {
            abort(404);
        }

        $thing->current_description_id = $description->id;
        $thing->save();

        $recipients = $thing->uses()->with('user')->get()->pluck('user')->push($thing->master)->unique('id');
        foreach ($recipients as $recipient) {
            $recipient->notify(new ThingDescriptionChangedNotification($thing, $description));
        }

        Cache::flush();

        return redirect()->route('things.show', $thing);
    }

    public function adminIndex()
    {
        Gate::authorize('access-admin-panel');

        $things = Thing::with(['master', 'currentDescription', 'uses.place', 'uses.user', 'uses.unit'])->latest()->get();

        return view('admin.things', compact('things'));
    }
}
