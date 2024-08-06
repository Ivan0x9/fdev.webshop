<?php

namespace Database\Seeders;

use App\Models\ContractList;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractLists extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('contract_lists')->truncate();

        ContractList::insert([
            [ 'user_id' => 1, 'pricelist_id' => 2, 'created_at' => now(), 'updated_at' => now() ],
            [ 'user_id' => 11, 'pricelist_id' => 3, 'created_at' => now(), 'updated_at' => now() ],
        ]);
    }
}