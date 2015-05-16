@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="min-width:450px;">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ ucfirst($name) }} - Últimos asistidos</h4></td>
                            </tr>
                        </table>
                    </div>

                    @if (count($people) > 0)
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>DNI</th>
                                                <th>Género</th>
                                                <th>Dirección</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($people as $person)
                                                <tr>
                                                    <th>
                                                        <a href="{{ action('PersonController@show', $person->id) }}">
                                                            {{ $person->first_name }} {{ $person->last_name }}
                                                        </a>
                                                    </th>
                                                    <th>
                                                        {{ $person->dni }}
                                                    </th>
                                                    <th>
                                                        {{ trans('messages.'.$person->gender) }}
                                                    </th>
                                                    <th>
                                                        {{ $person->address }}
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <label>No hay ningún asistido para mostrar.</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="panel panel-default" style="min-width:450px;">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ ucfirst($name) }} - Últimas interacciones</h4></td>
                            </tr>
                        </table>
                    </div>

                    @if (count($interactions) > 0)
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Asistido</th>
                                            <th>Descripción</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($interactions as $interaction)
                                                <tr>
                                                    <th>
                                                        <a href="{{ action('PersonController@show', $interaction->person_id) }}">
                                                            {{ $interaction->person->first_name }} {{ $interaction->person->last_name }}
                                                        </a>
                                                    </th>
                                                    <th>
                                                        {{ $interaction->text }}
                                                    </th>
                                                    <th>
                                                        <a href="{{ action("InteractionController@edit",$interaction) }}">{{ trans('messages.'.$interaction->fixed) }}</a>
                                                    </th>
                                                    <th>
                                                        {{ $interaction->date }}
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <label>No hay ninguna interacción para mostrar.</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
