<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::factory()->create(['club_id' => 1]);
        Team::factory()->create(['club_id' => 2]);
        Team::factory()->create(['club_id' => 3]);
        Team::factory()->create(['club_id' => 4]);
        Team::factory()->create(['club_id' => 5]);
    }
}
