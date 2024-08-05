<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
