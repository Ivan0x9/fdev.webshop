<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address_line_1' => fake()->streetName(),
            'address_line_2' => fake()->buildingNumber(),
            'city' => fake()->city(),
            'country_id' => Country::inRandomOrder()->first()->id,
            'postal_code' => fake()->postcode(),
            'province' => null,
        ];
    }
}