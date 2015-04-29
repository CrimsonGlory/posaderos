@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Actualizar usuario</h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($user, ['class' => 'form-horizontal', 'method'=> 'PATCH', 'action' => ['UserController@update',$user->id]]) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nombre</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" autofocus="true">
                                    {{ $errors->first('name') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Correo electrónico</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary" style="width:100px;">Guardar</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('UserController@show', $user->id) }}" class="btn btn-primary" style="width:100px;">Cancelar</a></td>
                                    </tr>
                                </table>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@stop
