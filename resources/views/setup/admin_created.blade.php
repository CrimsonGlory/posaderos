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
                    <div>{{ trans('messages.admin_created') }}</div>
                   {!! Form::open(['class' => 'form-horizontal', 'method'=> 'GET', 'action' => 'HomeController@index']) !!}
                   <button type="submit" class="btn btn-primary">{{ trans('messages.continue') }}</button>
                   {!! Form::close() !!}
                <div class="quote">{{ Inspiring::quote() }}</div>
            </div>
        </div>
    </body>
</html>
