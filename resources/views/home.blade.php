@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasPersonas">
                    <h4>
                        <a class="panel-title" data-toggle="collapse" data-parent="#ultimasPersonasAgregadas" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Últimos 10 asistidos agregados
                        </a>
                    </h4>
                </div>
                @include('list_people',['people' => $persons])
            </div>
        </div>

        <div class="panel-group" id="ultimasInteraccionesAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasInteracciones">
                    <h4>
                        <a class="panel-title" data-toggle="collapse" data-parent="#ultimasInteraccionesAgregadas" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Últimas 10 interacciones agregadas
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="UltimasInteracciones">
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
                                        <th><a href="{{ action('PersonController@show', $interaction->person_id) }}">
                                                {{App\Person::find($interaction->person_id)->first_name}} {{App\Person::find($interaction->person_id)->last_name}}</a></th>
                                        <th>{{$interaction->text}}</th>
                                        @if($interaction->fixed==1)
                                            <th>Solucionado</th>
                                        @else
                                            <th>Pendiente</th>
                                        @endif
                                        <th>{{$interaction->date}}</th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
