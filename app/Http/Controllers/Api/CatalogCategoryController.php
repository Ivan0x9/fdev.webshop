<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\CatalogCategory;
use App\Models\CatalogTaxonomy;

class CatalogCategoryController extends Controller
{
    public function catalogCategories() : object
    {
        $taxonomies = CatalogTaxonomy::with(['categories'])
            ->orderBy('name')
            ->get();

        $catalogData = [];

        foreach($taxonomies as $taxonomy) {
            $catalogData[] = $taxonomy->pluckToTree();
        }

        return collect($catalogData);
    }

    public function products($id) : object
    {
        $category = CatalogCategory::findOrFail($id);

        $products = $category->products()->listed()->paginate(25);

        return (new CategoryResource($category))->additional([
            'products' => ProductResource::collection($products),
            
            'meta' => [
                'current_page' => $products->currentPage(),
                'from' => $products->firstItem(),
                'last_page' => $products->lastPage(),
                'links' => [
                    'first' => $products->url(1),
                    'last' => $products->url($products->lastPage()),
                    'prev' => $products->previousPageUrl(),
                    'next' => $products->nextPageUrl(),
                ],
                'path' => request()->url(),
                'per_page' => $products->perPage(),
                'to' => $products->lastItem(),
                'total' => $products->total(),
            ],
        ]);
    }
}
