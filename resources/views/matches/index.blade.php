@extends('layouts.app')

@section('content')
    @role('admin')
    <div class="page-header d-flex mt-5">
        <div class="page-title col-8">
            <h4>Matches List</h4>
            <h6>Manage your matches</h6>
        </div>
        <div class="page-btn col-4 text-end">
            <a href="{{ route('matches.create') }}" class="btn btn-added btn-primary">
                <i class="bi bi-plus-lg"></i>
                Add New Match
            </a>
        </div>
    </div>
    @endrole
    <div class="table-responsive">
        <div class="table-wrapper">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($matches) && count($matches) > 0)
                    @foreach ($matches as $match)
                        <tr>
                            <td>{{ Carbon\Carbon::create($match->date)->format('d-m-Y') }}</td>
                            <td>{{ $match->time }}</td>
                            <td>{{ $match->location }}</td>
                            <td>{{ $match->homeTeam->name }}</td>
                            <td>{{ $match->awayTeam->name }}</td>
                            <td>{{ $match->home_team_score }} - {{ $match->away_team_score }}</td>
                            <td>
                                <div class="d-flex h-100 justify-content-center">
                                    <a href="{{ route('matches.show', $match->id) }}" class="show">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @role('admin')
                                    <a href="{{ route('matches.edit', $match->id) }}" class="edit" data-toggle="modal">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a data-url="{{ route('matches.destroy', $match) }}" data-bs-target="#deleteRecordModal" data-bs-toggle="modal" class="delete delete-btn">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No entries</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="clearfix">
                <div class="flex-1 px-2">
                    {{$matches->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('partials.delete-modal')
@endsection
