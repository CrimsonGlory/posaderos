@if ($data['error'] == 1)
    <ul class="alert alert-danger">
        <label>Error en la consulta: Falta parámetro de búsqueda</label>
    </ul>
@elseif (!is_null($people))
    @include('person.list_people',['people' => $people])
@elseif (!is_null($interactions))
    @include('interaction.list_interactions',['interactions' => $interactions])
@elseif (!is_null($users))
    @include('user.list_users',['users' => $users])
@endif
