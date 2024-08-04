<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function products() : HasMany {
        return $this->hasMany(Product::class, 'product_sku', 'sku');
    }

    // Select price - thought help
    public function getPrice($sku) : float {
        return $this->products()->where('sku', $sku)->first();
    }
}
