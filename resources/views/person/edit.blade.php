@extends('app')

@section('content')

    <h1>Editar persona</h1>

    <hr/>

    {!! Form::model($person, [ 'method'=> 'PATCH', 'action' => ['PersonController@update', $person->id]]) !!}

    <div class="form-group">
        {!! Form::label('first_name', 'Nombre:') !!}
        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('last_name', 'Apellido:') !!}
        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('birthdate', 'Fecha de nacimiento:') !!}
        {!! Form::input('date', 'birthdate', date('Y-m-d'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('gender','Sexo:') !!}
        {!! Form::select('gender', array('male' => 'Hombre', 'female' => 'Mujer'), $person->gender) !!}
    </div>

    <div class="form-group">
        {!! Form::label('address', 'Dirección:') !!}
        {!! Form::text('address', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('other', 'Otros datos:') !!}
        {!! Form::text('other', null, ['class' => 'form-control']) !!}
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




    <?php /* Código viejo
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

    <div class="form-group">
    {!! Form::label('gender','Sexo:') !!}
    {!! Form::select('gender', array('male' => 'Hombre', 'female' => 'Mujer'), $person->gender) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Body:') !!}
        {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    */ ?>
@stop
