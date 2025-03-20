<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Itinerary extends Model
{
    use HasFactory;

    protected $table = 'itinerary.itinerary';

    protected $fillable = [
        'uid',
        'status',
        'email',
        'itinerary',
        'destination',
        'categories',
        'transportation',
        'number_of_people',
        'origin',
        'from',
        'to',
        'budget',
        'currency',
    ];

    protected $casts = [
        'itinerary' => 'array',
        'categories' => 'array',
        'transportation' => 'array',
        'from' => 'datetime',
        'to' => 'datetime',
        'budget' => 'decimal:2',
    ];
}
