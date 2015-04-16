@extends('app')

@section('content')

<div name="interaction">

@if (!is_null($interaction->text))
Texto: {{$interaction->text}} <br />
@endif

@if (!is_null($interaction->date))
Fecha: {{$interaction->date}} <br />
@endif

<a href="{{ url('/interaction/edit', $interaction->id) }}">
	Editar
</a>



</div>
@endsection
