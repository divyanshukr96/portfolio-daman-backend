@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-10 offset-md-1 offset-lg-3 col-12 mb-3">
                <form method="post" action="{{ route('layout') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                               id="title" name="title" value="{{ old('title')}}" placeholder="Enter Title" required>
                        <div class="invalid-feedback">
                            @if($errors->has('title'))
                                {{ $errors->first('title') }}
                            @endif
                        </div>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}"
                                  id="description" name="about" rows="6"
                                  placeholder="Enter Description" required
                        >{{ old('about')}}</textarea>
                        <div class="invalid-feedback">
                            @if($errors->has('about'))
                                {{ $errors->first('about') }}
                            @endif
                        </div>
                    </div>
                    <div class="input-group mb-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input {{ $errors->has('about') ? 'is-invalid' : '' }}"
                                   id="photo" name="photo" accept="image/*">
                            <label class="custom-file-label" for="photo">Choose photos</label>
                        </div>
                        <div class="invalid-feedback" style="display: block">
                            @if($errors->has('photo'))
                                {{ $errors->first('photo') }}
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('layout') }}" class="btn btn-info">Back</a>
                    <button class="btn btn-success float-right px-5">Add</button>
                </form>
            </div>
            <div class="col-12">
                @include('layouts.post')
            </div>
        </div>
        <a class="btn bg-danger trash" href="{{ route('layout.trash') }}">
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
