<?php

namespace App\Services;


use App\Models\SportMatch;
use Carbon\Carbon;
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

        return $query->where('club_id', Auth::user()->club_id)->latest()->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function list(array $data = []): Collection
    {
        $query = $this->searchQuery($data);

        return $query->get();
    }

    /**
     * @return array
     */
    public function calendarList(): array
    {
        $calendarMatches = [];
        $matches = $this->list();

        foreach ($matches as $match) {
            $matchTime = Carbon::createFromFormat('H:i:s', $match->time);
            $start     = $match->date->addHours($matchTime->hour)->addMinutes($matchTime->minute);
            $end       = $start->copy()->addMinutes(90);

            $calendarMatches[] = [
                'title' => $match->homeTeam->name . ' - '.$match->awayTeam->name,
                'start' => $start,
                'end' => $end,
            ];
        }

        return $calendarMatches;
    }

    /**
     * @return mixed
     */
    public function nextMatch(): mixed
    {
        return SportMatch::where('club_id', Auth::user()->club_id)
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'DESC')->first();
    }

    /**
     * @return mixed
     */
    public function homeMatches(): mixed
    {
        return SportMatch::where('club_id', Auth::user()->club_id)->whereHas('homeTeam', function ($query) {
            return $query->whereIn('id', Auth::user()->club->teams()->pluck('id'));
        })->count();
    }

    /**
     * @return mixed
     */
    public function homeVictories(): mixed
    {
        $query = $this->searchQuery([]);

        return $query->whereHas('homeTeam', function ($query) {
            return $query->whereIn('id', Auth::user()->club->teams()->pluck('id'));
        })->where('home_team_score', '>', 'away_team_score')->count();
    }

    /**
     * @return mixed
     */
    public function awayMatches(): mixed
    {
        return SportMatch::where('club_id', Auth::user()->club_id)->whereHas('awayTeam', function ($query) {
            return $query->whereIn('id', Auth::user()->club->teams()->pluck('id'));
        })->count();
    }

    /**
     * @return mixed
     */
    public function awayVictories(): mixed
    {
        $query = $this->searchQuery([]);

        return $query->whereHas('awayTeam', function ($query) {
            return $query->whereIn('id', Auth::user()->club->teams()->pluck('id'));
        })->where('away_team_score', '>', 'home_team_score')->count();
    }

    /**
     * @return mixed
     */
    public function totalVictories(): mixed
    {
        return $this->homeVictories() + $this->awayVictories();
    }

    /**
     * @return array
     */
    public function matchStatistics(): array
    {
        return [
            'home_matches' => $this->homeMatches(),
            'away_matches' => $this->awayMatches(),
            'home_victories' => $this->homeVictories(),
            'away_victories' => $this->awayVictories()
        ];
    }
}
