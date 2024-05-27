<?php

namespace App\Http\Controllers\Timber;

use App\Http\Controllers\Controller;
use App\Models\Timber\FollowedTimber;
use App\Models\Timber\TimberSpecies;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;


class SavedMaterialsController extends Controller
{
    public function index()
    {
        // Fetch saved materials
        $savedMaterials = FollowedTimber::with('timberSpecies')
            ->where('user_id', Auth::id())
            ->get();

        // Map through saved materials to calculate price changes
        $materialsWithPriceChange = $savedMaterials->map(function ($savedMaterial) {
            $timberSpecies = $savedMaterial->timberSpecies;

            // Fetch the latest price data for the same species
            $latestTimberSpecies = TimberSpecies::where('speacies', $timberSpecies->speacies)
                ->where('class', $timberSpecies->class)
                ->where('diameter', $timberSpecies->diameter)
                ->where('length', $timberSpecies->length)
                ->where('location', $timberSpecies->location)
                ->orderBy('date', 'desc')
                ->first();

            if ($latestTimberSpecies) {
                $currentPrice = (int) $latestTimberSpecies->price;
                $initialPrice = (int) $savedMaterial->initial_price;
                $priceChange = $currentPrice - $initialPrice;
                $priceChangePercentage = $initialPrice ? (($priceChange / $initialPrice) * 100) : 0;

                return [
                    'id' => $savedMaterial->id,
                    'timber_species' => $latestTimberSpecies,
                    'initial_price' => $initialPrice,
                    'price_change' => $priceChange,
                    'price_change_percentage' => $priceChangePercentage,
                ];
            }

            return [
                'id' => $savedMaterial->id,
                'timber_species' => $timberSpecies,
                'initial_price' => (int) $savedMaterial->initial_price,
                'price_change' => 0,
                'price_change_percentage' => 0,
            ];
        });

        return Inertia::render('SavedMaterials', [
            'savedMaterials' => $materialsWithPriceChange,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'liked_material' => 'required|exists:timber_species,id',
        ]);

        $timberSpecies = TimberSpecies::find($request->input('liked_material'));

        $savedTimber = new FollowedTimber([
            'user_id' => $request->user()->id,
            'liked_material' => $request->input('liked_material'),
            'notify_status' => false,
            'initial_price' => $timberSpecies->price,
        ]);

        $savedTimber->save();

        return response()->json(['message' => 'Timber saved successfully!'], 200);
    }

    public function destroy($id)
    {
        $savedMaterial = FollowedTimber::where('user_id', Auth::id())->findOrFail($id);
        $savedMaterial->delete();

        return redirect()->route('saved-materials.index')->with('message', 'Saved material deleted successfully!');
    }
}
