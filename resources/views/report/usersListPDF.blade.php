@if ($users != null && count($users) > 0)
    <div class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <h1 align="center">Listado de usuarios</h1>
                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            <label style="font:bold;">Desde fecha:</label> {{ $fromDate }}
                        </td>
                        <td style="width:50%">
                            <label style="font:bold;">Hasta fecha:</label> {{ $toDate }}
                        </td>
                    </tr>
                </table>

                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            @if ($role != 'select')
                                <label style="font:bold;">Tipo de usuario:</label>
                                {{ DB::table('roles')->where('name', $role)->first()->display_name }}
                            @endif
                        </td>
                        <td style="width:50%">
                            @if ($tags != null && count($tags) > 0)
                                <label style="font:bold;">Etiquetas:</label>
                                @foreach($tags as $tag)
                                    {{ $tag }},
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <table class="table table-striped" cellpadding="2" cellspacing="1" width="100%">
                    <thead>
                        <tr>
                            <td style="font:bold; border-bottom:1px solid black;">Fecha</td>
                            <td style="font:bold; border-bottom:1px solid black;">Nombre</td>
                            <td style="font:bold; border-bottom:1px solid black;">Correo electrónico</td>
                            <td style="font:bold; border-bottom:1px solid black;">Teléfono</td>
                            <td style="font:bold; border-bottom:1px solid black;">Tipo de usuario</td>
                            <td style="font:bold; border-bottom:1px solid black;">Etiquetas</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td style="border-bottom:1px solid black;">{{ date("d/m/Y", strtotime($user->created_at)) }}</td>
                                <td style="border-bottom:1px solid black;">{{ $user->name }}</td>
                                <td style="border-bottom:1px solid black;">{{ $user->email }}</td>
                                <td style="border-bottom:1px solid black;">{{ $user->phone }}</td>
                                <td style="border-bottom:1px solid black;">
                                    @if ($user->roles() != NULL && $user->roles()->first() != NULL)
                                        {{ $user->roles()->first()->display_name }}
                                    @endif
                                </td>
                                <td style="border-bottom:1px solid black;">
                                    @if (count($user->tagNames()) > 0)
                                        @foreach ($user->tagNames() as $tag)
                                            {{ $tag }},
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
                                No hay ningún usuario creado desde el {{ $fromDate }} hasta el {{ $toDate }}
                                @if ($role != 'select')
                                    con tipo de usuario
                                    {{ DB::table('roles')->where('name', $role)->first()->display_name }}
                                @endif
                                @if ($tags != null && count($tags) > 0)
                                    con etiquetas:
                                    @foreach($tags as $tag)
                                        {{ $tag }},
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

