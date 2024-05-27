<?php

namespace App\Models\Timber;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Timber\TimberSpecies;

class FollowedTimber extends Model
{
    use HasFactory;

    protected $table = 'saved_timbers';

    protected $fillable = ['user_id', 'liked_material', 'notify_status', 'initial_price'];

    public function timberSpecies()
    {
        return $this->belongsTo(TimberSpecies::class, 'liked_material');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

