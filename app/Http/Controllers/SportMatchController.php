<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchSportMatchRequest;
use App\Models\SportMatch;
use App\Http\Requests\StoreSportMatchRequest;
use App\Http\Requests\UpdateSportMatchRequest;
use App\Services\SportMatchService;
use App\Services\TeamService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class SportMatchController extends Controller
{
    private SportMatchService $service;
    private TeamService $teamService;
    public function __construct(SportMatchService $service, TeamService $teamService)
    {
        $this->authorizeResource(SportMatch::class, 'match');
        $this->service = $service;
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchSportMatchRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = $request->validated();

        $matches = $this->service->search($data);

        return view('matches.index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $teams = $this->teamService->list();

        return view('matches.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSportMatchRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->service->store($data);

        return redirect()->route('matches.index')
            ->with(['message' => ['status' => 'success','message' => 'Match created successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SportMatch $match): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('matches.show',compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SportMatch $match): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $teams = $this->teamService->list();

        return view('matches.edit',compact('match', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSportMatchRequest $request, SportMatch $match): RedirectResponse
    {
        $data = $request->validated();
        $this->service->update($match, $data);

        return redirect()->route('matches.index')
            ->with(['message' => ['status' => 'success','message' => 'Match updated successfully']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SportMatch $match): RedirectResponse
    {
        $this->service->delete($match);

        return redirect()->route('matches.index')
            ->with(['message' => ['status' => 'success','message' => 'Match deleted successfully']]);
    }
}
