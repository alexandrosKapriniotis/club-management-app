<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $user = User::factory()->create([
            'name' => 'Club owner 1',
            'email' => 'admin@example.com'
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Club owner 2',
            'email' => 'admin2@example.com'
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Club owner 3',
            'email' => 'admin3@example.com'
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Club owner 4',
            'email' => 'admin4@example.com'
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Club owner 5',
            'email' => 'admin5@example.com'
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Alex',
            'email' => 'user@example.com'
        ]);
        $user->assignRole($userRole);
    }
}
