<?php

namespace App\Models\Timber;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Timber\TimberSpecies;

class FollowedTimber extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'timber_species_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'saved_timbers'; // Make sure to specify the table name if it doesn't follow Laravel's naming convention

    /**
     * Get the timber species associated with the followed timber.
     */
    public function timberSpecies()
    {
        return $this->belongsTo(TimberSpecies::class, 'timber_species_id');
    }

    /**
     * Get the user that follows the timber species.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
