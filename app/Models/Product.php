<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProductType;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory;

    public function product_types(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'product_type');
    }

    public function product_categories(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }

    // Many to Many relationship between Product and ShoppingCart
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user', 'product_id', 'user_id')
            ->withPivot('id', 'orderedQuantity');
    }

    public function sells(): BelongsToMany
    {
        return $this->belongsToMany(Sell::class, 'product_sell');
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier', 'product_id', 'supplier_id')
            ->withPivot('id');
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'status',
        'product_type',
        'quantity',
        'img'
    ];
}
