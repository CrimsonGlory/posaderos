@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                @include('flash::message')
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>{{ trans('messages.people') }} ({{ $peopleCount }})</h4></td>
                            <td align="right"><a class="btn btn-primary" href="{{ action('PersonController@create') }}" style="width:80px;">{{ trans('messages.add') }}</a></td>
                        </tr>
                    </table>
                </div>

                @include('person.list_people',['people' => $people])
                @include('paginator',['paginator' => $paginator])
            </div>
        </div>
    </div>

@endsection
