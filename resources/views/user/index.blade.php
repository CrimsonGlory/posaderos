@extends('app')

@section('content')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel-group" role="tablist" aria-multiselectable="false" style="min-width:550px;">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>Usuarios</h4></td>
                        </tr>
                    </table>
                </div>
                @if  (count($users) > 0)
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="form-group">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Correo electrónico</th>
                                        <th>Tipo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th>
                                                    <a href="{{ action('UserController@show', $user->id) }}">
                                                        {{$user->name}} {{$user->surname}}
                                                    </a>
                                                </th>
                                                <th>{{$user->email}}</th>
                                                @if (!(is_null($user->roles()->first())))
                                                    <th>{{ $user->roles()->first()->display_name }}</th>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($paginator->hasPrevPage || $paginator->hasNextPage)
                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <td align="right">
                                    <nav>
                                        <ul class="pagination">
                                            {!! $paginator->renderBootstrap('<', '>') !!}
                                        </ul>
                                    </nav>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection