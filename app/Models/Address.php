<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'country_id',
        'postal_code',
        'province',
        'type',
        'user_id',
    ];

    protected $casts = [
        'type' => AddressType::class,
        'country_id' => 'string',
    ];

    public function country() : BelongsTo {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getFullAddress() : string {
        $province = $this->province ? ", " . $this->province : ""  . "\r\n";

        return $this->country->name . "\r\n" . 
            $this->postal_code . " " . $this->city . $province . 
            $this->address_line_1 . " " . $this->address_line_2;
    }
}
