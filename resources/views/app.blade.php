<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Posaderos</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('header')
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">Posaderos</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if (!Auth::guest())
                    @if (Auth::user()->can('see-all-people') || Auth::user()->can('see-new-people'))
                        <ul class="nav navbar-nav">
                            <li><a href="{{ url('/person') }}">
                                    <i class="glyphicon glyphicon-user"></i>
                                    Asistidos
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('see-all-interactions') || Auth::user()->can('see-new-interactions'))
                        <ul class="nav navbar-nav">
                            <li><a href="{{ url('/interaction') }}">
                                    <i class="glyphicon glyphicon-edit"></i>
                                    Interacciones
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('see-users'))
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ url('/user') }}">
                                    <i class="glyphicon glyphicon-lock"></i>
                                    Usuarios
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('add-person'))
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ action('PersonController@create') }}">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Nuevo asistido
                                </a>
                            </li>
                        </ul>
                    @endif

                    @if (Auth::user()->can('see-people-search-view') || Auth::user()->can('see-interactions-search-view') || Auth::user()->can('see-users-search-view'))
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ url('/search/searchView') }}">
                                    <i class="glyphicon glyphicon-search"></i>
                                    Buscar
                                </a>
                            </li>
                        </ul>
                    @endif
                @endif

				<ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                        <li><a href="{{ url('/auth/register') }}">Regístrate</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img src="{{ Auth::user()->gravatar() }}" class="img-circle" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" style="width: 20px; height: 20px;"> {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ action('UserController@show',Auth::user()->id) }}">
                                        <i class="glyphicon glyphicon-home"></i>
                                        Mi perfil
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ action('UserController@edit', Auth::user()->id) }}">
                                        <i class="glyphicon glyphicon-cog"></i>
                                        Editar cuenta
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/auth/logout') }}">
                                        <i class="glyphicon glyphicon-log-out"></i>
                                        Logout
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

	<!-- Scripts -->
	<script src="/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<!--	<script src="http://code.jquery.com/jquery.js"></script> -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@yield('footer')
<script>
$('div.alert').not('.alert-important').delay(3000).slideUp(300);
</script>
</body>
</html>
