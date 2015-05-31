@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                @include('flash::message')
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>Usuarios</h4></td>
                        </tr>
                    </table>
                </div>

                @include('user.list_users',['users' => $users])
                @include('paginator',['paginator' => $paginator])
            </div>
        </div>
    </div>

@endsection
