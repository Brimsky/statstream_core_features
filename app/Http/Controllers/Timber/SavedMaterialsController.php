<?php

namespace App\Http\Controllers\Timber;
use App\Http\Controllers\Controller;

use Inertia\Inertia;
use App\Models\Timber\FollowedTimber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SavedMaterialsController extends Controller
{
    public function index()
{
    Log::info('Loading SavedMaterialsController');
    $user = Auth::user();
    $savedMaterials = FollowedTimber::where('user_id', $user->id)->get();

    return Inertia::render('SavedMaterials', [
        'savedMaterials' => $savedMaterials
    ]);
}

}
