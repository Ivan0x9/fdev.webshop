<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CatalogCategory;
use App\Models\Product;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /**
         * Initial database seeders
         */
        // $this->call(Countries::class);
        // $this->call(CatalogTaxonomies::class);
        // $this->call(CatalogCategoryProduct::class);
        $this->call(Pricelists::class);

        /**
         * User factory
         */
        // User::factory(10)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
