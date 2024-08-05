<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogTaxonomy extends Model
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
        'name'
    ];

    /**
     * Returns catalog categories
     * 
     * @return HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(CatalogCategory::class, 'taxonomy_id');
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return (string) $this->name;
    }

    /**
     * Get an array with the values of a name and id.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function pluckToTree()
    {
        $nodes = [];

        $traverse = function ($categories, $prefix = '') use (&$traverse, &$nodes) {
            foreach ($categories as $taxon) {
                $suffix = '';
        
                if ($taxon->parent) {
                    if ($taxon->parent->parent) {
                        $prefix =  $taxon->parent->parent->name . ' / ' . $taxon->parent->name;
                    } else {
                        $prefix = $taxon->parent->name;
                    }

                    $prefix .= ' / ';
                }

                $nodes[$taxon->id] = $prefix . $taxon->name . $suffix;

                $traverse($taxon->children, $prefix);
            }
        };

        $traverse(
            $this->categories()
                ->defaultOrder()
                ->get()
                ->toTree()
        );

        return $nodes;
    }
}
