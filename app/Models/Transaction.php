<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Transaction extends Model
{
    protected $table = 'transactions.transactions'; // Schema-qualified table name

    protected $fillable = [
        'uid',
        'status',
        'value',
        'currency',
        'method',
        'gateway',
        'email',
        'product_id',
        'country',
        'gateway_reference',
        'promo_code',
        'itinerary_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => AsArrayObject::class, // Ensures metadata is cast as JSON
    ];

    /**
     * Relationship with Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Relationship with Itinerary.
     */
    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class, 'itinerary_id', 'id');
    }


    public function isClosed(): bool
    {
        return in_array($this->status,['COMPLETED', 'FAILED', 'CANCELLED'], true);
    }
}
