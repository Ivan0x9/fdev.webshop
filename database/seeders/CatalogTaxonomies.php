<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogTaxonomies extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('catalog_taxonomies')->delete();

        DB::table('catalog_taxonomies')->insert([
            [
                'id'          => 1,
                'name'        => 'Product Categories',
                'description' => 'All product categories available',
            ],
            [
                'id'          => 2,
                'name'        => 'Brands',
                'description' => 'Product Brands',
            ],
        ]);
    }
}