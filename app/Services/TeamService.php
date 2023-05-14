<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TeamService
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param array $data
     * @return Builder
     */
    private function searchQuery(array $data): Builder
    {
        $query = Team::query();

        if (array_key_exists('club_id', $data)) {
            $query->where('club_id', $data['club_id']);
        }

        if (array_key_exists('q', $data))
        {
            $query->where('name','like','%' . $data['q'] . '%');
        }

        return $query;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $query = $this->searchQuery($data);

        $sortDesc = $data['sortDesc'] ?? null;
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:5;


        if (auth()->guard('web')->check()) {
            $query->with('club');
        }

        $query->orderBy('name',$sortDesc?'desc':'asc');

        return $query->where('club_id', Auth::user()->club_id)->latest()->paginate($perPage);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        if (isset($data['logo'])) {
            $data['logo'] = $this->fileService->savePicture($data['logo'],Team::STORAGE_DIR,400);
        }

        $data['club_id'] = Auth::user()->club_id;

        return Team::create($data);
    }

    /**
     * @param int $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function details(int $id): Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null
    {
        return Team::with(['players'])->find($id);
    }

    /**
     * @param Team $team
     * @param array $data
     * @return Team
     */
    public function update(Team $team, array $data): Team
    {
        $data = array_filter($data);

        if (array_key_exists('logo', $data)) {
            $this->fileService->deleteFile($team->logo,Team::STORAGE_DIR);
            $data['logo'] = $this->fileService->savePicture($data['logo'],Team::STORAGE_DIR,400);
        }
        $team->update($data);

        return $team;
    }

    /**
     * @param Team $team
     * @return void
     */
    public function delete(Team $team): void
    {
        $this->fileService->deleteFile($team->logo,Team::STORAGE_DIR);

        $team->delete();
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function list(array $data = []): Collection
    {
        $query = $this->searchQuery($data);

        return $query->get(['id','name']);
    }
}
