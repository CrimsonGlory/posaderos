@extends('app')

@section('content')

<?php $interactionNum=0; ?>

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasPersonas">
                    <table width="100%">
                        <tr>
                            <td><h4>Interacciones</h4></td>
                        </tr>
                    </table>
                </div>
                @if  (count($interactions) > 0)
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="form-group">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Persona</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($interactions as $interaction)
                                            <?php $interactionNum=$interactionNum + 1; ?>
                                            <tr>
                                                <th scope="row">{{$interactionNum}}</th>
                                                <th>
                                                    <a href="{{ action('PersonController@show', $interaction->person_id) }}">
                                                        {{$interaction->person->first_name}} {{$interaction->person->last_name}}
                                                    </a>
                                                </th>
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
                @endif
            </div>
        </div>
    </div>

@endsection
