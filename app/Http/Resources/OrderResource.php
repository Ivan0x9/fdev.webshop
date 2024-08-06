<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->number,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'billpayer_id' => $this->billpayer_id,
            'shipping_address_id' => $this->shipping_address_id,
            'payment_details' => $this->payment_details,
            'total' => $this->total,
            'note' => $this->note,
            'reference' => $this->reference,
        ];
    }
}
