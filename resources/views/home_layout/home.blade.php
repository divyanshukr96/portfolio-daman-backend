@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(isset($cover) && $cover)
                    <div class="layout0023"
                         style="background-image: url({{ route('image', ['image' => $cover->photo ? $cover->photo->name : 'not-fount']) }})">
                        <div class="text-center p-3 text-white">
                            {{ $cover->about }}
                            <a href="{{ route('layout.description') }}"
                               class="btn btn-success float-right btn-sm px-3">Edit</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('layout.description') }}"
                       class="btn btn-success float-right btn-sm px-3">Add New</a>
                @endif
            </div>

            <div class="col-md-6 col-12 offset-md-3 cl mt-3">
                <a href="{{ route('layout.create') }}" class="btn btn-success btn-block">Add New</a>
            </div>
            <div class="col-12">
                @include('layouts.post')
            </div>

            <div class="col-12"></div>
        </div>
        <a class="btn bg-danger trash" href="{{ route('layout.trash') }}">
            <i class="material-icons">delete</i> Deleted</a>
    </div>
@endsection
