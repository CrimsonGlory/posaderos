@extends('app')

@section('content')
<div name="interactions">
@if  (count($datos['interactions']) > 0 )
<ul>
@foreach ($datos['interactions'] as $interaction)
<div name="interaction">
	<li> {{$interaction->id}}: 
<a href="{{ url('/interaction', $interaction->id) }}">
	{{$interaction->text}}
</a>
	</li></div>
@endforeach
</ul>
@endif
       <p><a href="{{ url('/interaction/create',$datos['person_id']) }}" class="btn btn-primary" role="button">Alta Interaccion</a></p>
</div>
@endsection
