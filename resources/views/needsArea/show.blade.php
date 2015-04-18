@extends('app')

@section('content')

<div name="needsArea">
@if (!is_null($needsArea->name))
	Nombre: {{$needsArea->name}} 
 <br />
@endif

@if (!is_null($needsArea->description))
Descripcion: {{$needsArea->description}} <br />
@endif

<a href="{{ action('NeedsAreaController@edit',$needsArea) }}">[editar]</a>



</div>
@endsection
