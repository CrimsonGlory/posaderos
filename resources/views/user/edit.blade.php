@extends('app')

@section('content')

    <h1>Editar usuario</h1>

    <hr/>

    {!! Form::open(['url' => 'user']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
        {{ $errors->first('name') }}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
        {{ $errors->first('email') }}
    </div>

    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@stop
