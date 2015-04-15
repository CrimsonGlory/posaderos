@extends('app')

@section('content')
<div name="interactions">
@if  (count($interactions) > 0 )
<ul>
@foreach ($interactions as $interaction)
<div name="interaction">
	<li> {{$interaction->id}}: 
<a href="{{ url('/interaction', $interaction->id) }}">
	{{$interaction->text}}
</a>
	</li></div>
@endforeach
</ul>
@endif
       <p><a href="{{ url('/interaction/create') }}" class="btn btn-primary" role="button">Alta</a></p>
</div>
@endsection
