@component('mail::message')
# Contact Details

__Name :__ **{{ucwords($contact->name)}}** <br>
__Email :__ <{{$contact->email}}> <br>
__Event Venue:__ {{ucfirst($contact->where)}} <br>
__Event Date :__ {{$contact->event_date}} <br>
@if($contact->how_find)
__How did you find me?__
{{$contact->how_find}} <br>
@endif
__About event :__
{{$contact->about}}


Submission date,<br>
`{{ $contact->created_at }}`
@endcomponent
