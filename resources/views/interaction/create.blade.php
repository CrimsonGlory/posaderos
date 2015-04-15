@extends('app')

@section('content')

    <h1>Guardar Interacción</h1>

    <hr/>

    {!! Form::open(['url' => 'person/'.$person->id.'/interaction']) !!}

    <div class="form-group">
        {!! Form::label('text', 'Texto:') !!}
        {!! Form::textarea('text', null, ['class' => 'form-control']) !!}
    </div>
        {!! Form::hidden('person_id', $person->id) !!}

    <div class="form-group">
        {!! Form::label('date', 'Fecha:') !!}
        {!! Form::input('date', 'date', date('Y-m-d'), ['class' => 'form-control']) !!}
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
