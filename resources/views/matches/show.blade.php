@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <h3 class="fs-3 fw-semibold mt-2">Match: {{ $match->homeTeam->name }} - {{ $match->awayTeam->name }}</h3>
    </div>
    <div class="p-3 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700">

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Date</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="w-100 form-control form-input form-input-bordered">
                    {{$match->date}}
                </p>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Time</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="form-control">{{$match->time}}</p>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Location</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="form-control">{{$match->location}}</p>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Home Team</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="form-control">{{$match->homeTeam->name}}</p>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Away Team</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="form-control">{{$match->awayTeam->name}}</p>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Home Team Score</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="form-control">{{$match->home_team_score}}</p>
            </div>
        </div>

        <div class="row g-3 align-items-center">
            <div class="col-md-4 col-sm-12 p-3">
                <p class="form-label fw-semibold">Away Team Score</p>
            </div>
            <div class="col-md-8 col-sm-12 p-3">
                <p class="form-control">{{$match->away_team_score}}</p>
            </div>
        </div>


        <div class="pt-5">
            <div class="d-flex justify-content-end">
                <a href="{{ route('matches.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection

