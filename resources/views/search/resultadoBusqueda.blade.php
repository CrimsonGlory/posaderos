@if ($data['error'] == 1)
    <div class="panel-body">
        <ul class="alert alert-danger">
            <label>Error en la consulta: Falta parámetro de búsqueda</label>
        </ul>
    </div>
@elseif (!is_null($people))
    @include('person.list_people',['people' => $people])
@elseif (!is_null($interactions))
    @include('interaction.list_interactions',['interactions' => $interactions])
@elseif (!is_null($users))
    @include('user.list_users',['users' => $users])
@endif
