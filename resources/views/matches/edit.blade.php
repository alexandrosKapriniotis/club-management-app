@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <h3 class="fs-3 fw-semibold mt-2">Edit match</h3>
    </div>
    <div class="mt-2 bg-white dark:bg-gray-800 rounded-lg shadow">
        <form action="{{ route('matches.update', $match->id) }}" method="POST" class="bg-white px-5 py-3">
            @csrf
            @method('PUT')
            @if ($errors->any())
                @include('partials.form-alert', ['messages' => $errors->all()])
            @endif
            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="date" class="form-label">Date</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="date" name="date" id="date" class="form-control" value="{{ Carbon\Carbon::create($match->date)->format('Y-m-d') }}">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="time" class="form-label">Time</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="time" name="time" id="time" class="form-control" value="{{ $match->time }}">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="location" class="form-label">Location</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="text" name="location" id="location" class="form-control" value="{{ $match->location }}">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="description" class="form-label">Home Team</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <select class="form-select" id="homeTeamSelect" aria-label="Select home team" name="home_team_id">
                        <option selected>Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{$team->id === $match->home_team_id? 'selected':''}}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="description" class="form-label">Away Team</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <select class="form-select" id="awayTeamSelect" aria-label="Select away team" name="away_team_id">
                        <option selected>Select Team</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{$team->id === $match->away_team_id? 'selected':''}}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="home_team_score" class="form-label">Home team score</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="number" name="home_team_score" id="home_team_score" class="form-control" value="{{ $match->home_team_score }}">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="away_team_score" class="form-label">Away team score</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="number" name="away_team_score" id="away_team_score" class="form-control" value="{{ $match->away_team_score }}">
                </div>
            </div>
            <div class="pt-5">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('matches.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

