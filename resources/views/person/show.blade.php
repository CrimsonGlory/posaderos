@extends('app')

@section('content')

<div name="person">
@if (!is_null($person->first_name) OR !is_null($person->last_name))
	Nombre: {{$person->first_name}} 
	{{$person->last_name}} <br />
@endif

@if (!is_null($person->email))
Email: {{$person->email}} <br />
@endif

@if (!is_null($person->birthdate))
Fecha de nacimiento: {{$person->birthdate}} <br />
@endif

@if (!is_null($person->dni))
DNI: {{$person->dni}} <br />
@endif

@if (!is_null($person->gender))
Sexo:   {{ trans('messages.'.$person->gender) }}  <br />
@endif

@if (!is_null($person->address))
Dirección: {{$person->address}} <br />
@endif

@if (!is_null($person->other))
Otros datos: {{$person->other}} <br />
@endif
<a href="{{ url('/person/edit', $person->id) }}">
	{{$person->first_name}} {{$person->last_name}}
</a>
       <p><a href="{{ url('/person/showAllFrom',$person->id) }}" class="btn btn-primary" role="button">Mostrar Interacciones</a></p>


</div>
@endsection
