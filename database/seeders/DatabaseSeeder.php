<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClubSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            TeamSeeder::class,
            PlayerSeeder::class,
            SportMatchSeeder::class
        ]);
    }
}
