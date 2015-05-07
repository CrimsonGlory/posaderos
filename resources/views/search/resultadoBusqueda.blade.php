@if ($data['error'] == 1)
    <div class="col-md-9">
        <div class="container">
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <span class="label label-danger">Se produjo un error en la consulta: Falta parámetro de búsqueda</span>
                </div>
            </div>
        </div>
    </div>
@elseif (!is_null($persons))
    <div class="col-md-12 col-xs-offset-2">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Dirección</th>
                        <th>Otros</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($persons as $person)
                        <tr>
                            <th>{{$person->first_name}}</th>
                            <th>{{$person->last_name}}</th>
                            <th>{{$person->dni}}</th>
                            <th>{{$person->address}}</th>
                            <th>{{$person->other}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@elseif (!is_null($interactions))
    <div class="col-md-12 col-xs-offset-2">
        <div class="panel-body">
            <div class="table-responsive">
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
                            <th>{{ $interaction->darAsistido() }}</th>
                            <th>{{ $interaction->text }}</th>
                            <th>{{ $interaction->date }}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@elseif (!is_null($users))
    <div class="col-md-12 col-xs-offset-2">
        <div class="panel-body">
            <div class="table-responsive">
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
                            <th>{{$user->name}}</th>
                            <th>{{$user->email}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

