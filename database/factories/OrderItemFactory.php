<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderId = Arr::random(Order::pluck('id')->toArray());
        $productSku = Arr::random(Product::pluck('sku')->toArray());

        return [
            'order_id' => $orderId,
            'product_sku' => $productSku,
            'quantity' => rand(1, 100),
            'price' => Product::where('sku', $productSku)->first()->getPrice(),
        ];
    }
}