<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\TimberSpecies;

class TimberSpeciesController extends Controller
{
    public function index()
    {
        $species = TimberSpecies::all();
        return Inertia::render('TimberCategory', ['species' => $species]);
    }

    public function show($id)
    {
        $species = TimberSpecies::findOrFail($id);
        return Inertia::render('TimberChart', ['species' => $species]);
    }
}

