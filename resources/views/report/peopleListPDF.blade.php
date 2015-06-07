@if ($people != null && count($people) > 0)
    <div class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <h1 align="center">{{ trans('messages.peopleList') }}</h1>
                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            <label style="font:bold;">{{ trans('messages.fromDate') }}:</label> {{ $fromDate }}
                        </td>
                        <td style="width:50%">
                            <label style="font:bold;">{{ trans('messages.toDate') }}:</label> {{ $toDate }}
                        </td>
                    </tr>
                </table>

                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            @if ($gender != 'select')
                                <label style="font:bold;">{{ trans('messages.gender') }}:</label>
                                {{ trans('messages.'.$gender) }}
                            @endif
                        </td>
                        <td style="width:50%">
                            @if ($users != null && count($users) > 0)
                                <label style="font:bold;">{{ trans('messages.createdBy') }}:</label>
                                @foreach($users as $idUser)
                                    {{ getUserName($idUser) }},
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            @if ($tags != null && count($tags) > 0)
                                <label style="font:bold;">{{ trans('messages.tags') }}:</label>
                                @foreach($tags as $tag)
                                    {{ $tag }},
                                @endforeach
                            @endif
                        </td>
                        <td style="width:50%">
                        </td>
                    </tr>
                </table>

                <table class="table table-striped" cellpadding="2" cellspacing="1" width="100%">
                    <thead>
                        <tr>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.date') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.person') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.dni') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.age') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.address') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.createdBy') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.tags') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($people as $person)
                            <tr>
                                <td style="border-bottom:1px solid black;">{{ date("d/m/Y", strtotime($person->created_at)) }}</td>
                                <td style="border-bottom:1px solid black;">{{ $person->name() }}</td>
                                <td style="border-bottom:1px solid black;">{{ $person->dni }}</td>
                                <td style="border-bottom:1px solid black;">
                                    @if ($person->birthdate != null)
                                        {{date_diff(date_create($person->birthdate), date_create('today'))->y}}
                                        años
                                    @endif
                                </td>
                                <td style="border-bottom:1px solid black;">{{ $person->address }}</td>
                                <td style="border-bottom:1px solid black;">{{ getUserName($person->created_by) }}</td>
                                <td style="border-bottom:1px solid black;">
                                    @if (count($person->tagNames()) > 0)
                                        @foreach ($person->tagNames() as $tag)
                                            {{ $tag }},
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <table width="100%">
                    <tr>
                        <td>
                            <div>
                                {{ trans('messages.noPeople') }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
