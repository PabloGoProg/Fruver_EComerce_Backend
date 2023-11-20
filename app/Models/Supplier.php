<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplier extends Model
{
    use HasFactory;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier', 'product_id', 'supplier_id')
            ->withPivot('id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'user_type',
        'status',
        'birthday'
    ];
}
