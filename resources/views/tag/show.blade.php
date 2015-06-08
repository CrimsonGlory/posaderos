@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ $tagName }} - {{ trans('messages.lastPeople') }}</h4></td>
                            </tr>
                        </table>
                    </div>
                    @include('person.list_people',['people' => $people])
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ $tagName }} - {{ trans('messages.lastInteractions') }}</h4></td>
                            </tr>
                        </table>
                    </div>
                    @include('interaction.list_interactions',['interactions' => $interactions])
                </div>
            </div>
        </div>
    </div>

@endsection
