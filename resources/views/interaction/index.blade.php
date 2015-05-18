@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>Interacciones</h4></td>
                        </tr>
                    </table>
                </div>

                @include('interaction.list_interactions',['interactions' => $interactions])

                @if ($paginator->hasPrevPage || $paginator->hasNextPage)
                    <div class="panel-body">
                        <table width="100%">
                            <tr>
                                <td align="right">
                                    <nav>
                                        <ul class="pagination">
                                            {!! $paginator->renderBootstrap('<', '>') !!}
                                        </ul>
                                    </nav>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
