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
        $savedMaterials = FollowedTimber::with('timberSpecies')
            ->where('user_id', Auth::id())
            ->get();

        // Log::info('Saved materials:', $savedMaterials->toArray());

        return Inertia::render('SavedMaterials', [
            'savedMaterials' => $savedMaterials
        ]);   
    }

    public function store(Request $request)
    {
        $request->validate([
            'liked_material' => 'required|exists:timber_species,id',
        ]);

        $savedTimber = new FollowedTimber([
            'user_id' => $request->user()->id,
            'liked_material' => $request->input('liked_material'),
            'notify_status' => false,
        ]);

        $savedTimber->save();

        return response()->json(['message' => 'Timber saved successfully!'], 200);
    }


}
