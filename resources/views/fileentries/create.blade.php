@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.saveFilesOf') }} {{ $person->first_name }} {{ $person->last_name }}</h4>
                    </div>
                    <div class="panel-body">
			            @include('flash::message')
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (Session::get('uploadError'))
                            <ul class="alert alert-danger">
                                <li>{{ trans('messages.maxSizeFile') }}</li>
                            </ul>
                        @endif

                        <form class="form-horizontal" method="POST" action="{{ url('person/'.$person->id.'/fileentries') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group" align="center">
					            {!! Form::file('files[]', array('multiple' => true)) !!}
                            </div>
                            {!! Form::hidden('person_id', $person->id) !!}

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary form-control"  style="width:100px;">{{ trans('messages.save') }}</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('PersonController@show', $person->id) }}" class="btn btn-primary" style="width:100px;">{{ trans('messages.cancel') }}</a></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
