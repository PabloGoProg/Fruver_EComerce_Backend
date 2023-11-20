<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sell extends Model
{
    use HasFactory;

    // Many to Many relationship between Sell and Product
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sell', 'sell_id', 'product_id')
            ->withPivot('id', 'orderedQuantity');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];
}
