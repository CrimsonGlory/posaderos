@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <h4>{{ $userShown->name }} - {{ trans('messages.favorites') }}</h4>
                </div>

                @include('person.list_people',['people' => $people])
                @include('paginator',['paginator' => $paginator])
            </div>
        </div>
    </div>

@endsection
