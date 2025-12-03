<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DapurSeeder::class,
            DetergenSeeder::class,
            ObatSeeder::class,
            RekomendasiSeeder::class,
        ]);
    }
}