<?php

namespace App\Models\Timber;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimberSpecies extends Model
{
    protected $fillable = [
        'id',
        'species',
        'class',
        'diameter',
        'length',
        'location',
        'price',
        'url',
        'date'
    ];
    use HasFactory;
}
