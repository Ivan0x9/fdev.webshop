<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'tax_number',
    ];

    public function contractList(): HasOne
    {
        return $this->hasOne(ContractList::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function address() : HasOne {
        return $this->hasOne(Address::class, 'user_id');
    }

    public function orders() : HasMany {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function getBillingAddressId() : mixed {
        return  $this->address->type->value == AddressType::Billing->value ? (int) $this->address->id : null;
    }

    public function getShippingAddressId() : mixed {
        return  $this->address->type->value == AddressType::Shipping->value ? (int) $this->address->id : null;
    }
}
