@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ $person->first_name }} {{ $person->last_name }}</h4></td>
                                <td align="right"><a class="btn btn-primary" href="{{ action('PersonController@edit', $person->id) }}" style="width:80px;">Editar</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form class="form-horizontal" role="form" action="{{ url('person') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <table align="center">
                                <tr>
                                    <td>
                                        @if (count($fileentries) != 0)
                                            <img src="{{ asset($fileentries->first()->filename) }}" alt="No se pudo cargar la foto" class="img-circle" style="max-width:150px; max-height:150px;"/>
                                        @else
                                            <img src="{{ asset("no-photo.png") }}" alt="Sin foto" class="img-circle" style="max-width:150px; max-height:150px;"/>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-link" href="{{ url('person/'.$person->id.'/fileentries/photos') }}">Actualizar foto</a>
                                    </td>
                                </tr>
                            </table>
			    @if ($person->dni!=null && $person->dni!=0)
                            <div class="form-group">
                                <label class="col-md-4 control-label">DNI</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="dni">{{ $person->dni }}</label>
                                </div>
                            </div>
			    @endif

			    @if ($person->birthdate!=null)
                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha de nacimiento</label>
                                <div class="col-md-6">
                                    <label  class="form-control" name="birthdate">{{ $person->birthdate }}</label>
                                </div>
                            </div>
			    @endif

                            <div class="form-group">
                                <label class="col-md-4 control-label">Sexo</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="gender">{{ trans('messages.'.$person->gender) }}</label>
                                </div>
                            </div>

			    @if ($person->email!=null)
                            <div class="form-group">
                                <label class="col-md-4 control-label">Correo electrónico</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="email">{{ $person->email }}</label>
                                </div>
                            </div>
			    @endif

			    @if ($person->address!=null)
                            <div class="form-group">
                                <label class="col-md-4 control-label">Dirección</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="address">{{ $person->address }}</label>
                                </div>
                            </div>
			    @endif

			    @if ($person->other!=null)
                            <div class="form-group">
                                <label class="col-md-4 control-label">Observaciones</label>
                                <div class="col-md-6">
                                    <label class="form-control" style="height: 50px;" name="other">{{ $person->other }}</label>
                                </div>
                            </div>
			    @endif
		@if (count($person->tagNames()) > 0)		
			 <div class="form-group">
				<label class="col-md-4 control-label">Etiquetas</label>
				<div class="col-md-6">

				 @include('tag.list_tags',['tagNames' => $person->tagNames()])
				</div>
			</div>
		@endif

                            <div class="form-group">
                                <label class="col-md-4 control-label"><small>Persona agregada por:</small></label>
				<div class="col-md-6"><small><a href="{{ action('UserController@show',$person->created_by) }}">
					 {{$person->creator->name}}</a> ({{$person->created_at}})</small></label>
				</div>
                            </div>

			   <div class="form-group">
                                <label class="col-md-4 control-label"><small>Última actualización:</small></label>
                                <div class="col-md-6"><small><a href="{{ action('UserController@show',$person->updated_by) }}">
                                         {{$person->last_update_user->name}}</a> ({{$person->updated_at}})</small></label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>Interacciones</h4></td>
                                <td align="right"><a class="btn btn-primary" href="{{ url('person/'.$person->id.'/interaction/create') }}" style="width:80px;">Agregar</a></td>
                            </tr>
                        </table>
                    </div>
                    @if (count($interactions) != 0)
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" action="{{ url('person') }}">
                                @if (count($interactions) > 0)
                                    <div class="form-group">
                                        <table width="100%" align="center">
                                            @foreach ($interactions as $interaction)
                                                <tr>
                                                    <td width="120" align="middle"><label>{{ $interaction->date }}</label></td>
                                                    <td align="left"><label>{{ $interaction->text }}</label></td>
						    <td width="80" align="center"><a class="btn btn-link" href="{{ action("InteractionController@edit",$interaction) }}">Editar</a></td>
                                                </tr>
						<tr><td width="120" align="middle"><label><small><a href="{{action("UserController@show",$interaction->user->id)}}">
								 {{ $interaction->user->name }}</a></small></label></td>
						@if ( count($interaction->tagNames()) > 0)
                                                        <td align="middle"><label>Etiquetas: @include('tag.list_tags',['tagNames'=> $interaction->tagNames()])</label></td>
						@else
							<td></td>
                                                    @endif
						<td></td></tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @endif
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@stop
