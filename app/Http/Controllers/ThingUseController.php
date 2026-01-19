<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Thing;
use App\Models\ThingUse;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\ThingAssignedAdminNotification;
use App\Notifications\ThingAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ThingUseController extends Controller
{
    public function create(Thing $thing)
    {
        $this->authorize('update', $thing);

        $usedAmount = $thing->uses()->sum('amount');
        $availableAmount = max(0, $thing->total_amount - $usedAmount);

        $users = User::orderBy('name')->get();
        $places = Place::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('things.assign', compact('thing', 'users', 'places', 'units', 'availableAmount'));
    }

    public function store(Request $request, Thing $thing)
    {
        $this->authorize('update', $thing);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'place_id' => ['required', 'exists:places,id'],
            'amount' => ['required', 'integer', 'min:1'],
            'unit_id' => ['nullable', 'exists:units,id'],
        ]);

        $usedAmount = $thing->uses()->sum('amount');
        $availableAmount = max(0, $thing->total_amount - $usedAmount);
        if ($data['amount'] > $availableAmount) {
            return back()->withErrors([
                'amount' => 'Недостаточно доступного количества у владельца.',
            ])->withInput();
        }

        $use = ThingUse::create([
            'thing_id' => $thing->id,
            'user_id' => $data['user_id'],
            'place_id' => $data['place_id'],
            'amount' => $data['amount'],
            'unit_id' => $data['unit_id'] ?? null,
        ]);

        $assignee = User::find($data['user_id']);
        $assignee->notify(new ThingAssignedNotification($thing, $use));

        $admins = User::whereHas('role', function ($query) {
            $query->where('slug', 'admin');
        })->get();
        foreach ($admins as $admin) {
            $admin->notify(new ThingAssignedAdminNotification($thing, $use, $assignee));
        }

        Cache::flush();

        $unitLabel = $use->unit?->abbreviation ? " {$use->unit->abbreviation}" : '';
        $message = "Вещь «{$thing->name}» передана пользователю {$assignee->name} ({$use->amount}{$unitLabel}).";

        return redirect()->route('things.show', $thing)->with('status', $message);
    }
}
