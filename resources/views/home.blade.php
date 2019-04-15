@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-2">
            <div class="card-header py-2">
                <a class="btn btn-link float-right" href="">View All</a>
                <span class="btn">New Contact Details</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group accordion" id="accordian">
                    @if(isset($contacts) && count($contacts) > 0)
                        @foreach($contacts as $contact)
                            <li class="list-group-item p-0">
                                <ul class="list-group list-group-horizontal flex-fill list-group-flush"
                                    id="heading{{$contact->id}}">
                                    <li class="list-group-item flex-fill border-0 text-truncate">
                                        <a href="#" target="_blank">
                                            {{ $contact->about }}
                                        </a><br>
                                        <a class="small text-secondary" href="mailto:{{$contact->email}}">
                                            {{$contact->email}}
                                        </a>
                                        <span class="small ml-2">{{$contact->created_at}}</span>
                                    </li>
                                    <li class="list-group-item flex-fill border-0 p-2 text-right">
                                        <button class="btn btn-info btn-sm" type="button" data-toggle="collapse"
                                                data-target="#collapse{{$contact->id}}" aria-expanded="false"
                                                aria-controls="collapse{{$contact->id}}">
                                            Open
                                        </button>
                                    </li>
                                </ul>
                                <div class="collapse" id="collapse{{$contact->id}}"
                                     aria-labelledby="heading{{$contact->id}}" data-parent="#accordian">
                                    <div class="card card-body">
                                        <div class="font-weight-bolder">Name : {{$contact->name}}</div>
                                        <a class="small" href="mailto:{{$contact->email}}">Email : {{$contact->email}}</a>
                                        <div>Location : {{$contact->where}}</div>
                                        <div>Event Date : {{$contact->event_date}}</div>
                                        <div>Came to know : {{$contact->how_find}}</div>
                                        <p>{{$contact->about}}</p>
                                        <span class="small text-secondary">{{$contact->created_at}}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item list-group-item-action p-0">
                            <ul class="list-group list-group-horizontal flex-fill list-group-flush">
                                <li class="list-group-item flex-fill border-0 text-truncate bg-warning text-secondary">
                                    There is no any new contact or message . . .
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        {{ $contacts->links() }}
    </div>
@endsection
