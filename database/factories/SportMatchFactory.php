<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\SportMatch;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SportMatch>
 */
class SportMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-2 months', '+2 months')->format('Y-m-d'),
            'time' => $this->faker->time,
            'location' => $this->faker->streetName,
            'home_team_id' => Team::inRandomOrder()->first()->id,
            'away_team_id' => Team::inRandomOrder()->first()->id,
            'home_team_score' => $this->faker->randomDigitNotNull(),
            'away_team_score' => $this->faker->randomDigitNotNull(),
            'club_id'         => Club::inRandomOrder()->first()->id,
        ];
    }
}
