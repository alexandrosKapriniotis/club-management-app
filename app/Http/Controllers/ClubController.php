<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchClubRequest;
use App\Models\Club;
use App\Http\Requests\StoreClubRequest;
use App\Http\Requests\UpdateClubRequest;
use App\Models\Team;
use App\Services\ClubService;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ClubController extends Controller
{
    private ClubService $service;
    private UserService $userService;

    public function __construct(ClubService $service, UserService $userService)
    {
        $this->authorizeResource(Club::class, 'club');
        $this->service = $service;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchClubRequest $request)
    {
        $data = $request->validated();
        $clubs = $this->service->search($data);

        return view('clubs.index', compact('clubs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClubRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return redirect()->route('clubs.index')
            ->with(['message' => ['status' => 'success','message' => 'Club created successfully']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        return view('clubs.show',compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        return view('clubs.edit',compact('club'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClubRequest $request, Club $club)
    {
        $data = $request->validated();
        $this->service->update($club, $data);

        return redirect()->route('clubs.index')
            ->with(['message' => ['status' => 'success','message' => 'Club updated successfully']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        $this->service->delete($club);

        return redirect()->route('clubs.index')
            ->with(['message' => ['status' => 'success','message' => 'Club deleted successfully']]);
    }
}
