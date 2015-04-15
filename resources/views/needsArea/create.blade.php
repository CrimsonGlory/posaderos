@extends('app')

@section('content')

    <h1>Crear area de necesidad</h1>

    <hr/>

    {!! Form::open(['url' => 'needsArea']) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
        {{ $errors->first('name') }}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Descripcion:') !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
        {{ $errors->first('description') }}
    </div>
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@stop