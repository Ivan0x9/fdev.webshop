<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Database seeders
         */
        $this->call(Countries::class);

        /**
         * Model factories
         */
        \App\Models\User::factory(10)->create();
    }
}
