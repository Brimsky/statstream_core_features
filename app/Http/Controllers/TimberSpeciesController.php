<?php

namespace App\Http\Controllers;

use App\Models\TimberSpecies;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
}

