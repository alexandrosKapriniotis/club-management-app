<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Contracts\Role;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
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
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'club_id'   => Club::inRandomOrder()->first()->id
        ];
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return UserFactory
     */
    public function user(): UserFactory
    {
        return $this->assignRole('user');
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return UserFactory
     */
    public function admin(): UserFactory
    {
        return $this->assignRole('admin');
    }

    /**
     * @param array|Role|string  ...$roles
     * @return UserFactory
     */
    private function assignRole(...$roles): UserFactory
    {
        return $this->afterCreating(fn(User $user) => $user->syncRoles($roles));
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
