@extends('app')

@section('content')

    <h1>Guardar Interacción</h1>

    <hr/>

    {!! Form::model($interaction,[ 'method' => 'PATCH', 'action' => ['InteractionController@update', $interaction->id]]) !!}

    <div class="form-group">
        {!! Form::label('text', 'Texto:') !!}
        {!! Form::textarea('text', $interaction->text, ['class' => 'form-control']) !!}
    </div>
        {!! Form::hidden('person_id', $interaction->person_id) !!}

    <div class="form-group">
        {!! Form::label('date', 'Fecha:') !!}
        {!! Form::input('date', 'date', $interaction->date, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@stop