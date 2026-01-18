<?php

namespace App\Http\Controllers;

use App\Models\ArchivedThing;
use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = ArchivedThing::latest()->get();

        return view('archive.index', compact('archives'));
    }

    public function restore(Request $request, ArchivedThing $archive)
    {
        if ($archive->restored_at) {
            return redirect()->route('archive.index');
        }

        DB::transaction(function () use ($archive, $request) {
            $thing = Thing::create([
                'name' => $archive->name,
                'wrnt' => null,
                'master_id' => $request->user()->id,
                'total_amount' => 1,
            ]);

            $archive->restored_at = now();
            $archive->restored_by_user_id = $request->user()->id;
            $archive->save();
        });

        return redirect()->route('archive.index');
    }
}
