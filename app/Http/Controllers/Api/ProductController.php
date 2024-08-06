<?php

namespace App\Http\Controllers\Api;

use App\Filter\FilterRequest;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Pricelist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function productsAll() : object {
        $products = Product::listed()
            ->orderByTitle()
            ->paginate(25);

        return new ProductCollection($products);
    }

    public function productsFilter(Request $request) : object
    {
        $products = Product::with('categories')
            ->listed();

        $filtered = new FilterRequest($request);
        $filtered->filter($products);

        $products = $products->paginate(25);

        return new ProductCollection($products);
    }

    public function product($sku) : object
    {
        $product = Product::with('categories')
            ->listed()
            ->where('sku', $sku)
            ->first();

        return new ProductResource($product);
    }
}
