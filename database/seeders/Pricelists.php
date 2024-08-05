<?php

namespace Database\Seeders;

use App\Models\Pricelist;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pricelists extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('pricelists')->truncate();
        DB::table('pricelist_product')->truncate();

        Pricelist::insert([
            [ 'title' => 'default', 'created_at' => now(), 'updated_at' => now() ],
            [ 'title' => 'season_1', 'created_at' => now(), 'updated_at' => now() ],
            [ 'title' => 'season_2', 'created_at' => now(), 'updated_at' => now() ],
            [ 'title' => 'special_offers', 'created_at' => now(), 'updated_at' => now() ],
            [ 'title' => 'holidays', 'created_at' => now(), 'updated_at' => now() ],
        ]);

        $pricelists = Pricelist::all();


        foreach($pricelists as $pricelist) {
            $products = Product::listed()->inRandomOrder()->limit(rand(100, 200))->get();
            foreach($products as $product) {
                $price = rand(50, 1500);

                $pricelist->products()->attach($product->sku, ['price' => $price]);
            }
        }   
    }
}