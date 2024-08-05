<?php

namespace App\Filter;

use App\Filter\FilterResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;

class FilterRequest
{
    public function __construct(
        protected Request $request
    ) {}

    /**
     * Returns search response.
     * 
     * @param \Closure $callback
     * 
     */
    public function filter(Builder $query) : object
    {
        return new FilterResponse($this, $query);
    }

    /**
     * Checks if this request has category.
     * 
     */
    public function hasCategory() : bool {
        return $this->request->filled('category');
    }

    /**
     * Checks if this request has title.
     * 
     */
    public function hasTitle() : bool {
        return $this->request->filled('title');
    }

    /**
     * Checks if this request has maximum price.
     * 
     */
    public function hasPriceMax() : bool {
        return $this->request->filled('price_max');
    }

     /**
     * Checks if this request has minimum price.
     * 
     */
    public function hasPriceMin() : bool {
        return $this->request->filled('price_min');
    }
    
    /**
     * Checks if this request has sort direction.
     * 
     */
    public function hasSortDirection() : bool {
        return $this->request->filled('sort.direction');
    }

    /**
     * Checks if this request has sort by field.
     * 
     */
    public function hasSortField() : bool {
        return $this->request->filled('sort.field');
    }

    /**
     * Returns the category.
     * 
     */
    public function getCategory() : string {
        return (string) $this->request->get('category');
    }

    /**
     * Returns the title.
     * 
     */
    public function getTitle() : string {
        return (string) $this->request->get('title');
    }

    /**
     * Checks if this request has maximum price.
     * 
     */
    public function getPriceMax() : float {
        return (float) $this->request->get('price_max');
    }

     /**
     * Checks if this request has minimum price.
     * 
     */
    public function getPriceMin() : bool {
        return (float) $this->request->get('price_min');
    }
    
    /**
     * Returns sort direction.
     * 
     */
    public function getSortDirection() : string {
        return (string) $this->request->input('sort.direction', 'asc');
    }

    /**
     * Returns the items from sort field.
     * 
     */
    public function getSortField() : string {
        return (string) $this->request->input('sort.field');
    }
}