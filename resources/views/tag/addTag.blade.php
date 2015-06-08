@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.addTag') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(array('method' => 'POST', 'class' => 'form-horizontal', 'action' => array('TagController@store'))) !!}
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.tag') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="tag" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary form-control"  style="width:100px;">{{ trans('messages.save') }}</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('TagController@index') }}" class="btn btn-primary" style="width:100px;">{{ trans('messages.cancel') }}</a></td>
                                    </tr>
                                </table>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
