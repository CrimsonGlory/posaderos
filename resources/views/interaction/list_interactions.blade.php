@if (count($interactions))
    @if (Agent::isDesktop())
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Asistido</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Etiquetas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($interactions as $interaction)
                            <tr>
                                <th scope="row">
                                    @if ($interaction->getPerson()->get_avatar != null)
                                        <img src="{{ action("FileEntryController@show",$interaction->getPerson()->get_avatar) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @else
                                        <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ action('PersonController@show', $interaction->person_id) }}">
                                        {{$interaction->person->first_name}} {{$interaction->person->last_name}}
                                    </a>
                                </th>
                                <th>{{ $interaction->text }}</th>
                                <th>{{ date("d/m/Y", strtotime($interaction->date)) }}</th>
                                <th>
                                    <a href="{{ action("InteractionController@edit",$interaction) }}">
                                        {{ trans('messages.'.$interaction->fixed) }}
                                    </a>
                                </th>
                                @if (count($interaction->tagNames()) > 0)
                                    <th>
                                        @include('tag.list_tags',['tagNames' => $interaction->tagNames()])
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
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($interactions as $interaction)
                            <tr>
                                <th scope="row">
                                    <a href="{{ action('PersonController@show',$interaction->getPerson()->id) }}">
                                        @if ($interaction->getPerson()->get_avatar != null)
                                            <img src="{{ action("FileEntryController@show",$interaction->getPerson()->get_avatar) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                        @else
                                            <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    @if (strlen($interaction->text) > 30)
                                        {{ substr($interaction->text, 0, 29) }}...
                                    @else
                                        {{ $interaction->text }}
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ action("InteractionController@edit",$interaction) }}">
                                        {{ trans('messages.'.$interaction->fixed) }}
                                    </a>
                                </th>
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
                            <div>No hay ninguna interacción para mostrar.</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
