@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row profile">
		<div class="col-md-2">
			<div class="profile-sidebar">
				<div class="profile-userpic">
					<img src="http://keenthemes.com/preview/metronic/theme/assets/admin/pages/media/profile/profile_user.jpg" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{$user->name}}
					</div>
					<div class="profile-usertitle-job">
						Area de necesidad
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
<!-- 				<div class="profile-userbuttons">
					<button type="button" class="btn btn-success btn-sm">Follow</button>
					<button type="button" class="btn btn-danger btn-sm">Message</button>
				</div> -->
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
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
							<a href="{{ action('InteractionController@create', $user->id) }}">
							<i class="glyphicon glyphicon-ok"></i>
							Interacciones </a>
						</li>
						<li>
							<a href="{{ action('PersonController@create') }}">
							<i class="glyphicon glyphicon-plus"></i>
							Agregar Persona </a>
						</li>
						<li>
							<a href="{{ url('/user/searchView',$user->id) }}">
							<i class="glyphicon glyphicon-search"></i>
							Buscar </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
			@yield('homeContent')
		</div>
	</div>
</div>

@endsection
