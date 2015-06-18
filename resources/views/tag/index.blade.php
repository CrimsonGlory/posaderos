@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel-group" role="tablist" aria-multiselectable="false">
                    <div class="panel panel-default">
                        <script src="{{ asset('js/confirmDelete.js') }}"></script>
                        @include('flash::message')
                        <div class="panel-heading">
                            <table width="100%">
                                <tr>
                                    <td><h4>{{ trans('messages.tags') }}</h4></td>
                                    @if (Auth::user()->can('add-tag'))
                                        <td align="right">
                                            <a class="btn btn-primary" href="{{ action('TagController@create') }}" style="width:85px;">
                                                {{ trans('messages.add') }}
                                            </a>
                                        </td>
                                        <td style="width:10px;"></td>
                                    @endif
                                </tr>
                            </table>
                        </div>

                        @if (count($tags) > 0)
                            <div class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <table width="100%" align="center" class="table table-striped">
                                            @foreach ($tags as $tag)
                                                <tr>
                                                    <td>
                                                        <a href="{{ action('TagController@show',$tag->name) }}">
                                                            {{ $tag->name }}
                                                        </a>
                                                    </td>
                                                    <td align="right">
                                                        <table>
                                                            <tr>
                                                                @if (Auth::user()->hasRole('admin'))
                                                                    <td>
                                                                        <a class="btn btn-primary" href="{{ action('TagController@edit',$tag->id) }}">
                                                                            <i class="glyphicon glyphicon-pencil"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <div style="width:5px;"></div>
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::open(array('route' => array('tag.destroy', $tag->id), 'method' => 'delete', 'onsubmit' => 'return confirmDeleteTag()')) !!}
                                                                        <button type="submit" class="btn btn-danger">
                                                                            <i class="glyphicon glyphicon-remove"></i>
                                                                        </button>
                                                                        {!! Form::close() !!}
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <div>{{ trans('messages.noTags') }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @include('paginator',['paginator' => $paginator])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
