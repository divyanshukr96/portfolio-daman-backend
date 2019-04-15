@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ $data->title }}
                    </div>
                    <div class="card-body">
                        @if($data)
                            <div class="mb-2 text-center">
                                @if($data->photo)
                                    <img src="{{ route('image', ['image' => $data->photo->name]) }}" alt=""
                                         style="max-width: 450px; width: 100%;">
                                @else
                                    <form action="{{ route('description.photo', ['id' => $data->id] ) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-info">
                                            <i class="material-icons" style="vertical-align: bottom;">restore</i> Restore Image
                                        </button>
                                    </form>
                                @endif
                            </div>
                            {!! nl2br(e($data->description)) !!}

                            <blockquote class="blockquote my-2">
                                <footer class="blockquote-footer">{{ $data->created_at }}</footer>
                            </blockquote>
                        @else
                            <span class="text-danger">Description not available</span>
                        @endif

                    </div>
                    <div class="card-footer">
                        {{--<form action="{{ route('description.restore', ['description' => $data->id]) }}"--}}
                        {{--method="POST">--}}
                        {{--@csrf--}}
                        {{--@method('PATCH')--}}
                        {{--<button type="submit" class="btn btn-warning btn-sm float-right">--}}
                        {{--Restore--}}
                        {{--</button>--}}
                        {{--</form>--}}
                        Deleted at - {{ $data->deleted_at }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
