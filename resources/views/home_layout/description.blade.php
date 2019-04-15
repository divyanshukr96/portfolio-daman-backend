@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                @if($layout)
                    <div class="layout0023"
                         style="background-image: url({{ route('image',['image' => $layout->photo ? $layout->photo->name : 'not-fond']) }})">
                    </div>
                @endif
            </div>
            <div class="col-lg-6 col-md-10 col-12 mt-3">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="input-group mb-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                            <label class="custom-file-label" for="photo">
                                {{ $layout && $layout->photo ? $layout->photo->name : 'Choose photos' }}
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="cover" value="1">
                    <div class="mb-2">
                        <textarea class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}"
                                  id="description" name="about" rows="6"
                                  placeholder="Description" required
                        >{{ old('about') ? old('about') : $layout ? $layout->about : '' }}</textarea>
                        <div class="invalid-feedback">
                            @if($errors->has('about'))
                                {{ $errors->first('about') }}
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('layout') }}" class="btn btn-info">Back</a>
                    <button class="btn btn-success float-right px-5">
                        {{ $layout ? 'Update' : 'Add' }}
                    </button>
                </form>
            </div>
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
