<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CatalogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Initial database seeders
         */
        $this->call(Countries::class);
        $this->call(CatalogTaxonomies::class);

        /**
         * User factory
         */
        User::factory(10)->create();

        /**
         * Category and subcategory seeders
         */
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('catalog_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $parentCategories = CatalogCategory::factory()->count(10)->create();

        $parentCategories->each(function ($parent) {
            $subcategoriesCount = rand(10, 15);
            for ($i = 0; $i < $subcategoriesCount; $i++) {
                CatalogCategory::factory()->create([
                    'name' => fake()->word(),
                    'description' => fake()->sentence(),
                    'parent_id' => $parent->id,
                    'taxonomy_id' => $parent->taxonomy->id,
                ]);
            }
        });
    }
}
