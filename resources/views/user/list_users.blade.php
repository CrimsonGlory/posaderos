@if (count($users))
    @if (Agent::isDesktop())
        <div id="collapseThree" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.photo') }}</th>
                                <th>{{ trans('messages.firstName') }}</th>
                                <th>{{ trans('messages.email') }}</th>
                                <th>{{ trans('messages.phone') }}</th>
                                <th>{{ trans('messages.userRole') }}</th>
                                <th>{{ trans('messages.tags') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th>
                                        <img src="{{ $user->gravatar() }}" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" class="img-circle" style="max-width:50px; max-height:50px;">
                                    </th>
                                    <th>
                                        <a href="{{ action('UserController@show', $user->id) }}">
                                            {{ $user->name }}
                                        </a>
                                    </th>
                                    <th>{{ $user->email }}</th>
                                    <th>{{ $user->phone }}</th>
                                    <th>
                                        @if ($user->roles() != NULL && $user->roles()->first() != NULL)
                                            {{ $user->roles()->first()->display_name }}
                                        @endif
                                    </th>
                                    @if (count($user->tagNames()) > 0)
                                        <th>
                                            @include('tag.list_tags',['tagNames' => $user->tagNames()])
                                        </th>
                                    @else
                                        <th></th>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div id="collapseThree" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.photo') }}</th>
                                <th>{{ trans('messages.firstName') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th>
                                        <img src="{{ $user->gravatar() }}" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" class="img-circle" style="max-width:50px; max-height:50px;">
                                    </th>
                                    <th>
                                        <a href="{{ action('UserController@show', $user->id) }}">
                                            {{$user->name}}
                                        </a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@else
    <div id="collapseThree" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table width="100%">
                    <tr>
                        <td>
                            <div>{{ trans('messages.noUsers') }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
