<?php

namespace App\Http\Controllers\Timber;
use App\Http\Controllers\Controller;
use App\Models\Timber\TimberSpecies;
use Illuminate\Http\JsonResponse;

class PublicTimberController extends Controller
{
    public function getTimberData($species = null): JsonResponse
    {
        $query = TimberSpecies::select('id', 'speacies', 'class', 'diameter', 'length', 'location', 'type', 'price', 'seller', 'date', 'url');
        
        if ($species) {
            $query->where('speacies', $species);
        }
        
        $entries = $query->orderBy('date', 'desc')
            ->get()
            ->unique(function ($item) {
                return $item['class'] . '-' . $item['diameter'] . '-' . $item['length'] . '-' . $item['location'] . '-' . $item['type'];
            });

        return response()->json([
            'entries' => $entries,
            'species' => $species
        ]);
    }
}
