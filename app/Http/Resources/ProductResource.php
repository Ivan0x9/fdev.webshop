<?php

namespace App\Http\Resources;

use App\Traits\FormatsPrices;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    use FormatsPrices;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sku' => $this->sku,
            'title' => $this->getTitle(),
            'description' => $this->description,
            'status' => $this->status,
            'price' => $this->formatPrice($this->price),
            'status' => $this->status,
        ];
    }
}
