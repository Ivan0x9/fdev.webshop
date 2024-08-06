<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = Arr::random(OrderStatus::cases());
        $billpayerId = Arr::random(Address::where('type', 'billing')->pluck('id')->toArray());
        $shipping = Arr::random(Address::where('type', 'shipping')->pluck('id')->toArray());

        return [
            'number' => fake()->uuid(),
            'status' => $status,
            'billpayer_id' => $billpayerId,
            'shipping_address_id' => $shipping,
            'payment_details' => [
                'amount' => rand(50, 2000),
                'tax' => 0.23,
                'discount' => rand(0, 20),
                'shipping' => Arr::random([0, 50, 100]),
            ],
            'total' => rand(80, 2200),
            'note' => fake()->paragraph(),
            'reference' => fake()->unique()->bothify('##?##?##'),
        ];
    }
}