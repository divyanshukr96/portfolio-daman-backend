@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-outline-secondary btn-sm float-right" href="{{route('carousel')}}">Back</a>
        <h4>Carousel Removed</h4>
        <hr>
        <div class="row gallery mt-3">
            @if(isset($covers) && count($covers) > 0)
                @foreach($covers as $cover)
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6 p-1 item border mb-1">
                        <a href="{{ route('image', ['image' => $cover->name]) }}">
                            <img src="{{ route('image', ['image' => $cover->name, 'p' => 'thumbnail']) }}" alt="">
                        </a>
                        <div class="p-1 m-1">

                            <form action="{{ route('gallery.destroy', ['photo' => $cover->id] ) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm float-right">
                                    <i class="material-icons">delete</i> Trash
                                </button>
                            </form>
                            <form action="{{ route('carousel.restore', ['photo' => $cover->id] ) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="material-icons">restore</i> restore
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 alert alert-warning">
                    Trashed Carousel empty !!
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
    </script>
@endsection
