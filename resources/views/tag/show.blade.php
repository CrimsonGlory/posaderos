@extends('app')

@section('content')

<div class="form-group">
    @if  (count($people) > 0 )
	<h1>Personas</h1>
        <ul>
            @foreach ($people as $person)
                <div class="form-group">
                    <li> {{$person->id}}:
                        <a href="{{ url('/person', $person->id) }}">
                            {{$person->first_name}} {{$person->last_name}}
                        </a>
                    </li>
                </div>
            @endforeach
        </ul>
    @endif


    @if  (count($interactions) > 0 )
	<h1> Interacciones </h1>
        <ul>
            @foreach ($interactions as  $interaction)
                <div class="form-group">
                    <li> 
                        <a href="{{ action('PersonController@show', $interaction->person_id) }}">{{App\Person::find($interaction->person_id)->first_name}} {{App\Person::find($interaction->person_id)->last_name}}</a>
: 
                            {{$interaction->text}}
                    </li>
                </div>
            @endforeach
        </ul>
    @endif

</div>

@endsection
