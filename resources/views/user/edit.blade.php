@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.updateUser') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($userShown, ['class' => 'form-horizontal', 'method'=> 'PATCH', 'action' => ['UserController@update',$userShown->id]]) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.firstName') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ $userShown->name }}" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.email') }}</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $userShown->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.phone') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" value="{{ $userShown->phone }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.tags') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('tags[]', all_tags(), $userShown->tagNames(), ['id' => 'tags','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            @if ($userShown->id != Auth::user()->id)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ trans('messages.userRole') }}</label>
                                    <div class="col-md-6">
                                        @if ($userShown->roles() != NULL && $userShown->roles()->first() != NULL)
                                            {!! Form::select('role', array('admin' => trans('messages.admin'), 'posadero' => trans('messages.posadero'), 'explorer' => trans('messages.explorer'), 'new-user' => trans('messages.newUser')), $userShown->roles()->first()->name, array('class' => 'form-control')) !!}
                                        @else
                                            {!! Form::select('role', array('admin' => trans('messages.admin'), 'posadero' => trans('messages.posadero'), 'explorer' => trans('messages.explorer'), 'new-user' => trans('messages.newUser')), 'new-user', array('class' => 'form-control')) !!}
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary" style="width:100px;">{{ trans('messages.save') }}</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('UserController@show', $userShown->id) }}" class="btn btn-primary" style="width:100px;">{{ trans('messages.cancel') }}</a></td>
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

@section('footer')
    @include('tag.select2')
@endsection
