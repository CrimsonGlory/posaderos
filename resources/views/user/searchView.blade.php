@extends('app')
@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).text();
		$('.search-panel span#search_concept').text(param);
		$('.input-group #search_param').text(param);
	});
});
function buscar(){
var k = $('#keyWord').val();
var tf = $('#search_param').text();
$.get( "/user/search", { toFind: tf, key: k } )
  .done(function( data ) {
    $('#resultado').html("");
    $('#resultado').html(data);
  });	
}



</script>
<div class="container-fluid	">
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
						@if (isset($user))
						{{$user->first_name}} {{$user->last_name}}
						@endif
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
							<a href="{{ url('/user/show', $user->id) }}">
							<i class="glyphicon glyphicon-home"></i>
							Mi perfil</a>
						</li>
						<li>
							<a href="{{ url('/user/edit', $user->id) }}">
							<i class="glyphicon glyphicon-user"></i>
							Editar Cuenta </a>
						</li>
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-ok"></i>
							Interacciones </a>
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
			<div class="container">
			    <div class="row">    
			        <div class="col-xs-8 col-xs-offset-2">
					    <div class="input-group">
			                <div class="input-group-btn search-panel" role="search">
			                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			                    	<span id="search_concept">Que desea buscar?</span> <span class="caret"></span>
			                    </button>
			                    <ul class="dropdown-menu" role="menu">
			                      <li><a href="#user">Usuario</a></li>
			                      <li><a href="#person">Persona</a></li>
			                      <li><a href="#interaction">Interaccion</a></li>
			                    </ul>
			                </div>
			                <input type="hidden" name="search_param" value="Interaccion" id="search_param">         
			                <input type="text" id="keyWord" class="form-control" name="x" placeholder="buscar...">
			                <span class="input-group-btn">
			                    <button id="search" class="btn btn-default" type="button" onClick="buscar()"><span class="glyphicon glyphicon-search"></span></button>
			                </span>
			            </div>
			        </div>
				</div>
			</div>
			</br></br></br>
			<div id="resultado">
			</div>
		</div>
		</div>
	</div>
</div>

</div>
@endsection
