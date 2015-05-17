@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false" style="min-width:500px;">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasPersonas">
                    <h4>
                        <a class="panel-title" data-toggle="collapse" data-parent="#ultimasPersonasAgregadas" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Últimos 10 asistidos agregados
                        </a>
                    </h4>
                </div>
                @include('list_people',['people' => $people])
            </div>
        </div>

        <div class="panel-group" id="ultimasInteraccionesAgregadas" role="tablist" aria-multiselectable="false" style="min-width:500px;">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasInteracciones">
                    <h4>
                        <a class="panel-title" data-toggle="collapse" data-parent="#ultimasInteraccionesAgregadas" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Últimas 10 interacciones agregadas
                        </a>
                    </h4>
                </div>
                @if (count($interactions))
                    <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="UltimasInteracciones">
                        <div class="panel-body">
                            <div class="panel panel-default">
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
                                                    {{App\Person::find($interaction->person_id)->first_name}} {{App\Person::find($interaction->person_id)->last_name}}
                                                </a>
                                            </th>
                                            <th>{{$interaction->text}}</th>
                                            <th><a href="{{ action("InteractionController@edit",$interaction) }}">{{ trans('messages.'.$interaction->fixed) }}</a></th>
                                            <th>{{$interaction->date}}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="collapseFour" class="panel-collapse collapse in">
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

@endsection
