@extends('app')

@section('content')

    <h1>Guardar persona</h1>

    <hr/>

    {!! Form::open(['url' => 'person']) !!}

    <div class="form-group">
        {!! Form::label('first_name', 'Nombre:') !!}
        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('last_name', 'Apellido:') !!}
        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('birthdate', 'Fecha de nacimiento:') !!}
        {!! Form::input('date', 'birthdate', date('Y-m-d'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
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
        {!! Form::select('gender', array('male' => 'Hombre', 'female' => 'Mujer'), 'male') !!}
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

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@stop