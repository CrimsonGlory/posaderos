@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
			        @include('flash::message')
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td align="left">
                                    <table id="favoritos">
                                        <tr>
                                            <td width="50px;">
                                                @if (!($person->liked(Auth::user()->id)))
                                                    <a class="btn btn-warning" href="{{ action('PersonController@addFavorite', $person->id) }}" title="Agregar a favoritos">
                                                        <i class="glyphicon glyphicon-star"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-success" href="{{ action('PersonController@removeFavorite', $person->id) }}" title="Quitar de favoritos">
                                                        <i class="glyphicon glyphicon-star"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <h4>{{ $person->name() }}</h4>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                @if (Auth::user()->can('edit-all-people') || (Auth::user()->can('edit-new-people') && $person->created_by == Auth::user()->id))
                                    <td align="right">
                                        <a class="btn btn-primary" href="{{ action('PersonController@edit', $person->id) }}" style="width:80px;">Editar</a>
                                    </td>
                                @endif
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
                                        @if ($person->get_avatar)
                                            <img src="{{ action("FileEntryController@showThumb",[150,$person->get_avatar->id ]) }}" alt="" class="img-circle" style="max-width:150px; max-height:150px;"/>
                                        @else
                                            <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:150px; max-height:150px;"/>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        @if ($fileentries != null && count($fileentries) != 0)
                                            <a class="btn btn-link" href="{{ action("PersonController@photos",$person->id) }}">Ver fotos</a>
                                            @if (Auth::user()->can('edit-all-people') || (Auth::user()->can('edit-new-people') && $person->created_by == Auth::user()->id))
                                                | <a class="btn btn-link" href="{{ url('person/'.$person->id.'/fileentries/photos') }}"><i class="glyphicon glyphicon-plus"></i></a>
                                            @endif
                                         @elseif (Auth::user()->can('edit-all-people') || (Auth::user()->can('edit-new-people') && $person->created_by == Auth::user()->id))
                                            <a class="btn btn-link" href="{{ url('person/'.$person->id.'/fileentries/photos') }}"><i class="glyphicon glyphicon-plus"></i> Agregar foto</a>
                                        @else
                                            <br/>
                                         @endif
                                    </td>
                                </tr>
                            </table>
			                @if ($person->dni != null && $person->dni != 0)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">DNI</label>
                                    <div class="col-md-6">
                                        <label class="form-control" name="dni">{{ $person->dni }}</label>
                                    </div>
                                </div>
			                @endif

			                @if ($person->birthdate != null)
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

			                @if ($person->email != null)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Correo electrónico</label>
                                    <div class="col-md-6">
                                        <label class="form-control" name="email">{{ $person->email }}</label>
                                    </div>
                                </div>
			                @endif

			                @if ($person->address != null)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Dirección</label>
                                    <div class="col-md-6">
                                        <label class="form-control" name="address">{{ $person->address }}</label>
                                    </div>
                                </div>
			                @endif

					        @if ($person->phone != null)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Teléfono</label>
                                    <div class="col-md-6">
                                        <label class="form-control" name="phone">{{ $person->phone }}</label>
                                    </div>
                                </div>
                            @endif

			                @if ($person->other != null)
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
                                        <label class="form-control">
                                            @include('tag.list_tags',['tagNames' => $person->tagNames()])
                                        </label>
                                    </div>
                                </div>
                            @endif

                            @if ($person->created_by != 0 && $person->updated_by != 0)
                                @if (Auth::user()->can('see-users') || $person->created_by == Auth::user()->id)
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Persona agregada por</label>
                                        <div class="col-md-6">
                                            <label class="form-control">
                                                <a href="{{ action('UserController@show',$person->created_by) }}">
                                                    {{ $person->creator->name }}
                                                </a>
                                                ({{ $person->created_at }})
                                            </label>
                                        </div>
                                    </div>
                                @endif

                                @if (Auth::user()->can('see-users') || $person->updated_by == Auth::user()->id)
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Última actualización</label>
                                        <div class="col-md-6">
                                            <label class="form-control">
                                                <a href="{{ action('UserController@show',$person->updated_by) }}">
                                                    {{ $person->last_update_user->name }}
                                                </a>
                                                ({{ $person->updated_at }})
                                            </label>
                                        </div>
                                    </div>
                                @endif
 			                @endif
                        </form>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>Últimas interacciones</h4></td>
                                @if (Auth::user()->can('add-interaction'))
                                    <td align="right"><a class="btn btn-primary" href="{{ url('person/'.$person->id.'/interaction/create') }}" style="width:80px;">Agregar</a></td>
                                @endif
                            </tr>
                        </table>
                    </div>

                    @if (count($interactions) > 0)
                        <table width="100%" align="center" class="table table-striped">
                            @foreach ($interactions as $interaction)
                                <tr>
                                    <td width="120" align="middle">
                                        <label>{{ $interaction->date }}</label>
                                        @if (Auth::user()->can('see-users') || $interaction->user->id == Auth::user()->id)
                                            </br>
                                            <label>
                                                <small>
                                                    <a href="{{action("UserController@show",$interaction->user->id)}}">
                                                        {{ $interaction->user->name }}
                                                    </a>
                                                </small>
                                            </label>
                                        @endif
                                    </td>
                                    <td align="left">
                                        <label>{{ $interaction->text }}</label>
                                        </br>
                                        <label>Estado: </label>
                                        @if ($interaction->fixed)
                                            <label style="color:green">{{ trans('messages.'.$interaction->fixed) }}.</label>
                                        @else
                                            <label style="color:red">{{ trans('messages.'.$interaction->fixed) }}.</label>
                                        @endif
                                        @if (count($interaction->tagNames()) > 0)
                                            <label>Etiquetas: @include('tag.list_tags',['tagNames'=> $interaction->tagNames()])</label>
                                        @endif
                                    </td>
                                    <td width="80" align="center"><a class="btn btn-link" href="{{ action("InteractionController@edit",$interaction) }}">Editar</a></td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <label>No hay ninguna interacción para mostrar.</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@stop
