@if ($data['error'] == 1)
    <h4>
        <span class="label label-danger">Error en la consulta: Falta parámetro de búsqueda</span>
    </h4>
@elseif (!is_null($persons))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Dirección</th>
                <th>Otros</th>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>
@elseif (!is_null($interactions))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Asistido</th>
                <th>Descripción</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interactions as $interaction)
                <tr>
                    <th>
                        <a href="{{ action('PersonController@show', $interaction->person_id) }}">
                            {{ $interaction->darAsistido() }}
                        </a>
                    </th>
                    <th>{{ $interaction->text }}</th>
                    <th>{{ $interaction->date }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif (!is_null($users))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo electrónico</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>
                        <a href="{{ action('UserController@show', $user->id) }}">
                            {{ $user->name }}
                        </a>
                    </th>
                    <th>{{ $user->email }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
