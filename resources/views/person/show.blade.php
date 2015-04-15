@extends('app')

@section('content')

<div class="form-group">
    <div class="form-group">
<a href="{{ action('PersonController@index') }}">[volver]</a> - 
        <a href="{{ action('PersonController@edit', $person->id) }}">[editar]</a>
    </div>
    <div class="form-group">
        @if (!is_null($person->first_name) OR !is_null($person->last_name))
            <h1> {{$person->first_name}}
            {{$person->last_name}} </h1> 
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
<hr><h1>Interacciones</h1>
<a href="{{ url('person/'.$person->id.'/interaction/create') }}">[agregar]</a>
<div class="form-group">
    @if  (count($person->interactions) > 0 )
        <ul>
            @foreach ($person->interactions=App\Interaction::latest('id')->get() as $interaction)
                <div class="form-group">
                    <li> {{$interaction->date}}:
                            {{$interaction->text}} <a href="{{ action("InteractionController@edit",$interaction) }}">[editar]</a> 
                    </li>
                </div>
            @endforeach
        </ul>
    @endif
</div>

</div>

@endsection
