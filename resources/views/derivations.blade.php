@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td>
                                @if (Auth::user()->hasRole('admin'))
                                    <h4>Derivaciones pendientes</h4>
                                @else
                                    <h4>{{ $userShown->name }} - Derivaciones pendientes</h4>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                @include('interaction.list_interactions',['interactions' => $interactions])
                @include('paginator',['paginator' => $paginator])
            </div>
        </div>
    </div>

@endsection