<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_sku',
        'quantity',
        'price',
    ];

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_sku', 'sku');
    }
}
