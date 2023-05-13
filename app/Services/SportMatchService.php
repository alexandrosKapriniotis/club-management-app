<?php

namespace App\Services;


use App\Models\SportMatch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SportMatchService
{
    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        $data['club_id'] = Auth::user()->club->id;
        return SportMatch::create($data);
    }

    /**
     * @param SportMatch $match
     * @param array $data
     * @return SportMatch
     */
    public function update(SportMatch $match, array $data): SportMatch
    {
        $data = array_filter($data);
        $data['club_id'] = Auth::user()->club->id;
        $match->update($data);

        return $match;
    }

    /**
     * @param SportMatch $match
     * @return void
     */
    public function delete(SportMatch $match): void
    {
        $match->delete();
    }

    /**
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function details(int $id): Model|Collection|Builder|array|null
    {
        return SportMatch::find($id);
    }

    /**
     * @param array $data
     * @return Builder
     */
    private function searchQuery(array $data): Builder
    {
        $query = SportMatch::query();

        if (array_key_exists('club_id', $data)) {
            $query->where('club_id', $data['club_id']);
        }

        if (array_key_exists('q', $data))
        {
            $query->where('location','like','%' . $data['q'] . '%')
                ->orWhere('home_team','like','%' . $data['q'] . '%')
                ->orWhere('away_team','like','%' . $data['q'] . '%');
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

        $query->orderBy('location',$sortDesc?'desc':'asc');

        return $query->whereHas('club', function ($query) {
            return $query->where('user_id', Auth::user()->id);
        })->latest()->paginate($perPage);
    }
}
