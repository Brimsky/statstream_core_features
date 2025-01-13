<?php

namespace App\Http\Controllers\Timber;
use App\Http\Controllers\Controller;
use App\Models\TimberPrice;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TimberSpeciesController extends Controller
{
    public function index()
    {
        $species = TimberPrice::select('species')
            ->selectRaw('COUNT(DISTINCT seller) as seller_count')
            ->selectRaw('COUNT(*) as listing_count')
            ->selectRaw('AVG(price) as average_price')
            ->selectRaw('MIN(price) as min_price')
            ->selectRaw('MAX(price) as max_price')
            ->groupBy('species')
            ->orderBy('species')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->species,
                    'seller_count' => $item->seller_count,
                    'listing_count' => $item->listing_count,
                    'average_price' => round($item->average_price, 2),
                    'min_price' => round($item->min_price, 2),
                    'max_price' => round($item->max_price, 2),
                ];
            });

        return Inertia::render('TimberCategory', ['species' => $species]);
    }

    public function show($species)
    {
        $entries = TimberPrice::select('id', 'species', 'class', 'diameter', 'length', 'location', 'type', 'price', 'seller', 'date')
            ->where('species', $species)
            ->orderBy('date', 'desc')
            ->get();

        // Get unique entries for the main table
        $uniqueEntries = $entries->unique(function ($item) {
            return $item['class'] . '-' . $item['diameter'] . '-' . $item['length'] . '-' . $item['location'] . '-' . $item['type'];
        });

        // Get price trends
        $priceTrends = TimberPrice::where('species', $species)
            ->selectRaw('DATE(date) as date, AVG(price) as average_price')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get location-based statistics
        $locationStats = TimberPrice::where('species', $species)
            ->selectRaw('location, AVG(price) as average_price, COUNT(*) as listing_count')
            ->groupBy('location')
            ->orderBy('average_price', 'desc')
            ->get();

        // Get seller statistics
        $sellerStats = TimberPrice::where('species', $species)
            ->selectRaw('seller, COUNT(*) as listing_count, AVG(price) as average_price')
            ->groupBy('seller')
            ->orderBy('listing_count', 'desc')
            ->get();

        return Inertia::render('TimberChart', [
            'entries' => $uniqueEntries,
            'species' => $species,
            'priceTrends' => $priceTrends,
            'locationStats' => $locationStats,
            'sellerStats' => $sellerStats,
        ]);
    }

    public function filter(Request $request)
    {
        $query = TimberPrice::query();

        // Apply filters
        if ($request->has('species')) {
            $query->where('species', $request->species);
        }

        if ($request->has('seller')) {
            $query->where('seller', $request->seller);
        }

        if ($request->has('location')) {
            $query->where('location', $request->location);
        }

        if ($request->has('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $entries = $query->orderBy('date', 'desc')->get();

        return response()->json([
            'entries' => $entries,
            'total' => $entries->count(),
            'stats' => [
                'average_price' => $entries->avg('price'),
                'max_price' => $entries->max('price'),
                'min_price' => $entries->min('price'),
                'total_listings' => $entries->count(),
            ]
        ]);
    }

    public function getStats()
    {
        $stats = [
            'total_listings' => TimberPrice::count(),
            'unique_species' => TimberPrice::distinct('species')->count(),
            'unique_sellers' => TimberPrice::distinct('seller')->count(),
            'unique_locations' => TimberPrice::distinct('location')->count(),
            'price_range' => [
                'min' => TimberPrice::min('price'),
                'max' => TimberPrice::max('price'),
                'avg' => TimberPrice::avg('price'),
            ],
            'latest_update' => TimberPrice::max('date'),
            'top_species' => TimberPrice::selectRaw('species, COUNT(*) as count')
                ->groupBy('species')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get(),
            'top_locations' => TimberPrice::selectRaw('location, COUNT(*) as count')
                ->groupBy('location')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get(),
        ];

        return response()->json($stats);
    }
}
