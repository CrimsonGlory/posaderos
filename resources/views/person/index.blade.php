@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasPersonas">
                    <table width="100%">
                        <tr>
                            <td><h4>Asistidos</h4></td>
                            <td align="right"><a class="btn btn-primary" href="{{ action('PersonController@create') }}" style="width:80px;">Agregar</a></td>
                        </tr>
                    </table>
                </div>
                @if  (count($people) > 0)
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="form-group">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nombre</th>
                                        <th>DNI</th>
                                        <th>Género</th>
                                        <th>Dirección</th>
                                        <th>Otros</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($people as $person)
                                            <tr>
                                                <th scope="row">
                                                    @if ($person->fileentries() != null && count($person->fileentries()->get()) != 0)
                                                        <img src="{{ action("FileEntryController@show",$person->fileentries()->first()->id) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                                    @else
                                                        <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                                    @endif
                                                </th>
                                                <th>
                                                    <a href="{{ action('PersonController@show',$person->id) }}">
                                                        {{$person->first_name}} {{$person->last_name}}
                                                    </a>
                                                </th>
                                                <th>{{$person->dni}}</th>
                                                @if($person->gender=="male")
                                                    <th>Hombre</th>
                                                @else
                                                    <th>Mujer</th>
                                                @endif
                                                <th>{{$person->address}}</th>
                                                <th>{{$person->other}}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

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
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
