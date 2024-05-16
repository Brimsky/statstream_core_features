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
        $savedMaterials = FollowedTimber::where('user_id', auth()->id())->get();

        return Inertia::render('SavedMaterials', [
            'savedMaterials' => $savedMaterials
        ]);
    }


    public function store(Request $request)
{
    $request->validate([
        'liked_material' => 'required|exists:timber_species,id', // Validation to ensure the ID exists in the `timber_species` table
    ]);

    $savedTimber = new FollowedTimber([
        'user_id' => $request->user()->id,
        'liked_material' => $request->input('liked_material'), // Use input method for safety
        'notify_status' => false, // Default value, can be set based on your application's logic
    ]);

    $savedTimber->save();

    return response()->json(['message' => 'Timber saved successfully!'], 200);
}


}
