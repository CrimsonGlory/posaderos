@extends('app')

@section('content')
<div name="people">
@if  (count($people) > 0 )
<ul>
@foreach ($people as $person)
<div name="person">
	<li>
<a href="{{ url('/person', $person->id) }}">
	{{$person->first_name}} {{$person->last_name}}
</a>
	</li></div>
@endforeach
</ul>
@endif
</div>
@endsection
