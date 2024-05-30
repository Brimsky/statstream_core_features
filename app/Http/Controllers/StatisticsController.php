<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Timber\TimberSpecies;
use app\Models\Vip;

class StatisticsController extends Controller
{
    public function getUserCount()
    {
        $userCount = User::count();
        return response()->json(['userCount' => $userCount]);
    }

    public function getTimberCount()
    {
        $timberCount = TimberSpecies::count();
        return response()->json(['timberCount' => $timberCount]);
    }
}

