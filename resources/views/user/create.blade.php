@extends('app')

@section('content')

    <h1>Crear usuario</h1>

    <hr/>

    {!! Form::open(['url' => 'user']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {{ $errors->first('name') }}
    </div>
    <div class="form-group">
        {!! Form::label('surname', 'Apellido:') !!}
        {!! Form::text('surname', null, ['class' => 'form-control']) !!}
        {{ $errors->first('surname') }} 
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        {{ $errors->first('email') }}
    </div>

    <div class="form-group">
        {!! Form::label('birthDate', 'Fecha de nacimiento:') !!}
        {!! Form::text('birthDate', null, ['class' => 'form-control']) !!}
        {{ $errors->first('birthDate') }}
    </div>

    <div class="form-group">
        {!! Form::label('gender','Sexo:') !!}
        {!! Form::select('gender', array('male' => 'Hombre', 'female' => 'Mujer'), 'male') !!}
        {{ $errors->first('gender') }}
    </div>
    <div class="form-group">
        {!! Form::label('address', 'Direccion:') !!}
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
        {{ $errors->first('address') }}
    </div>
    <div class="form-group">
        {!! Form::label('dni', 'DNI:') !!}
        {!! Form::text('dni', null, ['class' => 'form-control']) !!}
        {{ $errors->first('dni') }}
    </div>

    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@stop