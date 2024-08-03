<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kalnoy\Nestedset\NodeTrait;

class CatalogCategory extends Model
{
    use HasFactory, NodeTrait;

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

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return (string) $this->name;
    }
}
