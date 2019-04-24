@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-md-6" action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-1" style="overflow: hidden">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" multiple id="photo" name="photo[]"
                               accept="image/*">
                        <label class="custom-file-label" for="photo">Choose photos</label>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="category" class="d-none"></label>
                    <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" id="category"
                            name="category">
                        <option disabled selected>Select Category</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <option
                                    {{$category->value == old('category') ? 'selected' : null}}
                                    value="{{$category->value}}">{{$category->name}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('category'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                    @endif
                </div>
                <button class="btn btn-info btn-block">Upload</button>
            </form>
        </div>
        <hr>
        @include('layouts.flashMessage')
        <a href="{{ route('gallery') }}" class="btn btn{{ $selected !== 'all' ? '-outline' : '' }}-primary px-3">All
            Images</a>
        @if(isset($categories) && count($categories) > 0)
            @foreach($categories as $category)
                <a href="{{ route('gallery.category', ['category' => $category->value]) }}"
                   class="btn btn{{ $selected !== $category->value ? '-outline' : '' }}-primary px-3">
                    {{ $category->name }}
                </a>
            @endforeach
        @endif
        <div class="row gallery my-3 justify-content-center">
            @if(count($galleries) > 0)
                @foreach($galleries as $gallery)
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6 p-1 item border mb-1">
                        <a href="{{ route('image', ['image' => $gallery->name]) }}">
                            <img src="{{ route('image', ['image' => $gallery->name, 'p' => 'thumbnail']) }}" alt="">
                        </a>
                        <div class="p-1 m-1">
                            <form action="{{ route('gallery.destroy', ['photo' => $gallery->id] ) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="material-icons">delete</i> Trash
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning" style="width: 100%" role="alert">
                    No any Images found in this Category !!.
                </div>
            @endif
        </div>
        {{ $galleries->links() }}
        <a class="btn bg-danger trash" href="{{ route('gallery.trash') }}">
            <i class="material-icons">delete</i> Deleted</a>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
    </script>
@endsection
