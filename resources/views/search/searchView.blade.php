@extends('app')
@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
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
                        $('.search-panel .dropdown-menu').find('a').click(function(e){
                            e.preventDefault();
                            var param = $(this).text();
                            $('.search-panel span#search_concept').text(param);
                            $('.input-group #search_param').text(param);
                        });
                    });

                    function buscar(){
                        var k = $('#keyWord').val();
                        var tf = $('#search_param').text();
                        if(document.getElementById('search_concept').textContent == 'Asistidos'){
                            tf = 'Asistidos';
                        }
                        $.get("/search/search", { toFind: tf, key: k })
                                .done(function(data){
                                    $('#resultado').html("");
                                    $('#resultado').html(data);
                                });
                    }

                    function enterPressAction(e){
                        var code = (e.keyCode ? e.keyCode : e.which);
                        //Enter keycode
                        if(code == 13){
                            buscar();
                        }
                    }

                    function createPersonWithParam(){
                        $param = document.getElementById('keyWord').value;
                        window.location.href = window.location.protocol + '//' + window.location.host + '/person/create?param=' + $param;
                    }
                </script>

                <div class="panel-body">
                    <div class="input-group">
                        <div class="input-group-btn search-panel" role="search">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                @if (Auth::user()->can('see-people-search-view'))
                                    <span id="search_concept">Asistidos</span>
                                @else
                                    <span id="search_concept">¿Búsqueda?</span>
                                @endif
                                <span class="caret"></span>
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
                        <input type="hidden" name="search_param" id="search_param">
                        <input type="text" id="keyWord" class="form-control" name="x" placeholder="buscar..." autofocus="true" onkeypress="enterPressAction(event)">
                        <span class="input-group-btn">
                            <button id="search" class="btn btn-default" type="button" onClick="buscar()"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>

                <div class="panel-collapse collapse in" id="resultado"></div>
            </div>
        </div>
    </div>

@endsection
