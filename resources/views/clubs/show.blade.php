@extends('layouts.app')

@section('content')
    <div class="mt-5">
        <h3 class="fs-3 fw-semibold mt-2">Club: {{ $club->name }}</h3>
    </div>
    <div class="p-3 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-700">

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <p class="form-label fw-semibold">Club name</p>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <p class="w-100 form-control form-input form-input-bordered">
                        {{$club->name}}
                    </p>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <p class="form-label fw-semibold">Description</p>
                </div>
                <div class="col-md-8 col-sm-12 p-3">
                    <p class="form-control">{{$club->description}}</p>
                </div>
            </div>

            <div class="row g-3 align-items-center">
                <div class="col-md-4 col-sm-12 p-3">
                    <p class="form-label fw-semibold">Logo</p>
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
                    </div>
                </div>
            </div>
        <div class="pt-5">
            <div class="d-flex justify-content-end">
                <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection

