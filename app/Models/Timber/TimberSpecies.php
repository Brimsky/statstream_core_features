<?php

namespace App\Models\Timber;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimberSpecies extends Model
{
    // Assuming you have these fields in your 'timber_species' table
    protected $fillable = [
        'species',
        'class',
        'diameter',
        'length',
        'location',
        'price',
        'date'
    ];
    use HasFactory;
}
