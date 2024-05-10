<?php

namespace App\Models\Timber;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Timber\TimberSpecies,
    App\Models\User;

class FollowedTimber extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'timber_species_id'];

    public function timberSpecies()
    {
        return $this->belongsTo(TimberSpecies::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


