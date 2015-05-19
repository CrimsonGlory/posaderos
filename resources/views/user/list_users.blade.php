@if (count($users))
    @if (Agent::isDesktop())
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Usuario</th>
                                <th>Correo electrónico</th>
                                <th>Teléfono</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th>
                                        <img src="{{ $user->gravatar() }}" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" class="img-circle" style="max-width:50px; max-height:50px;">
                                    </th>
                                    <th>
                                        <a href="{{ action('UserController@show', $user->id) }}">
                                            {{ $user->name }}
                                        </a>
                                    </th>
                                    <th>{{ $user->email }}</th>
                                    <th>{{ $user->phone }}</th>
                                    @if ($user->roles() != NULL && $user->roles()->first() != NULL)
                                        <th>{{ $user->roles()->first()->display_name }}</th>
                                    @else
                                        <th> - </th>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th>
                                        <img src="{{ $user->gravatar() }}" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" class="img-circle" style="max-width:50px; max-height:50px;">
                                    </th>
                                    <th>
                                        <a href="{{ action('UserController@show', $user->id) }}">
                                            {{$user->name}}
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
    <div id="collapseTwo" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table width="100%">
                    <tr>
                        <td>
                            <label>No hay ningún usuario para mostrar.</label>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
