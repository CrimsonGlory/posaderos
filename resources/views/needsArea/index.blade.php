@extends('app')

@section('content')
<div name="needsArea">
@if  (count($needsArea) > 0 )
<ul>
@foreach ($needsArea as $na)
<div name="na">
	<li> {{$na->id}}: 
<a href="{{ url('/needsArea', $na->id) }}">
	{{$na->name}}
</a>
	</li></div>
@endforeach
</ul>
@endif
       <p><a href="{{ url('/needsArea/create') }}" class="btn btn-primary" role="button">Alta</a></p>
</div>
@endsection
