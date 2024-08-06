<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'name',
        'company',
        'tax_number',
        'email',
        'billing_address',
        'shipping_address',
        'order_items',
        'payment_details',
        'total',
        'note'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'order_items' => 'array',
        'payment_details' => 'array'
    ];
}
