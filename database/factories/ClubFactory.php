<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends Factory<Club>
 */
class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filepath = public_path('storage/clubs');

        if(!File::exists($filepath)){
            File::makeDirectory($filepath);
        }

        return [
            'name' => fake()->name(),
            'logo' => fake()->image('public/storage/clubs',400,300, null, false),
            'description' => fake()->text()
        ];
    }
}
