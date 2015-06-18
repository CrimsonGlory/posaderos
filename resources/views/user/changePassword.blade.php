@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ $userShown->name }} - {{ trans('messages.changePassword') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(array('method' => 'POST', 'class' => 'form-horizontal', 'action' => array('UserController@storePassword', $userShown->id))) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.currentPassword') }}</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="old_password" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.newPassword') }}</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.confirmPassword') }}</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="confirm_password">
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary form-control"  style="width:100px;">{{ trans('messages.save') }}</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('UserController@show', $userShown->id) }}" class="btn btn-primary" style="width:100px;">{{ trans('messages.cancel') }}</a></td>
                                    </tr>
                                </table>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
