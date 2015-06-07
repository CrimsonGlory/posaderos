@extends('app')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <table width="100%">
                        <tr>
                            <td><h4>{{ $userShown->name }} - {{ trans('messages.favorites') }}</h4></td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @include('person.list_people',['people' => $people])
                    @include('paginator',['paginator' => $paginator])
                </div>
            </div>
        </div>
    </div>

@endsection
