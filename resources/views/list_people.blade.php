@if (count($people) )
<div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="personasCreadasPorUsuario" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="PersonasCreadas">
                    <table width="100%">
                        <tr>
                            <td><h4>Personas dadas de alta por {{ $username }}</h4></td>
                        </tr>
                    </table>
                </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="form-group">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Otro</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $personNum=0; ?>
                                        @foreach ($people as $person)
                                            <?php $personNum=$personNum + 1; ?>
                                            <tr>
                                                <th scope="row">{{$personNum}}</th>
                                                <th>
                                                    <a href="{{ action('PersonController@show',$person->id) }}">
                                                        {{$person->name()}} 
                                                    </a>
                                                </th>
                                                <th>{{$person->address}}</th>
                                                <th>{{$person->other}}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


