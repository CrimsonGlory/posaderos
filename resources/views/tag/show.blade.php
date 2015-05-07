@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ ucfirst($name) }} - Últimos asistidos</h4></td>
                            </tr>
                        </table>
                    </div>

                    @if (count($people) > 0)
                        <table width="100%" align="center" class="table table-striped">
                            @foreach ($people as $person)
                                <tr>
                                    <td>
                                        <a href="{{ url('/person', $person->id) }}">
                                            {{$person->first_name}} {{$person->last_name}}
                                        </a>
                                    </td>
                                    <td>
                                        {{trans('messages.'.$person->gender)}}
                                    </td>
                                    <td>
                                        {{ $person->address }}
                                    </td>
                                    <td>
                                        {{ $person->other }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ ucfirst($name) }} - Últimas interacciones</h4></td>
                            </tr>
                        </table>
                    </div>

                    @if (count($interactions) > 0)
                        <table width="100%" align="center" class="table table-striped">
                            @foreach ($interactions as $interaction)
                                <tr>
                                    <td width="40%">
                                        <a href="{{ action('PersonController@show', $interaction->person_id) }}">{{$interaction->person->first_name}} {{$interaction->person->last_name}}</a>
                                    </td>
                                    <td width="60%">
                                        {{$interaction->text}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
