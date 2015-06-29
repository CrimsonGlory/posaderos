<html>
    <head>
        <title>{{ trans('messages.posaderos') }}</title>

        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
                margin-bottom: 40px;
            }

            .quote {
                font-size: 24px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">{{ trans('messages.installation') }}</div>
                    <div class="container-fluid">
                    <div class="row">
                    <div class="col-md10 col-md-offset-1">
                    <div class="panel-body">
                    <div>{{ trans('messages.admin_create_form') }}</div>
                    {!! Form::open(['class' => 'form-horizontal', 'method'=> 'POST', 'action' => 'SetupController@admin']) !!}
                    <div class="form-group">
                    <label class="col-md-4 control-label">{{ trans('messages.firstName') }}</label>
                    <div class="col-md-6">A
                        <input type="text" class="form-control" name="name" value="" autofocus="true">
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="col-md-4 control-label">{{ trans('messages.email') }}</label>
                    <div class="col-md-6">A
                        <input type="email" class="form-control" name="email" value="" autofocus="true">
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="col-md-4 control-label">{{ trans('messages.password') }}</label>
                    <div class="col-md-6">A
                        <input type="password" class="form-control" name="password" value="" autofocus="true">
                    </div>
                    </div>

                    <div class="form-group">
                    <label class="col-md-4 control-label">{{ trans('messages.confirmPassword') }}</label>
                    <div class="col-md-6">A
                        <input type="password" class="form-control" name="password_confirmation" value="" autofocus="true">
                    </div>
                    </div>
                    <div class="form-group">
                   <button type="submit" class="btn btn-primary">{{ trans('messages.continue') }}</button>
                   {!! Form::close() !!}
            </div>

            </div>
            </div>
            </div>
            </div>
</div></div>
    </body>
</html>
