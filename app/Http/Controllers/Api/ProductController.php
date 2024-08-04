<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function products() : object {
        $products = Product::query()
            ->published()
            ->orderByTitle()
            ->paginate(50);

        return new ProductCollection($products);
    }

    public function product($sku) : object {
        $product = Product::query()
            ->find($sku);

        return new ProductResource($product);
    }
}
