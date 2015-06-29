@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.installation') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['class' => 'form-horizontal', 'method'=> 'GET', 'action' => 'SetupController@createAdmin']) !!}
                            <div class="title" align="center" style="color: #B0BEC5; font-size: 30px; font-weight: 100; font-family: 'Lato'; margin-bottom: 20px;">
                                {{ trans('messages.schema_created') }}
                            </div>

                            <div class="form-group" align="center">
                                <button type="submit" class="btn btn-primary">{{ trans('messages.continue') }}</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
