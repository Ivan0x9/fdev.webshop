<?php

namespace App\Filter;

use Illuminate\Database\Eloquent\Builder;

class FilterResponse
{
    /**
     * Results.
     * 
     * @var \Illuminate\Support\Collection
     * @param \Closure $callback
     */
    protected $results;

    public function __construct(
        protected FilterRequest $request,
        protected Builder $query,
    ) {
        $this->results = $this->filter();
    }

    protected function filter()
    {
        $query = $this->query;
        $request = $this->request;

        if($request->hasCategory()) {
            $query->whereHas('categories', function ($subquery) use ($request) {
                $subquery->where('name', 'LIKE', '%'.$request->getCategory().'%');
            });
        }

        if($request->hasTitle()) {
            $query->where('title', 'LIKE', '%'.$request->getTitle().'%');
        }

        if($request->hasPriceMin()) {
            $query->where('price', '>=', $request->getPriceMin());
        }

        if($request->hasPriceMax()) {
            $query->where('price', '<=', $request->getPriceMax());
        }

        if($request->hasSortField()) {
            if($request->hasSortDirection()) {
                $sortDirection = $request->getSortDirection(); // default: asc
            }

            $sortField = $request->getSortField();

            if (in_array($sortField, ['price', 'title'])) {
                $query->orderBy($sortField, $sortDirection);
            }
        }
    }
}