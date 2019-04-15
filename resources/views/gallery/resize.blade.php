@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-outline-secondary btn-sm float-right" href="{{route('admin')}}">Back</a>
        <h4>Optimize Image</h4>
        <hr>
        @include('layouts.flashMessage')
        <div class="mt-3">
            <ul class="list-group">
                @if(isset($galleries) && count($galleries) > 0)
                    @foreach($galleries as $gallery)
                        <li class="list-group-item p-0">
                            <ul class="list-group list-group-horizontal flex-fill list-group-flush">
                                <li class="list-group-item flex-fill border-0 text-truncate">
                                    <a href="{{ route('image', ['image' => $gallery->name]) }}" target="_blank">
                                        {{ $gallery->name }}
                                    </a>
                                </li>
                                <li class="list-group-item flex-fill border-0 p-2 text-right">
                                    <form action="{{ route('optimize', ['photo' => $gallery->id] ) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-info btn-sm">
                                            Optimize Image
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item list-group-item-action p-0">
                        <ul class="list-group list-group-horizontal flex-fill list-group-flush">
                            <li class="list-group-item flex-fill border-0 text-truncate bg-warning text-secondary">
                                There is no any image for optimization . . .
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        {{ $galleries->links() }}


    </div>
@endsection
