<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class CatalogCategory extends Model
{
    use HasFactory, NodeTrait;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'name',
        'parent_id',
        'taxonomy_id'
    ];

    /**
     * Returns taxonomy
     * 
     * @return BelongsTo
     */
    public function taxonomy(): BelongsTo
    {
        return $this->belongsTo(CatalogTaxonomy::class, 'taxonomy_id');
    }

    public function products()
    {
        return $this->morphedByMany(
            Product::class,
            'product',
            'catalog_category_product',
            'category_id',
            'product_id'
        );
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getDescription(): string
    {
        return (string) $this->description ?? "";
    }
}
