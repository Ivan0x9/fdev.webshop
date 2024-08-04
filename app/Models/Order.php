<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'status',
        'billpayer_id',
        'shipping_address_id',
        'payment_details',
        'total',
        'note',
        'reference',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_details' => 'array'
    ];
    
    public function billpayer() : BelongsTo {
        return $this->belongsTo(Address::class, 'billpayer_id', 'user_id')->where('type', 'billing');
    }

    public function shippingAddress() : BelongsTo {
        return $this->belongsTo(Address::class, 'billpayer_id', 'user_id')->where('type', 'shipping');
    }
}
