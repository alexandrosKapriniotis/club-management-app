<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com'
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Alex',
            'email' => 'user@example.com'
        ]);
        $user->assignRole($userRole);
    }

}
