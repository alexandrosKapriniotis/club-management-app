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
        Player::factory(50)->create();
    }
}
