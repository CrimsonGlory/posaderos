@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Actualizar persona</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($person, ['class' => 'form-horizontal', 'method'=> 'PATCH', 'action' => ['PersonController@update', $person->id]]) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Nombre</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" value="{{ $person->first_name }}" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Apellido</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" value="{{ $person->last_name }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">DNI</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="dni" value="{{ $person->dni }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha de nacimiento</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="birthdate" value="{{ $person->birthdate }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Sexo</label>
                                <div class="col-md-6">
                                    {!! Form::select('gender', array('male' => 'Hombre', 'female' => 'Mujer'), $person->gender, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Correo electrónico</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $person->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Dirección</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{ $person->address }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Observaciones</label>
                                <div class="col-md-6">
                                    <textarea type="text" class="form-control" name="other">{{ $person->other }}</textarea>
                                </div>
                            </div>
<?php /*
                            <div class="form-group">
                                <label class="col-md-4 control-label">Etiquetas</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="tags" value="{{ implode(", ",$person->tagNames() ) }}">
                                </div>
                            </div>
*/ ?>
                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary" style="width:100px;">Guardar</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('PersonController@show', $person->id) }}" class="btn btn-primary" style="width:100px;">Cancelar</a></td>
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
