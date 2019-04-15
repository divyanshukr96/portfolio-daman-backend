@if(isset($layout) && count($layout) > 0)
    @foreach($layout as $key => $data)
        <div class="post row m-0 mt-3 border {{ $key % 2 == 0 ? '' : 'flex-row-reverse' }}">
            <div class="col-lg-4 col-md-5 col-12 p-0">
                <img class="{{ $key % 2 == 0 ? '' : 'float-right' }}"
                     src="{{ route('image', ['image' => $data->photo ? $data->photo->name : '123', 'p' => 'thumbnail']) }}"
                     alt="" style="max-width: 100%;">
            </div>
            <div class="col-lg-8 col-md-7 col-12 text-center py-2 pb-4">
                <h4 class="text-info">{{ $data->title }}</h4>
                <p>{{ $data->about }}</p>

                <div class="position-absolute mt-2" style="bottom: 8px; left: 0; right: 8px;">
                    <form action="{{ route('layout.destroy', ['layout' => $data->id] ) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-3 float-right mx-2 btn-sm">
                            Delete
                        </button>
                    </form>
                    <a href="{{ route('layout.edit', ['layout' => $data->id]) }}"
                       class="btn btn-info px-3 float-right btn-sm">Edit</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12 bg-warning p-2 px-3 text-danger mt-3">
        No any data is available
    </div>
@endif