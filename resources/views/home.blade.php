@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row profile">
		<div class="col-md-2">
			<div class="profile-sidebar">
				<div class="profile-userpic">
				<img src="{{ $gravatar }}" class="img-responsive" alt="">
			</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{$user->name}}
					</div>
				</div>
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="{{ action('UserController@show',$user->id) }}">
							<i class="glyphicon glyphicon-home"></i>
							Mi perfil</a>
						</li>
						<li>
							<a href="{{ action('UserController@edit', $user->id) }}">
							<i class="glyphicon glyphicon-user"></i>
							Editar Cuenta </a>
						</li>
						<li>
							<a href="{{ action('PersonController@create') }}">
							<i class="glyphicon glyphicon-plus"></i>
							Agregar Persona </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			@yield('homeContent')
		</div>
	</div>
</div>

@endsection
