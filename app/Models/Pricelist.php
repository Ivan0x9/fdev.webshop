<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pricelist extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    public function contractLists(): HasMany
    {
        return $this->hasMany(ContractList::class);
    }

    public function products() : BelongsToMany {
        return $this->belongsToMany(
            Product::class,
            'pricelist_product',
            'pricelist_id',
            'product_sku',
            'id',
            'sku'
        )->withPivot('price');
    }
}
