@if ($interactions != null && count($interactions) > 0)
    <div class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="form-group">
                <h1 align="center">{{ trans('messages.interactionsList') }}</h1>
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
                            @if ($fixed != -1)
                                <label style="font:bold;">{{ trans('messages.interactionState') }}:</label>
                                {{ trans('messages.'.$fixed) }}
                            @endif
                        </td>
                        <td style="width:50%">
                            @if ($people != null && count($people) > 0)
                                <label style="font:bold;">{{ trans('messages.person') }}:</label>
                                @foreach($people as $idPerson)
                                    {{ getPersonName($idPerson) }},
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <table style="width:100%">
                    <tr>
                        <td style="width:50%">
                            @if ($users != null && count($users) > 0)
                                <label style="font:bold;">{{ trans('messages.createdBy') }}:</label>
                                @foreach($users as $idUser)
                                    {{ getUserName($idUser) }},
                                @endforeach
                            @endif
                        </td>
                        <td style="width:50%">
                            @if ($tags != null && count($tags) > 0)
                                <label style="font:bold;">{{ trans('messages.tags') }}:</label>
                                @foreach($tags as $tag)
                                    {{ $tag }},
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>

                <table class="table table-striped" cellpadding="2" cellspacing="1" width="100%">
                    <thead>
                        <tr>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.date') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.person') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.description') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.state') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.createdBy') }}</td>
                            <td style="font:bold; border-bottom:1px solid black;">{{ trans('messages.tags') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interactions as $interaction)
                            <tr>
                                <td style="border-bottom:1px solid black;">{{ date("d/m/Y", strtotime($interaction->date)) }}</td>
                                <td style="border-bottom:1px solid black;">{{ getPersonName($interaction->person_id) }}</td>
                                <td style="border-bottom:1px solid black;">{{ $interaction->text }}</td>
                                <td style="border-bottom:1px solid black;">{{ trans('messages.'.$interaction->fixed) }}</td>
                                <td style="border-bottom:1px solid black;">{{ getUserName($interaction->user_id) }}</td>
                                <td style="border-bottom:1px solid black;">
                                    @if (count($interaction->tagNames()) > 0)
                                        @foreach ($interaction->tagNames() as $tag)
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
                                {{ trans('messages.noInteractions') }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endif
