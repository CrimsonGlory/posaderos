@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.installation') }} - {{ trans('messages.admin_create_form') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['class' => 'form-horizontal', 'method'=> 'POST', 'action' => 'SetupController@admin']) !!}
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.firstName') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="" maxlength="255" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.email') }}</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="" maxlength="255">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.password') }}</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" value="" maxlength="255">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.confirmPassword') }}</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation" value="" maxlength="255">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">{{ trans('messages.continue') }}</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
