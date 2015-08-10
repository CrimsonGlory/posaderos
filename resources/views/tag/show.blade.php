@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <h4>{{ $tagName }}</h4></td>
                </div>

                @include('interaction.list_interactions',['interactions' => $interactions])
                @include('paginator',['paginator' => $paginator])
            </div>
        </div>
    </div>

@endsection
