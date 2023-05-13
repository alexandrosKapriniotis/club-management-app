@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <h3 class="fs-3 fw-semibold mt-2">Create club</h3>
    </div>
    <div class="mt-2 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700">
        <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white px-5 py-3 border-gray-100 border-2 rounded-lg">
            @csrf

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="name" class="form-label">Club name</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="description" class="form-label">Description</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <textarea class="form-control" name="description" id="description"></textarea>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <label for="cover-photo" class="form-label">Logo</label>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <div class="mt-1 text-center preview-image" id="image-preview">
                        <svg class="mx-auto h-25 w-25 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium">
                                <span>Upload a file</span>
                                <input id="image" name="logo" type="file" class="form-control sr-only">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                @include('partials.form-alert', ['messages' => $errors->all()])
            @endif
            <div class="pt-5">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('clubs.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection

