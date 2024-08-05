<?php

namespace Database\Seeders;

use App\Models\CatalogCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogCategoryProduct extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('catalog_categories')->truncate();
        DB::table('products')->truncate();
        DB::table('catalog_category_product')->truncate();

        /**
         * Category and subcategory factory
         */
        $parentCategories = CatalogCategory::factory()->count(10)->create();
        $subCategories = [];

        $parentCategories->each(function ($parent) {
            $subcategoriesCount = rand(10, 15);
            for ($i = 0; $i < $subcategoriesCount; $i++) {
                $subCategory = CatalogCategory::factory()->create([
                    'name' => fake()->word(),
                    'description' => fake()->sentence(),
                    'parent_id' => $parent->id,
                    'taxonomy_id' => $parent->taxonomy->id,
                ]);

                $subCategories[] = $subCategory;
            }
        });

        $categories = $parentCategories->merge($subCategories);

        /**
         * Product factory
         */
        $products = Product::factory(500)->create();

        $products->each(function ($product) use ($categories) {
            $assignedCategories = $categories->random(rand(1, 2));

            foreach ($assignedCategories as $category) {
                $hasCategoryInTaxonomy = $product->categories()
                    ->where('taxonomy_id', $category->taxonomy_id)
                    ->exists();
        
                if (!$hasCategoryInTaxonomy) {
                    $product->categories()->attach($category->id);
                }
            }
        });
    }
}