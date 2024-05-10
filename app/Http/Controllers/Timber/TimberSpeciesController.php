<?php

namespace App\Http\Controllers\Timber;
use App\Http\Controllers\Controller;
use App\Models\Timber\TimberSpecies;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use Inertia\Response;
use Illuminate\Http\Request;


class TimberSpeciesController extends Controller
{
    public function index()
    {
        // Fetch unique species
        $species = TimberSpecies::select('speacies')->distinct()->get();
        return Inertia::render('TimberCategory', ['species' => $species]);
    }

    public function show($species)
    {
        // Fetch all entries under the chosen species
        $entries = TimberSpecies::where('speacies', $species)->get();
        return Inertia::render('TimberChart', ['entries' => $entries, 'species' => $species]);
    }

    // public function saveTimber(Request $request, $timberId)
    // {
    //     $user = auth()->user();
    //     if (!$user->vipStatus || !$user->vipStatus->status) {
    //         abort(403, 'This action is only available for VIP users.');
    //     }

    //     $user->followedTimbers()->syncWithoutDetaching([$timberId]);

    //     return redirect()->back()->with('message', 'Timber species followed successfully.');
    // }

    // public function followedTimbers()
    // {
    //     $user = auth()->user();
    //     if (!$user->is_vip) {
    //         abort(403, 'This action is only available for VIP users.');
    //     }

    //     $followedTimbers = $user->followedTimbers()->with('timberSpecies')->get();
    //     return view('followed_timbers', compact('followedTimbers'));
    // }

}

