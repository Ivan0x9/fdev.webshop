<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($product) {
                return [
                    'sku' => $this->sku,
                    'title' => $this->getTitle(),
                    'description' => $this->description,
                    'status' => $this->status,
                    'price' => $this->formatPrice($this->price),
                    'status' => $this->status,
                ];
            }),
        ];
    }
}
