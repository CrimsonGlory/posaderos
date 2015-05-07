@extends('app')
@section('content')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        $(document).ready(function(e){
            $('.search-panel .dropdown-menu').find('a').click(function(e) {
                e.preventDefault();
                var param = $(this).text();
                $('.search-panel span#search_concept').text(param);
                $('.input-group #search_param').text(param);
            });
        });
        function buscar(){
        var k = $('#keyWord').val();
        var tf = $('#search_param').text();
        $.get( "/search/search", { toFind: tf, key: k } )
          .done(function( data ) {
            $('#resultado').html("");
            $('#resultado').html(data);
          });
        }
    </script>

    <div class="container">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="input-group">
                    <div class="input-group-btn search-panel" role="search">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept">¿Qué desea buscar?</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#user">Asistidos</a></li>
                          <li><a href="#person">Interacciones</a></li>
                          <li><a href="#interaction">Usuarios</a></li>
                        </ul>
                    </div>
                    <input type="hidden" name="search_param" value="Interaccion" id="search_param">
                    <input type="text" id="keyWord" class="form-control" name="x" placeholder="buscar...">
                    <span class="input-group-btn">
                        <button id="search" class="btn btn-default" type="button" onClick="buscar()"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>
        </br></br></br>
        <div class="col-md-9" id="resultado">
        </div>
    </div>

@endsection
