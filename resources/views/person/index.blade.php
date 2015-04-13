@extends('app')

@section('content')
<div class="form-group">
<a href="{{ action('PersonController@create') }}">Agregar persona</a>
</div>
<div class="form-group">
    @if  (count($people) > 0 )
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
</div>

@endsection
