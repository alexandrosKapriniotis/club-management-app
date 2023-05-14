<?php

namespace App\Http\Controllers;

use App\Services\SportMatchService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private SportMatchService $sportMatchService;
    public function __construct(SportMatchService $sportMatchService)
    {
        $this->sportMatchService = $sportMatchService;
    }

    /**
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $matches = $this->sportMatchService->calendarList();
        $nextMatch = $this->sportMatchService->nextMatch();
        $matchStatistics = $this->sportMatchService->matchStatistics();

        return view('dashboard', compact('matches','nextMatch', 'matchStatistics'));
    }
}
