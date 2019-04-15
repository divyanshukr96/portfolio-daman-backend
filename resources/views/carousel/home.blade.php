@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.flashMessage')
            <form class="col-md-6" action="{{ route('carousel') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="carousel" value="1">
                <div class="input-group mb-1" style="overflow: hidden">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" multiple id="photo" name="photo[]"
                               accept="image/*">
                        <label class="custom-file-label" for="photo">Choose Carousel photos</label>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->all()[0] }}
                        <button type="button" class="close small" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <button class="btn btn-info btn-block">Upload</button>
            </form>
        </div>
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
                            <form action="{{ route('carousel.remove', ['photo' => $cover->id] ) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <i class="material-icons">remove</i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <a class="btn bg-warning trash" href="{{ route('carousel.removed') }}">
            <i class="material-icons">remove</i> Removed</a>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
    </script>
@endsection
