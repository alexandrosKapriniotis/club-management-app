@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <h3 class="fs-3 fw-semibold mt-2">Edit player</h3>
    </div>
    <div class="mt-2 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700">
        <form action="{{ route('players.update', $player->id) }}" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf
            @method('PUT')
            @if ($errors->any())
                @include('partials.form-alert', ['messages' => $errors->all()])
            @endif
            <input type="hidden" name="user_id" value="{{$player->user_id}}">
            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <span class="text-danger fs-8">*</span>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="text" name="name" id="name" value="{{$player->name}}" class="w-100 form-control form-input form-input-bordered">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <textarea name="description" id="description" class="form-control" rows="3">{{$player->description}}</textarea>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="position" class="form-label fw-semibold">Position</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="text" name="position" id="position" class="form-control" value="{{$player->position}}">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="description" class="form-label">Team</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <select class="form-select" id="teamSelect" aria-label="Select team" name="team_id">
                        <option>Assign to team</option>
                        @foreach($teams as $team)
                            <option value="{{$team->id}}" {{$team->id === $player->team_id? 'selected':''}}>{{$team->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="email" class="form-label">Email</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="email" name="user[email]" id="email" class="form-control" value="{{$player->user?->email}}">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="password" class="form-label">Password</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="password" name="user[password]" id="password" class="form-control" autocomplete="off">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="password_confirmation" class="form-label">Repeat Password</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="password" name="user[password_confirmation]" id="password_confirmation" class="form-control" autocomplete="off">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="cover-photo" class="form-label fw-semibold">Logo</label>
                    <span class="text-danger fs-8">*</span>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <div class="mt-1 text-center preview-image" id="image-preview">
                        @if($player->photo)
                            <div id="preview-image">
                                <img src="{{ $player->photoUrl }}" class="img-thumbnail" alt="{{ $player->photo }}">
                            </div>
                        @else
                            <svg class="mx-auto h-25 w-25 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                        <div class="text-sm-start">
                            <label for="image" class="relative cursor-pointer bg-white rounded fw-semibold">
                                <span class="py-2">Upload a file (PNG, JPG, GIF up to 10MB)</span>
                                <input id="image" name="photo" type="file" class="form-control sr-only">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-5">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('players.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-success rounded">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection

