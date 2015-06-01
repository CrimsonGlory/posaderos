@if (count($people))
    @if (Agent::isDesktop())
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Edad</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Etiquetas</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($people as $person)
                            <tr>
                                <th scope="row">
                                    @if ($person->get_avatar != null)
                                        <img src="{{ action("FileEntryController@showThumb",[50,$person->get_avatar]) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @else
                                        <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ action('PersonController@show',$person->id) }}">
                                        {{$person->name()}}
                                    </a>
                                </th>
                                <th>{{$person->dni}}</th>
                                <th>
                                    @if ($person->birthdate != null)
                                            {{date_diff(date_create($person->birthdate), date_create('today'))->y}}
                                            años
                                    @endif
                                </th>
                                <th>{{$person->address}}</th>
                                <th>{{$person->phone}}</th>
                                @if (count($person->tagNames()) > 0)
                                    <th>
                                        @include('tag.list_tags',['tagNames' => $person->tagNames()])
                                    </th>
                                @else
                                    <th></th>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div id="collapseTwo" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($people as $person)
                            <tr>
                                <th scope="row">
                                    @if ($person->get_avatar != null)
                                        <img src="{{ action("FileEntryController@show",$person->get_avatar) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @else
                                        <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ action('PersonController@show',$person->id) }}">
                                        {{$person->name()}}
                                    </a>
                                </th>
                                <th>{{$person->dni}}</th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@else
    <div id="collapseThree" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table width="100%">
                    <tr>
                        <td>
                            <div>No hay ningún asistido para mostrar.</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
