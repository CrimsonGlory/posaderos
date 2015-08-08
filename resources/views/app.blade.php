<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ trans('messages.posaderos') }}</title>
	<link href="{{ asset('css/footer.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" rel="stylesheet">
	<!-- Fonts -->
	{{-- <!--<link href='http://fonts.googleapis.com/css?family=Fira+Sans:300,400,500,700,300italic,400italic,500italic,700italic|Roboto:400,300' rel='stylesheet' type='text/css'> --> --}}
	<link href='http://fonts.googleapis.com/css?family=Fira+Sans%3a300%2c400%2c500%2c700%2c300italic%2c400italic%2c500italic%2c700italic%7cRoboto%3a400%2c300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{ asset('/css/app2.css') }}">
<link rel="stylesheet" href="/ajax/libs/select2/4.0.0/css/select2.min.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('header')
</head>
<body>
<div id="wrap">
	<nav class="navbar navbar-default" style="border: 1px solid red;">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">{{ strtoupper(trans('messages.posaderos')) }}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if (!Auth::guest())
                    @if (Auth::user()->can('see-all-people') || Auth::user()->can('see-new-people'))
                        <ul class="nav navbar-nav">
                            <li><a href="{{ url('/person') }}">
                                    <i class="glyphicon glyphicon-user iconos-menu"></i>
                                    {{ trans('messages.people') }}
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('see-all-interactions') || Auth::user()->can('see-new-interactions'))
                        <ul class="nav navbar-nav">
                            <li><a href="{{ url('/interaction') }}">
                                    <i class="glyphicon glyphicon-edit iconos-menu"></i>
                                    {{ trans('messages.interactions') }}
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('see-users'))
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ url('/user') }}">
                                    <i class="glyphicon glyphicon-lock iconos-menu"></i>
                                    {{ trans('messages.users') }}
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->hasRole('admin') && Agent::isDesktop())
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="glyphicon glyphicon-list iconos-menu"></i>
                                    {{ trans('messages.reports') }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ action('ReportController@peopleList') }}">
                                            {{ trans('messages.peopleReport') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('ReportController@interactionsList') }}">
                                            {{ trans('messages.interactionsReport') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('ReportController@usersList') }}">
                                            {{ trans('messages.usersReport') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('add-person'))
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ action('PersonController@create') }}">
                                    <i class="glyphicon glyphicon-plus iconos-menu"></i>
                                    {{ trans('messages.newPerson') }}
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('see-people-search-view') || Auth::user()->can('see-interactions-search-view') || Auth::user()->can('see-users-search-view'))
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ url('/search/searchView') }}">
                                    <i class="glyphicon glyphicon-search iconos-menu"></i>
                                    {{ trans('messages.find') }}
                                </a>
                            </li>
                        </ul>
                    @endif
                @endif

				<ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">{{ trans('messages.login') }}</a></li>
                        <li><a href="{{ url('/auth/register') }}">{{ trans('messages.register') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: #ffffff">
                                <img src="{{ Auth::user()->gravatar() }}" class="img-circle" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" style="width: 20px; height: 20px;"> {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ action('UserController@show',Auth::user()->id) }}">
                                        <i class="glyphicon glyphicon-home iconos-menu"></i>
                                        {{ trans('messages.myProfile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ action('UserController@changePassword', Auth::user()->id) }}">
                                        <i class="glyphicon glyphicon-cog iconos-menu"></i>
                                        {{ trans('messages.changePassword') }}
                                    </a>
                                </li>
                                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('posadero') || Auth::user()->hasRole('explorer'))
                                    <li>
                                        <a href="{{ action('UserController@derivations', Auth::user()->id) }}">
                                            <i class="glyphicon glyphicon-bell iconos-menu"></i>
                                            {{ trans('messages.derivations') }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ action('TagController@index') }}">
                                        <i class="glyphicon glyphicon-tag iconos-menu"></i>
                                        {{ trans('messages.tags') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ action('UserController@favorites', Auth::user()->id) }}">
                                        <i class="glyphicon glyphicon-star iconos-menu"></i>
                                        {{ trans('messages.favorites') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/auth/logout') }}">
                                        <i class="glyphicon glyphicon-log-out iconos-menu"></i>
                                        {{ trans('messages.logout') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<script src="/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!--	<script src="http://code.jquery.com/jquery.js"></script> -->
	<script src="/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
</div>{{-- end of wrapper --}}
<div id="footer">
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-4" style="width: 32.5%">
        <img src="{{ asset('/img/lumencor2.png') }}" style="margin: 4% auto auto auto" alt="Logo" />
    </div>
    <div class="col-sm-4" style="overflow: hidden">
        <div class="row" style="margin-top: 5%; margin-left: 18%; margin-right: 18%">
            <div class="col-sm-4">
	            <a href="https://twitter.com/lumen_cor" target="_blank"><img src="{{ asset('/img/twitter.png') }}" alt="Twitter" class="circle socialmedia" style="margin: 0 auto; display: table;" /></a>
            </div>
            <div class="col-sm-4">
	            <a href="https://www.facebook.com/lumen.cor" target="_blank"><img src="{{ asset('/img/facebook.png') }}" alt="Facebook" class="circle socialmedia" style="margin: 0 auto; display: table;" /></a>
            </div>
            <div class="col-sm-4">
	            <a href="mailto:posaderos@lumencor.com.ar"><img src="{{ asset('/img/mail.png') }}" class="circle socialmedia" alt="mail" style="margin: 0 auto; display: table;" /></a>
            </div>
        </div>
    </div>
    <div class="col-sm-4" style="width: 32.5%">
        <h5 style="text-align: center; margin-top: 6%;"><strong>El corazón es luz.</strong> Al servicio de los necesitados</h5>
    </div>
  </div>
</div>
 @yield('footer')
</div>
<script>
$('div.alert').not('.alert-important').delay(3000).slideUp(300);
</script>
</body>
</html>
