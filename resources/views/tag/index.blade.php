@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ trans('messages.tags') }}</h4></td>
                            </tr>
                        </table>
                    </div>

                    @if (count($tags) > 0)
                        <table width="100%" align="center" class="table table-striped">
                            @foreach ($tags as $tag)
                                <tr>
                                    <td>
                                        <a href="{{ action('TagController@show',$tag) }}">
                                            {{ ucfirst($tag) }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
