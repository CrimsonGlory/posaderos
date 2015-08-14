@extends('app')
@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>{{ trans('messages.advancedSearch') }}</h4></td>
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

                    function buscar(searchConcept){
                        var k = $('#keyWord').val();
                        var tf = $('#search_param').text();
                        if(document.getElementById('search_concept').textContent == searchConcept){
                            tf = searchConcept;
                        }
                        $.get("/search/search", { toFind: tf, key: k })
                                .done(function(data){
                                    $('#resultado').html("");
                                    $('#resultado').html(data);
                                });
                    }

                    function enterPressAction(e, searchConcept){
                        var code = (e.keyCode ? e.keyCode : e.which);
                        //Enter keycode
                        if(code == 13){
                            buscar(searchConcept);
                        }
                    }

                    function createPersonWithParam(){
                        $param = document.getElementById('keyWord').value;
                        window.location.href = window.location.protocol + '//' + window.location.host + '/person/create?param=' + $param;
                    }
                </script>

                <?php
                    $people = trans('messages.people');
                ?>

                <div class="panel-body">
                    <div class="input-group">
                        <div class="input-group-btn search-panel" role="search">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                @if (Auth::user()->can('see-people-search-view'))
                                    <span id="search_concept">{{ trans('messages.people') }}</span>
                                @else
                                    <span id="search_concept">{{ trans('messages.search') }}</span>
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                @if (Auth::user()->can('see-people-search-view'))
                                    <li><a href="#person">{{ trans('messages.people') }}</a></li>
                                @endif
                                @if (Auth::user()->can('see-interactions-search-view'))
                                    <li><a href="#interaction">{{ trans('messages.interactions') }}</a></li>
                                @endif
                                @if (Auth::user()->can('see-users-search-view'))
                                    <li><a href="#user">{{ trans('messages.users') }}</a></li>
                                @endif
                            </ul>
                        </div>
                        <input type="hidden" name="search_param" id="search_param">
                        <input type="text" id="keyWord" class="form-control" name="x" placeholder="{{ trans('messages.find') }}..." autofocus="true" onkeypress="enterPressAction(event, '<?php echo $people ?>')">
                        <span class="input-group-btn">
                            <button id="search" class="btn btn-default" type="button" onClick="buscar('<?php echo $people ?>')"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>

                <div class="panel-collapse collapse in" id="resultado"></div>
                    <br />
                    <br />
                    <br />
            </div>
        </div>
    </div>

@endsection
