@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ $person->name() }} </h4></td>
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
                                        @if ($person->get_avatar)
                                            <img src="{{ action("FileEntryController@show",$person->get_avatar ) }}" alt="" class="img-circle" style="max-width:150px; max-height:150px;"/>
                                        @else
                                            <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:150px; max-height:150px;"/>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        @if ($fileentries!=null && count($fileentries) != 0)
                                            <a class="btn btn-link" href="{{ action("PersonController@photos",$person->id) }}">Ver fotos</a> |
                                            <a class="btn btn-link" href="{{ url('person/'.$person->id.'/fileentries/photos') }}"><i class="glyphicon glyphicon-plus"></i></a>
                                        @else
                                            <a class="btn btn-link" href="{{ url('person/'.$person->id.'/fileentries/photos') }}"><i class="glyphicon glyphicon-plus"></i> Agregar foto</a>
                                        @endif
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
                                        <label class="form-control">
                                            @include('tag.list_tags',['tagNames' => $person->tagNames()])
                                        </label>
                                    </div>
                                </div>
                            @endif

                            @if ($person->created_by != 0 && $person->updated_by != 0 )
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Persona agregada por</label>
                                    <div class="col-md-6">
                                        <label class="form-control">
                                            <a href="{{ action('UserController@show',$person->created_by) }}">
                                                {{$person->creator->name}}
                                            </a>
                                            ({{$person->created_at}})
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Última actualización</label>
                                    <div class="col-md-6">
                                        <label class="form-control">
                                            <a href="{{ action('UserController@show',$person->updated_by) }}">
                                                {{$person->last_update_user->name}}
                                            </a>
                                            ({{$person->updated_at}})
                                        </label>
                                    </div>
                                </div>
 			                @endif
                        </form>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>Últimas interacciones</h4></td>
                                <td align="right"><a class="btn btn-primary" href="{{ url('person/'.$person->id.'/interaction/create') }}" style="width:80px;">Agregar</a></td>
                            </tr>
                        </table>
                    </div>

                    @if (count($interactions) > 0)
                        <table width="100%" align="center" class="table table-striped">
                            @foreach ($interactions as $interaction)
                                <tr>
                                    <td width="120" align="middle">
                                        <label>{{ $interaction->date }}</label>
                                        </br>
                                        <label>
                                            <small>
                                                <a href="{{action("UserController@show",$interaction->user->id)}}">
                                                    {{ $interaction->user->name }}
                                                </a>
                                            </small>
                                        </label>
                                    </td>
                                    <td align="left">
                                        <label>{{ $interaction->text }}</label>
                                        @if ( count($interaction->tagNames()) > 0)
                                            </br>
                                            <label>Etiquetas: @include('tag.list_tags',['tagNames'=> $interaction->tagNames()])</label>
                                        @endif
                                    </td>
                                    <td width="80" align="center"><a class="btn btn-link" href="{{ action("InteractionController@edit",$interaction) }}">Editar</a></td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@stop
