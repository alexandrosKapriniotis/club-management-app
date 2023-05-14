<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'photo' => fake()->image('public/storage/players',400,300, null, false),
            'position' => fake()->randomElement(['CF', 'ST', 'RW', 'CB', 'GK']),
            'description' => fake()->text(),
            'user_id' => User::role('user')->inRandomOrder()->first()->id,
            'team_id' => Team::inRandomOrder()->first()->id
        ];
    }
}
