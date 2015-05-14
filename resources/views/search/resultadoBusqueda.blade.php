@if ($data['error'] == 1)
    <ul class="alert alert-danger">
        <label>Error en la consulta: Falta parámetro de búsqueda</label>
    </ul>
@elseif (!is_null($persons))
    <table class="table table-striped">
        @if ($persons != null && count($persons) != 0)
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>Otros</th>
                </tr>
            </thead>
        @endif
        <tbody>
            @if ($persons == null || count($persons) == 0)
                <th width="100%">No se encontraron resultados para los parámetros de búsqueda ingresados.</th>
            @else
                @foreach ($persons as $person)
                    <tr>
                        <th>
                            <a href="{{ action('PersonController@show', $person->id) }}">
                                {{ $person->first_name }} {{ $person->last_name }}
                            </a>
                        </th>
                        <th>{{ $person->dni }}</th>
                        <th>{{ $person->address }}</th>
                        <th>{{ $person->other }}</th>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@elseif (!is_null($interactions))
    <table class="table table-striped">
        @if ($interactions != null && count($interactions) != 0)
            <thead>
                <tr>
                    <th>Asistido</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
        @endif
        <tbody>
            @if ($interactions == null || count($interactions) == 0)
                <th width="100%">No se encontraron resultados para los parámetros de búsqueda ingresados.</th>
            @else
                @foreach ($interactions as $interaction)
                    <tr>
                        <th>
                            <a href="{{ action('PersonController@show', $interaction->person_id) }}">
                                {{ $interaction->darAsistido() }}
                            </a>
                        </th>
                        <th>{{ $interaction->text }}</th>
                        <th><a href="{{ action("InteractionController@edit",$interaction) }}">{{ trans('messages.'.$interaction->fixed) }}</a></th>
                        <th>{{ $interaction->date }}</th>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@elseif (!is_null($users))
    <table class="table table-striped">
        @if ($users != null && count($users) != 0)
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th>Tipo</th>
                </tr>
            </thead>
        @endif
        <tbody>
            @if ($users == null || count($users) == 0)
                <th width="100%">No se encontraron resultados para los parámetros de búsqueda ingresados.</th>
            @else
                @foreach ($users as $user)
                    <tr>
                        <th>
                            <a href="{{ action('UserController@show', $user->id) }}">
                                {{ $user->name }}
                            </a>
                        </th>
                        <th>{{ $user->email }}</th>
                        @if (!(is_null($user->roles()->first())))
                            <th>{{ $user->roles()->first()->display_name }}</th>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endif
