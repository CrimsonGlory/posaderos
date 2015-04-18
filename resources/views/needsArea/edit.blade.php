@extends('app')

@section('content')
<!-- @if($errors->has())

We encountered the following errors:

<ul>
    @foreach($errors->all() as $message)

    <li>{{ $message }}</li>

    @endforeach
</ul>

@endif -->
    <h1>Editar Area de necesidad</h1>

    <hr/>

    {!! Form::open([ 'method'=> 'PATCH', 'action' => ['NeedsAreaController@update',$needsArea->id ]]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', $needsArea->name, ['class' => 'form-control']) !!}
        {{ $errors->first('name') }}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'descripcion:') !!}
        {!! Form::text('description', $needsArea->description, ['class' => 'form-control']) !!}
        {{ $errors->first('description') }}
    </div>

    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@stop