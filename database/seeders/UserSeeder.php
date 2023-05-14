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
        User::factory()->admin()->create([
            'name' => 'Club owner 1',
            'email' => 'admin@example.com',
            'club_id' => 1
        ]);
        User::factory()->admin()->create([
            'name' => 'Club owner 2',
            'email' => 'admin2@example.com',
            'club_id' => 2
        ]);
        User::factory()->admin()->create([
            'name' => 'Club owner 3',
            'email' => 'admin3@example.com',
            'club_id' => 3
        ]);
        User::factory()->admin()->create([
            'name' => 'Club owner 4',
            'email' => 'admin4@example.com',
            'club_id' => 4
        ]);
        User::factory()->admin()->create([
            'name' => 'Club owner 5',
            'email' => 'admin5@example.com',
            'club_id' => 5
        ]);
        User::factory()->admin()->create([
            'name' => 'Alex',
            'email' => 'user@example.com'
        ]);
        User::factory(50)->user()->create();
    }

}
