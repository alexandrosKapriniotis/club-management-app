@extends('layouts.app')

@section('content')
    @role('admin')
    <div class="page-header d-flex mt-5">
        <div class="page-title col-8">
            <h4>Teams List</h4>
            <h6>Manage your teams</h6>
        </div>
        <div class="page-btn col-4 text-end">
            <a href="{{ route('teams.create') }}" class="btn btn-added btn-primary">
                <i class="bi bi-plus-lg"></i>
                Add New Team
            </a>
        </div>
    </div>
    @endrole
    <div class="table-responsive">
        <div class="table-wrapper">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @if (isset($teams) && count($teams) > 0)
                        @foreach ($teams as $team)
                            <tr>
                                <td>
                                    @if($team->logo)
                                        <img class="logo mx-auto" src="{{ $team->logoUrl}}" alt="team logo" />
                                    @else
                                        <div class=""></div>
                                    @endif
                                </td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->description }}</td>
                                <td>
                                    <div class="d-flex h-100 justify-content-center">
                                        <a href="{{ route('teams.show', $team->id) }}" class="show">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @role('admin')
                                        <a href="{{ route('teams.edit', $team->id) }}" class="edit" data-toggle="modal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <a data-url="{{ route('teams.destroy', $team) }}" data-bs-target="#deleteRecordModal" class="delete delete-btn" data-toggle="modal">
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
                    {{$teams->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('partials.delete-modal')
@endsection
