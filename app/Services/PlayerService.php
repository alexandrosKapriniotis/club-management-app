<?php

namespace App\Services;

use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PlayerService
{
    private FileService $fileService;
    private UserService $userService;

    public function __construct(FileService $fileService, UserService $userService)
    {
        $this->fileService = $fileService;
        $this->userService = $userService;
    }

    private function searchQuery(array $data)
    {
        $sortDesc = $data['sortDesc'] ?? null;

        $query = Player::select('players.*');

        if (array_key_exists('q', $data))
        {
            $query->whereHas('user',  function($sub) use ($data) {
                $sub->where('name','like','%' . $data['q'] . '%');
            });
        }

        if (array_key_exists('sortBy', $data)) {
            if ($data['sortBy'] === 'name') {
                $query->join('users', 'users.id', '=', 'players.user_id');
                $query->orderBy('users.name', $sortDesc?'desc':'asc');
            }
            if ($data['sortBy'] === 'score')
            {
                $query->withSum('challenges','points');
                $query->orderBy('challenges_sum_points', $sortDesc?'desc':'asc');
            }
        }

        if (array_key_exists('parent_id', $data))
        {
            $query->where('parent_id', $data['parent_id']);
        }

        return $query;
    }

    public function search(array $data)
    {
        $query = $this->searchQuery($data);

        $perPage = array_key_exists('perPage',$data)?$data['perPage']:5;

        if (auth()->guard('web')->check()) {
            $query->with(['user','team', 'team.club']);
        }

        return $query->whereHas('team.club', function ($query) {
                $query->where('id', Auth::user()->id);
        })->latest()->paginate($perPage);
    }

    public function store(array $data)
    {
        if (array_key_exists('photo', $data)) {
            $data['photo'] = $this->fileService->savePicture($data['photo'], Player::STORAGE_DIR, 400);
        }
        $data['user']['name'] = $data['name'];
        $user = $this->userService->storePlayer($data['user']);

        $data['user_id'] = $user->getKey();

        return Player::create($data);
    }

    public function find(int $id)
    {
        $player = Player::find($id);

        return $player;
    }

    public function update(int $id, array $data)
    {
        $data = array_filter($data);

        $player = Player::find($id);

        if (array_key_exists('photo', $data)) {
            $this->fileService->deleteFile($player->photo,Player::STORAGE_DIR);
            $data['photo'] = $this->fileService->savePicture($data['photo'],Player::STORAGE_DIR,400);
        }
        if (array_key_exists('password', $data['user'])) {
            $data['user']['password'] = Hash::make($data['user']['password']);
        }
        $player->user()->update($data['user']);

        $player->update($data);

        return $player;
    }

    public function delete(int $id)
    {
        $player = Player::find($id);

        $this->userService->delete($player->user_id);

        $player->delete();
    }
}
