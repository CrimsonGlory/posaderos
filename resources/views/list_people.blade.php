@if (count($people) )
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Dirección</th>
                        <th>Otros</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $personNum=0; ?>
                    @foreach ($people as $person)
                        <?php $personNum=$personNum + 1; ?>
                        <tr>
                            <th scope="row">
                                @if ($person->fileentries()!=null && count( $person->fileentries()->get())!=0 )
                                    <img src="{{ action("FileEntryController@show",$person->fileentries()->get()->last()->id ) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                @else
                                    <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                @endif
                            </th>
                            <th>
                                <a href="{{ action('PersonController@show',$person->id) }}">
                                    {{$person->name()}}
                                </a>
                            </th>
                            <th>
                                {{trans('messages.'.$person->gender)}}
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

