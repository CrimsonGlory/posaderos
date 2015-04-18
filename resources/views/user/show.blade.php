@extends('app')

@section('content')

<div name="user">
@if (!is_null($user->name))
	Nombre: {{$user->name}} 
	 <br />
@endif

@if (!is_null($user->email))
Email: {{$user->email}} <br />
@endif

<a href="{{ action('UserController@edit',$user) }}">[editar]</a>



</div>
@endsection
