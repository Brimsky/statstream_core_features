<?php

namespace App\Http\Controllers\Timber;

use App\Http\Controllers\Controller;
use App\Models\Listings\UserListings;
use Illuminate\Http\Request;
use Inertia\Inertia;


class TimberListings extends Controller
{
    public function index()
    {
        $listings = UserListings::all();
        return Inertia::render('UserLisrings', ['listings' => $listings]);
    }

    public function show($listings)
    {

        return Inertia::render('TimberChart', ['listings' => $listings]);
    }

}
