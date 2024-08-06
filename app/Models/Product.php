<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'is_published',
        'in_stock',
        'name',
        'price',
        'sku',
        'slug',
        'status',
        'title',
    ];

    public function categories(): MorphToMany
    {
        return $this->morphToMany(
            CatalogCategory::class,
            'product',
            'catalog_category_product',
            'product_id',
            'category_id'
        )->withTimestamps();
    }

    public function pricelists(): BelongsToMany
    {
        return $this->belongsToMany(
            Pricelist::class,
            'pricelist_product',
            'product_sku',
            'pricelist_id',
            'sku',
            'id'
        )->withPivot('price');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'status' => ProductStatus::class,
    ];

    public function getPrice() : float {
        if(Auth::check()) {
            $user = User::with('contractList.pricelist.products')->find(Auth::id());

            if($user->contractList) {
                $product = $user->contractList->pricelist->products
                    ->where('sku', $this->sku)
                    ->first();

                    $price = $product->pivot->price;
            }

            $price = $this->price;

        } else if($this->pricelists) {
            $pricelist = $this->pricelists->where('title', 'default')->first();

            if($pricelist) {
                $price = $pricelist->pivot->price;
            }
            
            $price = $this->price;
            
        } else {
            $price = $this->price;
        }

        return (float) $price;
    }

    public function getTitle() : string {
        return (string) $this->title ?? $this->name;
    }

    public function scopeOrderByTitle(Builder $query) : Builder {
        $orderTitle = $this->title ? 'title' : 'name';

        return $query->orderBy($orderTitle, 'desc');
    }

    public function scopeListed(Builder $query) : Builder {
        return $query->where('is_published', 1)
            ->whereIn('status', ['available', 'unavailable']);
    }
}
