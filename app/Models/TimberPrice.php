<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TimberPrice extends Model
{
    protected $fillable = [
        'date',
        'seller',
        'species',
        'type',
        'class',
        'length',
        'diameter',
        'location',
        'price',
    ];

    protected $casts = [
        'date' => 'date',
        'length' => 'float',
        'price' => 'float',
    ];

    /**
     * Scope a query to filter by seller
     */
    public function scopeBySeller(Builder $query, string $seller): Builder
    {
        return $query->where('seller', $seller);
    }

    /**
     * Scope a query to filter by species
     */
    public function scopeBySpecies(Builder $query, string $species): Builder
    {
        return $query->where('species', $species);
    }

    /**
     * Scope a query to filter by date range
     */
    public function scopeByDateRange(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to filter by location
     */
    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    /**
     * Get unique sellers
     */
    public static function getUniqueSellers()
    {
        return self::distinct()->pluck('seller');
    }

    /**
     * Get unique species
     */
    public static function getUniqueSpecies()
    {
        return self::distinct()->pluck('species');
    }

    /**
     * Get unique locations
     */
    public static function getUniqueLocations()
    {
        return self::distinct()->pluck('location');
    }

    /**
     * Get average price by species
     */
    public static function getAveragePriceBySpecies()
    {
        return self::selectRaw('species, AVG(price) as average_price')
            ->groupBy('species')
            ->get();
    }

    /**
     * Get price trends by date
     */
    public static function getPriceTrendsByDate(string $species = null)
    {
        $query = self::selectRaw('date, AVG(price) as average_price')
            ->groupBy('date')
            ->orderBy('date');

        if ($species) {
            $query->where('species', $species);
        }

        return $query->get();
    }
}
