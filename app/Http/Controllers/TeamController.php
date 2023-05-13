<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTeamRequest;
use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Services\ClubService;
use App\Services\TeamService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    private TeamService $service;
    private ClubService $clubService;
    private UserService $userService;

    public function __construct(TeamService $service, ClubService $clubService, UserService $userService)
    {
        $this->authorizeResource(Team::class, 'team');
        $this->service = $service;
        $this->clubService = $clubService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchTeamRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = $request->validated();

        $teams = $this->service->search($data);

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->service->store($data);

        return redirect()->route('teams.index')
            ->with(['message' => ['status' => 'success','message' => 'Team created successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('teams.show',compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('teams.edit',compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $data = $request->validated();
        $this->service->update($team, $data);

        return redirect()->route('teams.index')
            ->with(['message' => ['status' => 'success','message' => 'Team updated successfully']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team): RedirectResponse
    {
        $this->service->delete($team);

        return redirect()->route('teams.index')
            ->with(['message' => ['status' => 'success','message' => 'Team deleted successfully']]);
    }
}
