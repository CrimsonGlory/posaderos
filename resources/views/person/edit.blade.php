@extends('app')

@section('content')

    <h1>Editar persona</h1>

    <hr/>

    {!! Form::open([ 'method'=> 'PATCH', 'action' => ['PersonController@update',$person->id ]]) !!}

    <div class="form-group">
        {!! Form::label('first_name', 'Nombre:') !!}
        {!! Form::text('first_name', $person->first_name, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('last_name', 'Apellido:') !!}
        {!! Form::text('last_name', $person->last_name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', $person->email, ['class' => 'form-control']) !!}
    </div>

    <?php
            /*
    <div class="form-group">
        {!! Form::label('birthdate', 'Fecha de nacimiento:') !!}
        {!! Form::text('birthdate', $person->first_name, ['class' => 'form-control']) !!}
    </div>
            */
?>
    <div class="form-group">
    {!! Form::label('gender','Sexo:') !!}
    {!! Form::select('gender', array('male' => 'Hombre', 'female' => 'Mujer'), $person->gender) !!}
    </div>

    <?php /*
    <div class="form-group">
        {!! Form::label('body', 'Body:') !!}
        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
    </div>
*/ ?>
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@stop