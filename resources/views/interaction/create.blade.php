@extends('app')

@section('content')

    <h1>Crear Interacción</h1>



    {!! Form::open(['url' => 'interaction']) !!}

    <div class="form-group">
        {!! Form::label('text', 'Texto:') !!}
        {!! Form::textarea('text', null, ['class' => 'form-control']) !!}
        {{ $errors->first('text') }}
    </div>
        {!! Form::hidden('person_id', $person->id) !!}

    <div class="form-group">
        {!! Form::label('date', 'Fecha:') !!}
        {!! Form::input('date', 'date', date('Y-m-d'), ['class' => 'form-control']) !!}
        {{ $errors->first('date') }}
    </div>

    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

<!--     @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif -->

@stop