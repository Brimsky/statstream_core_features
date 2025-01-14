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
        'url',
    ];

    protected $casts = [
        'date' => 'date',
        'length' => 'float',
        'price' => 'float',
    ];

    
    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderBy('date', 'desc');
    }

    
    public function scopeBySeller(Builder $query, string $seller): Builder
    {
        return $query->where('seller', $seller);
    }

    
    public function scopeBySpecies(Builder $query, string $species): Builder
    {
        return $query->where('species', $species);
    }

    
    public function scopeByDateRange(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    
    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    
    public static function getUniqueSellers()
    {
        return self::distinct()->pluck('seller');
    }

  
    public static function getUniqueSpecies()
    {
        return self::distinct()->pluck('species');
    }

    
    public static function getUniqueLocations()
    {
        return self::distinct()->pluck('location');
    }

   
    public static function getAveragePriceBySpecies()
    {
        return self::selectRaw('species, AVG(price) as average_price')
            ->groupBy('species')
            ->get();
    }

   
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
