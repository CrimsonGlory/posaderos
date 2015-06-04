@if ($interactions != null && count($interactions) > 0)
    <div class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <h1 align="center">Listado de interacciones con asistidos</h1>
                <table style="width:100%">
                    <tr>
                        <td align="left" style="width:50%">
                            <label style="font:bold;">Desde fecha:</label> {{ $fromDate }}
                        </td>
                        <td style="width:50%">
                            <label style="font:bold;">Hasta fecha:</label> {{ $toDate }}
                        </td>
                    </tr>
                </table>
                @if ($users != null && count($users) > 0)
                    <label style="font:bold;">Creadas por:</label>
                    @foreach($users as $idUser)
                        {{ getUserName($idUser) }},
                    @endforeach
                @endif
                <br/><br/>

                <table class="table table-striped" cellpadding="2" cellspacing="1" width="100%">
                    <thead>
                        <tr>
                            <td style="font:bold; border-bottom:1px solid black;">Fecha</td>
                            <td style="font:bold; border-bottom:1px solid black;">Asistido</td>
                            <td style="font:bold; border-bottom:1px solid black;">Descripción</td>
                            <td style="font:bold; border-bottom:1px solid black;">Estado</td>
                            <td style="font:bold; border-bottom:1px solid black;">Creada por</td>
                            <td style="font:bold; border-bottom:1px solid black;">Etiquetas</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interactions as $interaction)
                            <tr>
                                <td style="border-bottom:1px solid black;">{{ $interaction->date }}</td>
                                <td style="border-bottom:1px solid black;">{{ getPersonName($interaction->person_id) }}</td>
                                <td style="border-bottom:1px solid black;">{{ $interaction->text }}</td>
                                <td style="border-bottom:1px solid black;">{{ trans('messages.'.$interaction->fixed) }}</td>
                                <td style="border-bottom:1px solid black;">{{ getUserName($interaction->user_id) }}</td>
                                <td style="border-bottom:1px solid black;">
                                    @if (count($interaction->tagNames()) > 0)
                                        @foreach ($interaction->tagNames() as $tag)
                                            {{ $tag }}
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div id="collapseThree" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table width="100%">
                    <tr>
                        <td>
                            <div>
                                No hay ninguna interacción para mostrar desde el {{ $fromDate }} hasta el {{ $toDate }}
                                @if ($users != null && count($users) > 0)
                                    creadas por:
                                    @foreach($users as $idUser)
                                        {{ getUserName($idUser) }},
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif

