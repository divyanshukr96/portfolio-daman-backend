@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="row mb-3">
            <form class="col-md-6" action="{{ route('description.store') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="mb-1">
                    <label for="description">New description</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              id="description" name="description"
                              placeholder="Description" required>{{ old('description') }}</textarea>
                    <div class="invalid-feedback">
                        @if($errors->has('description'))
                            {{ $errors->first('description') }}
                        @endif
                    </div>
                </div>
                <div class="input-group mb-1" style="overflow: hidden">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="photo" name="photo"
                               accept="image/*">
                        <label class="custom-file-label" for="photo">Select image</label>
                    </div>
                </div>
                <button class="btn btn-info px-5 float-right">Add</button>
            </form>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Current Description
                    </div>
                    <div class="card-body">
                        @if($data)
                            <img src="{{ route('image',['image'=>$data->photo->name]) }}" alt=""
                                 style="width: 350px; max-width: 100%">
                            <p class="pt-2">
                                {!! nl2br(e($data->description)) !!}
                            </p>
                            <form action="{{ route('description.destroy', ['description' => $data->id]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger float-right">
                                    Delete
                                </button>
                            </form>
                            <blockquote class="blockquote my-2">
                                <footer class="blockquote-footer">{{ $data->created_at }}</footer>
                            </blockquote>
                        @else
                            <span class="text-danger">Description not available</span>
                        @endif

                    </div>
                </div>

            </div>
            <a class="btn bg-danger trash" href="{{ route('description.trash') }}">
                <i class="material-icons">delete</i> Deleted</a>
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
