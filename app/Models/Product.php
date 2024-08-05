<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'status' => ProductStatus::class,
    ];

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
