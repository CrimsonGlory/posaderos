@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>Asistidos</h4></td>
                            <td align="right"><a class="btn btn-primary" href="{{ action('PersonController@create') }}" style="width:80px;">Agregar</a></td>
                        </tr>
                    </table>
                </div>

                @include('person.list_people',['people' => $people])

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
