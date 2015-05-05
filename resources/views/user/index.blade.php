@extends('app')

@section('content')

    <?php $userNum=0; ?>

    <div class="col-md-8 col-md-offset-2">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasPersonas">
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
                                        <th>#</th>
                                        <th>Usuario</th>
                                        <th>Correo electrónico</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <?php $userNum=$userNum + 1; ?>
                                            <tr>
                                                <th scope="row">{{$userNum}}</th>
                                                <th>
                                                    <a href="{{ url('/user', $user->id) }}">
                                                        {{$user->name}} {{$user->surname}}
                                                    </a>
                                                </th>
                                                <th>{{$user->email}}</th>
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