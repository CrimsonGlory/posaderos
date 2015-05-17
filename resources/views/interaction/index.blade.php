@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false" style="min-width:450px;">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
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
                                                        {{$interaction->person->first_name}} {{$interaction->person->last_name}}
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

                @if ($paginator->hasPrevPage || $paginator->hasNextPage)
                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <td align="right">
                                    <nav>
                                        <ul class="pagination">
                                            {!! $paginator->renderBootstrap('<', '>') !!}
                                        </ul>
                                    </nav>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
