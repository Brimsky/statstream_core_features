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
        $species = TimberSpecies::select('speacies')->distinct()->get();
        return Inertia::render('TimberCategory', ['species' => $species]);
    }

    public function show($species)
    {
        $entries = TimberSpecies::where('speacies', $species)->get();
        return Inertia::render('TimberChart', ['entries' => $entries, 'species' => $species]);
    }

}

