<?php

namespace App\Models;

use App\Traits\OrderModificators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use OrderModificators, HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'status',
        'user_id',
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
    
    public function billingAddress() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'billpayer_id', 'id')->where('type', 'billing');
    }

    public function shippingAddress() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id', 'id')->where('type', 'shipping');
    }

    public function items() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
