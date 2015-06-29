@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="ultimasPersonasAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasPersonas">
                    <h4>
                        <a class="panel-title" data-toggle="collapse" data-parent="#ultimasPersonasAgregadas" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ $tagName }} - {{ trans('messages.lastPeople') }}
                        </a>
                    </h4>
                </div>
                @include('person.list_people',['people' => $people])
            </div>
        </div>

        <div class="panel-group" id="ultimasInteraccionesAgregadas" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="UltimasInteracciones">
                    <h4>
                        <a class="panel-title" data-toggle="collapse" data-parent="#ultimasInteraccionesAgregadas" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            {{ $tagName }} - {{ trans('messages.lastInteractions') }}
                        </a>
                    </h4>
                </div>
                @include('interaction.list_interactions',['interactions' => $interactions])
            </div>
        </div>
    </div>

@endsection
