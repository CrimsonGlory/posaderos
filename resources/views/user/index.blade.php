@extends('app')

@section('content')
<div name="users">
@if  (count($users) > 0 )
<ul>
@foreach ($users as $user)
<div name="user">
	<li> {{$user->id}}: 
<a href="{{ url('/user', $user->id) }}">
	{{$user->name}} {{$user->surname}}
</a>
	</li></div>
@endforeach
</ul>
@endif
 <p><a href="{{ url('/user/create') }}" class="btn btn-primary" role="button">Alta</a></p>
</div>
@endsection
