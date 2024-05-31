<?php

namespace App\Http\Controllers\Timber;
use App\Http\Controllers\Controller;
use App\Models\Timber\TimberSpecies;
use Inertia\Inertia;


//use App\Models\User;
// use Illuminate\Support\Facades\DB;
// use Inertia\Response;
// use Illuminate\Http\Request;


class TimberSpeciesController extends Controller
{
    public function index()
    {
        $species = TimberSpecies::select('speacies')->distinct()->get();
        return Inertia::render('TimberCategory', ['species' => $species]);
    }

    public function show($species)
    {
        $entries = TimberSpecies::select('id', 'speacies', 'class', 'diameter', 'length', 'location', 'type', 'price', 'seller', 'date', 'url')
            ->where('speacies', $species)
            ->orderBy('date', 'desc')
            ->get()
            ->unique(function ($item) {
                return $item['class'] . '-' . $item['diameter'] . '-' . $item['length'] . '-' . $item['location'] . '-' . $item['type'];
            });

        return Inertia::render('TimberChart', ['entries' => $entries, 'species' => $species]);
    }
}

