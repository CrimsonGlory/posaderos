@if (count($people))
    @if (Agent::isDesktop())
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.photo') }}</th>
                                <th>{{ trans('messages.firstName') }}</th>
                                <th>{{ trans('messages.dni') }}</th>
                                <th>{{ trans('messages.age') }}</th>
                                <th>{{ trans('messages.address') }}</th>
                                <th>{{ trans('messages.phone') }}</th>
                                <th>{{ trans('messages.tags') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($people as $person)
                            <tr>
                                <th scope="row">
                                    @if ($person->get_avatar != null)
                                        <img src="{{ action("FileEntryController@thumb",[50,$person->get_avatar]) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @else
                                        <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ action('PersonController@show',$person->id) }}">
                                        {{$person->name()}}
                                    </a>
                                </th>
                                <th>{{$person->dni}}</th>
                                <th>
                                    @if ($person->birthdate != null)
                                        {{date_diff(date_create($person->birthdate), date_create('today'))->y}}
                                        {{ trans('messages.years') }}
                                    @endif
                                </th>
                                <th>{{$person->address}}</th>
                                <th>{{$person->phone}}</th>
                                <th>
                                    @if (count($person->tagNames()) > 0)
                                        @include('tag.list_tags',['tagNames' => $person->tagNames()])
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.photo') }}</th>
                                <th>{{ trans('messages.firstName') }}</th>
                                <th>{{ trans('messages.dni') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($people as $person)
                            <tr>
                                <th scope="row">
                                    @if ($person->get_avatar != null)
                                        <img src="{{ action("FileEntryController@thumb",[50,$person->get_avatar]) }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @else
                                        <img src="{{ asset("no-photo.png") }}" alt="" class="img-circle" style="max-width:50px; max-height:50px;"/>
                                    @endif
                                </th>
                                <th>
                                    <a href="{{ action('PersonController@show',$person->id) }}">
                                        {{$person->name()}}
                                    </a>
                                </th>
                                <th>{{$person->dni}}</th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@else
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table width="100%">
                    <tr>
                        <td>
                            <div>{{ trans('messages.noPeople') }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
