@extends('layouts.app')

@section('content')
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
                    @if (isset($clubs) && count($clubs) > 0)
                        @foreach ($clubs as $club)
                            <tr>
                                <td>
                                    @if($club->logo)
                                        <img class="logo mx-auto" src="{{ $club->logoUrl}}" alt="club logo" />
                                    @else
                                        <div class=""></div>
                                    @endif
                                </td>
                                <td>{{ $club->name }}</td>
                                <td>{{ $club->description }}</td>
                                <td>
                                    <div class="d-flex h-100">
                                        <a href="{{ route('clubs.show', $club->id) }}" class="show">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('clubs.edit', $club->id) }}" class="edit" data-toggle="modal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a data-url="{{ route('clubs.destroy', $club) }}" data-bs-target="#deleteRecordModal" data-bs-toggle="modal" class="delete delete-btn">
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
                    {{$clubs->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('partials.delete-modal')
@endsection
