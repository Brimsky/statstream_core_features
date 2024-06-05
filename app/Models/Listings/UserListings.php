<?php

namespace App\Models\Listings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserListings extends Model
{
    

    protected $fillable =[
        'id',
        'user_id',
        'seller_company_name',
        'species',
        'sertificate',
        'class',
        'diameter',
        'length',
        'location',
        'price',
        'seller_url',
        'date'
    ];

    use HasFactory;
}
