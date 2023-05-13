<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchPlayerRequest;
use App\Models\Player;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Services\PlayerService;
use App\Services\TeamService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    private PlayerService $service;
    private TeamService $teamService;

    public function __construct(PlayerService $service, TeamService $teamService)
    {
        $this->authorizeResource(Player::class, 'player');
        $this->service = $service;
        $this->teamService = $teamService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchPlayerRequest $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $players = $this->service->search($request->validated());

        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = isset(Auth::user()->club->id) ? ['club_id' => Auth::user()->club->id] : [];
        $teams = $this->teamService->list($data);

        return view('players.create', compact( 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->service->store($data);

        return redirect()->route('players.index')
            ->with(['message' => ['status' => 'success','message' => 'Player created successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = isset(Auth::user()->club->id) ? ['club_id' => Auth::user()->club->id] : [];
        $teams = $this->teamService->list($data);

        return view('players.edit', compact('player', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, Player $player): RedirectResponse
    {
        $this->service->update($player->id, $request->validated());

        return redirect()->route('players.index')
            ->with(['message' => ['status' => 'success','message' => 'Player updated successfully']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player): RedirectResponse
    {
        $this->service->delete($player->id);

        return redirect()->route('players.index')
            ->with(['message' => ['status' => 'success','message' => 'Player deleted successfully']]);
    }
}
