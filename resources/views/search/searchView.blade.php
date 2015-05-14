@extends('app')
@section('content')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false" style="min-width:550px;">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>Búsqueda avanzada</h4></td>
                        </tr>
                    </table>
                </div>

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

                <div class="panel-body">
                    <div class="form-group">
                        <table width="100%">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-btn search-panel" role="search">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            <span id="search_concept">¿Búsqueda?</span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @if (Auth::user()->can('see-people-search-view'))
                                                <li><a href="#person">Asistidos</a></li>
                                            @endif
                                            @if (Auth::user()->can('see-interactions-search-view'))
                                                <li><a href="#interaction">Interacciones</a></li>
                                            @endif
                                            @if (Auth::user()->can('see-users-search-view'))
                                                <li><a href="#user">Usuarios</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <input type="hidden" name="search_param" value="Interaccion" id="search_param">
                                    <input type="text" id="keyWord" class="form-control" name="x" placeholder="buscar..." autofocus="true">
                                    <span class="input-group-btn">
                                        <button id="search" class="btn btn-default" type="button" onClick="buscar()"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                                </div>
                            </div>
                            </br></br>
                            <div class="col-md-12" id="resultado"></div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
