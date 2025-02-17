<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $status = Arr::random(ProductStatus::cases());

        $inStock = rand(10, 500);
        $price = rand(20, 2000);
 
        return [
            'sku' => fake()->unique()->bothify('??##?#??##?#'),
            'is_published' => 1,
            'name' => fake()->words(2, true),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->text(),
            'status' => $status->value,
            'in_stock' => $inStock,
            'price' => $price,
        ];
    }
}
