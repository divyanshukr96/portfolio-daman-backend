@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-outline-secondary btn-sm float-right" href="{{route('gallery')}}">Back</a>
        <h4>Trash</h4>
        <hr>
        @include('layouts.flashMessage')
        <div class="row gallery mt-3">
            @if(count($galleries) > 0)
                @foreach($galleries as $gallery)
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6 p-1 item border mb-1">
                        <a href="{{ route('image', ['image' => $gallery->name]) }}">
                            <img src="{{ route('image', ['image' => $gallery->name, 'p' => 'thumbnail']) }}" alt="">
                        </a>
                        <div class="p-1 m-1">
                            <form action="{{ route('gallery.restore', ['photo' => $gallery->id] ) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="material-icons">restore</i> Restore
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{ $galleries->links() }}
    </div>
@endsection
