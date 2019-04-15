@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger">
                        <a class="btn btn-secondary btn-sm float-right" href="{{route('description')}}">Back</a>
                        <span class="font-weight-bold" style="vertical-align: sub;">
                            Deleted Description</span>
                    </div>
                    <div class="card-body px-1 py-0">
                        @if(count($trashes) > 0)
                            <table class="table table-responsive-sm mb-0">

                                <!-- Table Headings -->
                                <thead>
                                {{--<tr>--}}
                                {{--<th>Title</th>--}}
                                {{--<th></th>--}}
                                {{--<th></th>--}}
                                {{--</tr>--}}
                                </thead>
                                <!-- Table Body -->
                                <tbody>
                                @foreach ($trashes as $data)
                                    <tr>
                                        <td class="text-truncate" style="max-width: 100%; overflow: hidden;">
                                            {{ $data->title }}
                                        </td>
                                        <td>
                                            <div class="float-right">{{ $data->deleted_at }}</div>
                                        </td>

                                        <td>
                                            <a href="{{ route('description.show', ['description' => $data->id]) }}"
                                               class="btn btn-outline-info btn-sm float-right">View</a>
                                        </td>

                                        <td>
                                            {{--<form action="{{ route('description.restore', ['description' => $data->id]) }}"--}}
                                                  {{--method="POST">--}}
                                                {{--@csrf--}}
                                                {{--@method('PATCH')--}}
                                                {{--<button type="submit" class="btn btn-warning btn-sm float-right">--}}
                                                    {{--Restore--}}
                                                {{--</button>--}}
                                            {{--</form>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-danger m-3">Description Trash empty !!</div>
                        @endif

                    </div>
                    <hr class="mt-0">
                    <div class="mx-2">
                        {{ $trashes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

