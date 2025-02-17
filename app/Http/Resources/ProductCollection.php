<?php

namespace App\Http\Resources;

use App\Traits\FormatsPrices;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    use FormatsPrices;
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($product) use($request) {
                return new ProductResource($product, $request);
            }),
        ];
    }
}
