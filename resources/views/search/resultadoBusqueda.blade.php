@if ($data['error'] == 1)
    <div class="panel-body">
        <ul class="alert alert-danger">
            <label>Error en la consulta: Falta parámetro de búsqueda</label>
        </ul>
    </div>
@elseif (!is_null($people))
    @if (count($people) > 0)
        @include('person.list_people',['people' => $people])
    @else
        <div class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <div>No se han encontrado asistidos que coincidan con su búsqueda.</div>
                </div>
                <div class="form-group">
                    <a class="btn btn-primary" onclick="createPersonWithParam()">
                        <i class="glyphicon glyphicon-plus"></i>
                        Agregar asistido
                    </a>
                </div>
            </div>
        </div>
    @endif
@elseif (!is_null($interactions))
    @include('interaction.list_interactions',['interactions' => $interactions])
@elseif (!is_null($users))
    @include('user.list_users',['users' => $users])
@endif
