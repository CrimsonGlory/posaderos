@extends('app')

@section('content')

<div class="form-group">
    <div class="form-group">
        <a href="{{ action('PersonController@edit', $person->id) }}">[editar]</a>
    </div>
    <div class="form-group">
        @if (!is_null($person->first_name) OR !is_null($person->last_name))
            Nombre: {{$person->first_name}}
            {{$person->last_name}} <br/>
        @endif
    </div>

    <div class="form-group">
        @if (!is_null($person->email))
            Email: {{$person->email}} <br/>
        @endif
    </div>

    <div class="form-group">
        @if (!is_null($person->birthdate))
            Fecha de nacimiento: {{$person->birthdate}} <br/>
        @endif
    </div>

    <div class="form-group">
        @if (!is_null($person->dni))
            DNI: {{$person->dni}} <br/>
        @endif
    </div>

    <div class="form-group">
        @if (!is_null($person->gender))
            Sexo: {{ trans('messages.'.$person->gender) }}  <br/>
        @endif
    </div>

    <div class="form-group">
        @if (!is_null($person->address))
            Dirección: {{$person->address}} <br/>
        @endif
    </div>

    <div class="form-group">
        @if (!is_null($person->other))
            Otros datos: {{$person->other}} <br/>
        @endif
    </div>
<hr>
<div class="form-group">
    @if  (count($person->interactions) > 0 )
        <ul>
            @foreach ($interaction as $person->interactions)
                <div class="form-group">
                    <li> {{$interaction->date}}:
                            {{$interaction->text}} 
                    </li>
                </div>
            @endforeach
        </ul>
    @endif
</div>

</div>

@endsection
