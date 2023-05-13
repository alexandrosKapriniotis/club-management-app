@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <h3 class="fs-3 fw-semibold mt-2">Edit club</h3>
    </div>
    <div class="mt-2 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700">
        <form action="{{ route('clubs.update', $club->id) }}" method="POST" enctype="multipart/form-data" class="p-5">
            @csrf
            @method('PUT')
            @if ($errors->any())
                @include('partials.form-alert', ['messages' => $errors->all()])
            @endif
            <div class="row g-3 align-items-center">
                    <div class="col-md-4 col-sm-12 p-3">
                        <label for="name" class="form-label fw-semibold">Club name</label>
                        <span class="text-danger fs-8">*</span>
                    </div>
                    <div class="col-md-8 col-sm-12 p-3">
                        <input type="text" name="name" id="name" value="{{$club->name}}" class="w-100 form-control form-input form-input-bordered">
                    </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <textarea name="description" id="description" class="form-control" rows="3">{{$club->description}}</textarea>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="cover-photo" class="form-label fw-semibold">Logo</label>
                    <span class="text-danger fs-8">*</span>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <div class="mt-1 text-center" id="image-preview">
                        @if($club->logo)
                            <div id="preview-image" class="preview-image">
                                <img src="{{ $club->logoUrl }}" class="img-thumbnail" alt="{{ $club->logo }}">
                            </div>
                        @else
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                        <div class="text-sm-start">
                            <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span class="py-2">Upload a file (PNG, JPG, GIF up to 10MB)</span>
                                <input id="logo" name="logo" type="file" class="form-control sr-only">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-5">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('clubs.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-success rounded">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection

