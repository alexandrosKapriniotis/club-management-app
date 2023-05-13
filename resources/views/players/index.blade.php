@extends('layouts.app')

@section('content')
    <div class="page-header d-flex mt-5">
        <div class="page-title col-8">
            <h4>Players List</h4>
            <h6>Manage your players</h6>
        </div>
        <div class="page-btn col-4 text-end">
            <a href="{{ route('players.create') }}" class="btn btn-added btn-primary">
                <i class="bi bi-plus-lg"></i>
                Add New Player
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <div class="table-wrapper">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($players) && count($players) > 0)
                    @foreach ($players as $player)
                        <tr>
                            <td>
                                @if($player->photo)
                                    <img class="logo mx-auto" src="{{ $player->photoUrl}}" alt="player photo" />
                                @else
                                    <div class=""></div>
                                @endif
                            </td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->position }}</td>
                            <td>{{ $player->description }}</td>
                            <td>
                                <div class="d-flex h-100">
                                    <a href="{{ route('players.show', $player->id) }}" class="show">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('players.edit', $player->id) }}" class="edit" data-toggle="modal">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a data-url="{{ route('players.destroy', $player) }}" data-bs-target="#deleteRecordModal" data-bs-toggle="modal" class="delete delete-btn">
                                        <i class="bi bi-trash"></i>
                                    </a>
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
                    {{$players->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('partials.delete-modal')
@endsection
