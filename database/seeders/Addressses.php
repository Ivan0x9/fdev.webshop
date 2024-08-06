<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\AddressType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Addressses extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('addresses')->truncate();

        User::all()->each(function ($user) {
            Address::factory()->create([
                'user_id' => $user->id,
                'type' => AddressType::Billing->value,
            ]);
        });
        
        User::orderBy('id', 'desc')->take(5)->get()->each(function ($user) {
            Address::factory()->create([
                'user_id' => $user->id,
                'type' => AddressType::Shipping->value,
            ]);
        });
    }
}