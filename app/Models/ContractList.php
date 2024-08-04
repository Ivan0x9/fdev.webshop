<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractList extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pricelist_id',
        'user_id'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function pricelist() : BelongsTo {
        return $this->belongsTo(Pricelist::class);
    }
}
