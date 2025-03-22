<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'transactions.products'; // Schema-qualified table name

    protected $fillable = [
        'uid',
        'status',
        'value',
        'currency',
        'name',
    ];

    protected $casts = [
        'value' => 'integer',
    ];

    /**
     * Relationship with Transactions.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'product_id', 'id');
    }
}
