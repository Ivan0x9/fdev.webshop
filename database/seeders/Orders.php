<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Orders extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('orders')->truncate();
        DB::table('order_items')->truncate();

        Order::factory()->count(1000)->create();
        OrderItem::factory()->count(5000)->create();
    }
}