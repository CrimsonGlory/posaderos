@extends('app')

@section('content')

<div name="user">
@if (!is_null($user->name) OR !is_null($user->surname))
	Nombre: {{$user->first_name}} 
	{{$user->last_name}} <br />
@endif

@if (!is_null($user->email))
Email: {{$user->email}} <br />
@endif

@if (!is_null($user->birthdate))
Fecha de nacimiento: {{$user->birthdate}} <br />
@endif

@if (!is_null($user->dni))
DNI: {{$user->dni}} <br />
@endif

@if (!is_null($user->gender))
Sexo:   {{ trans('messages.'.$user->gender) }}  <br />
@endif

@if (!is_null($user->address))
Dirección: {{$user->address}} <br />
@endif

<a href="{{ url('/user/edit', $user->id) }}">
	{{$user->name}} {{$user->surname}}
</a>



</div>
@endsection
