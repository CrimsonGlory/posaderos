@extends('app')

@section('content')
<div name="people">
@if  (count($people) > 0 )
<ul>
@foreach ($people as $person)
<div name="person">
	<li> {{$person->id}}: 
<a href="{{ url('/person', $person->id) }}">
	{{$person->first_name}} {{$person->last_name}}
</a>
	</li></div>
@endforeach
</ul>
@endif
       <p><a href="{{ url('/interaction/create',$person->id) }}" class="btn btn-primary" role="button">Alta Interaccion</a></p>
</div>
@endsection
