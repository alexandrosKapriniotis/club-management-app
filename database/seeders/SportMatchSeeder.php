<?php

namespace Database\Seeders;

use App\Models\SportMatch;
use Illuminate\Database\Seeder;

class SportMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SportMatch::factory(50)->create();
    }
}
