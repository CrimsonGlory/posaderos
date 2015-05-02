@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ $user->name }}</h4></td>
                                @if ($user->id == Auth::user()->id)
                                    <td align="right"><a class="btn btn-primary" href="{{ action('UserController@edit',$user) }}" style="width:80px;">Editar</a></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form class="form-horizontal" role="form" action="{{ url('person') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group" align="center">
                                <img src="{{ $gravatar }}" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" class="img-circle" style="max-width:150px; max-height:150px;">
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Correo electrónico</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="email">{{$user->email}}</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('list_people',['people' => $user->people, 'username' => $user->name])

@endsection
