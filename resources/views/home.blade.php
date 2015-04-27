@extends('app')

@section('content')
<?php $interactionNum=0; ?>
<?php $personNum=0; ?>
<div class="container-fluid	">
    <div class="row profile">
		<div class="col-md-2">
			<div class="profile-sidebar">
				<div class="profile-userpic">
					<img src="{{ $gravatar }}" class="img-responsive" alt="">
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
							<a href="{{ action('InteractionController@index') }}">
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
			<div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false">
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="UltimasPersonas">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#ultimasPersonasAgregadas" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          Ultimas 10 personas agregadas
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="UltimasPersonas">
			      <div class="panel-body">
					<div class="table-responsive">
					  <table class="table table-striped">
					  	<thead>
						    <tr>
						    	<th>#</th>
						    	<th>nombre</th>
						    	<th>DNI</th>
						    	<th>Genero</th>
						    	<th>Direccion</th>
						    	<th>Otro</th>
						    </tr>
						</thead>
					  	<tbody>
							@foreach ($persons as $person)
								<?php $personNum=$personNum + 1; ?>
								<tr>
							    	<th scope="row">{{$personNum}}</th>
							    	<th><a href="{{action('PersonController@show',$person->id) }}">
								{{$person->first_name}} {{$person->last_name}}</a></th>
							    	<th>{{$person->dni}}</th>
							    	 @if($person->gender=="male")
	           						<th>Hombre</th>
	           						@else
	           						<th>Mujer</th>
						             @endif
							    	<th>{{$person->address}}</th>
							    	<th>{{$person->other}}</th>
							    </tr>
							@endforeach
						</tbody>
					  </table>
					</div>
			      </div>
			    </div>
			  </div>
			  </div>
			<div class="panel-group" id="ultimasInteraccionesAgregadas" role="tablist" aria-multiselectable="false">
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="UltimasInteracciones">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#ultimasInteraccionesAgregadas" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
			          Ultimas 10 interacciones agregadas
			        </a>
			      </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="UltimasInteracciones">
			      <div class="panel-body">
					<div class="table-responsive">
					  <table class="table table-striped">
					  	<thead>
						    <tr>
						    	<th>#</th>
						    	<th>Persona</th>
						    	<th>Descripcion</th>
						    	<th>Estado</th>
						    	<th>Fecha</th>
						    </tr>
						</thead>
					  	<tbody>
							@foreach ($interactions as $interaction)
								<?php $interactionNum=$interactionNum + 1; ?>
								<tr>
							    	<th scope="row">{{$interactionNum}}</th>
							    	<th><a href="{{ action('PersonController@show', $interaction->person_id) }}">
{{$interaction->person->first_name}} {{$interaction->person->last_name}}</a></th>
							    	<th>{{$interaction->text}}</th>
							    	 @if($interaction->fixed==1)
	           						<th>Solucionado</th>
	           						@else
	           						<th>Pendiente</th>
						             @endif
							    	<th>{{$interaction->date}}</th>
							    </tr>
							@endforeach
						</tbody>
					  </table>
					</div>
			      </div>
			    </div>
			  </div>
			  </div>
			  
		</div>
		</div>
	</div>
</div>

</div>
@endsection
