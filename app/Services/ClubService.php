<?php

namespace App\Services;

use App\Models\Club;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClubService
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
        $query = Club::query();

        if (array_key_exists('user_id', $data)) {
            $query->where('user_id',$data['user_id']);
        }

        if (array_key_exists('q', $data))
        {
            $query->where('name','like','%' . $data['q'] . '%');
        }

        return $query;
    }

    public function store(array $data)
    {
        $data['logo'] = $this->fileService->savePicture($data['logo'],Club::STORAGE_DIR,Club::IMAGE_WIDTH);

        return Club::create($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return Club::find($id);
    }

    /**
     * @param int $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function details(int $id)
    {
        return Club::with(['teams'])->find($id);
    }


    /**
     * @param Club $club
     * @param array $data
     * @return Club
     */
    public function update(Club $club, array $data): Club
    {
        $data = array_filter($data);

        if (array_key_exists('logo', $data)) {
            $this->fileService->deleteFile($club->logo,Club::STORAGE_DIR);
            $data['logo'] = $this->fileService->savePicture($data['logo'],Club::STORAGE_DIR,Club::IMAGE_WIDTH);
        }

        $club->update($data);

        return $club;
    }

    /**
     * @param Club $club
     * @return void
     */
    public function delete(Club $club): void
    {
        $this->fileService->deleteFile($club->logo,Club::STORAGE_DIR);
        $club->delete();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $query = $this->searchQuery($data);

        $sortDesc = $data['sortDesc'] ?? null;
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:2;

        $query->withCount(['teams']);

        $query->orderBy('name',$sortDesc?'desc':'asc');

        return $query->where('user_id', Auth::user()->id)->latest()->paginate($perPage);
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
