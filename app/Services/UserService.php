<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = User::find($id);

        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user;
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $user = User::find($id);

        $user->delete();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return User::find($id);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email): mixed
    {
        return User::where('email',$email)->firstOrFail();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function storePlayer(array $data): mixed
    {
        $data['club_id']  = Auth::user()->club_id;
        $player = $this->store($data);

        $role = Role::findByName('user','web');

        $player->assignRole($role);

        return $player;
    }

    public function details(int $id)
    {
        return $this->find($id);
    }
}
