@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    @include('flash::message')
                    <div class="panel-heading">
                        <h4>{{ trans('messages.interactionsList') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(array('method' => 'POST', 'class' => 'form-horizontal', 'action' => array('ReportController@downloadInteractionsList'))) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.fromDate') }}</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="fromDate" value="{{ date('Y-m-01') }}" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.toDate') }}</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="toDate" value="{{ date("Y-m-t", strtotime(date('Y-m-d'))) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.interactionState') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('fixed', array(-1 => trans('messages.select'), 0 => trans('messages.pending'), 1 => trans('messages.finished')), -1, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.interactionsWith') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('people[]', all_people(), '', ['id' => 'people','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.interactionsCreatedBy') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('users[]', all_users(), '', ['id' => 'users','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.tags') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('tags[]', all_tags(), '', ['id' => 'tags','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            @include('report/exportTypes')

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        {{ trans('messages.download') }}
                                    </button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('person.select2List')
    @include('user.select2List')
    @include('tag.select2List')
@endsection
