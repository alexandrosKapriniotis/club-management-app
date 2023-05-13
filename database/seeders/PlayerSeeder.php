<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Creating a couple of players for each team */
        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 1]);
        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 1]);

        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 2]);
        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 2]);

        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 3]);
        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 3]);

        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 4]);
        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 4]);

        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 5]);
        Player::factory()->for(User::factory()->user()->create())->create(['team_id' => 5]);
    }
}
