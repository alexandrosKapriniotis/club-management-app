<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::factory()->create(['user_id' => 1]);
        Club::factory()->create(['user_id' => 2]);
        Club::factory()->create(['user_id' => 3]);
        Club::factory()->create(['user_id' => 4]);
        Club::factory()->create(['user_id' => 5]);
    }
}
