@if ($data['error'] == trans('messages.searchErrorNumber'))
    <div class="panel-body">
        <ul class="alert alert-danger">
            <label>{{ trans('messages.searchError') }}</label>
        </ul>
    </div>
@elseif ($data['error'] == trans('messages.maxSearchResultsNumber'))
    <div class="panel-body">
        <ul class="alert alert-danger">
            <label>{{ trans('messages.maxSearchResultsMessage') }}</label>
        </ul>
    </div>
@elseif (!is_null($people))
    @if (count($people) > 0)
        @include('person.list_people',['people' => $people])
    @else
        <div class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="form-group">
                    <div>{{ trans('messages.noPeopleResults') }}</div>
                </div>
                <div class="form-group">
                    <a class="btn btn-primary" onclick="createPersonWithParam()">
                        <i class="glyphicon glyphicon-plus"></i>
                        {{ trans('messages.addPerson') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
@elseif (!is_null($interactions))
    @include('interaction.list_interactions',['interactions' => $interactions])
@elseif (!is_null($users))
    @include('user.list_users',['users' => $users])
@endif
