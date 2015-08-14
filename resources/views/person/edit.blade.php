@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.updatePerson') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($person, ['class' => 'form-horizontal', 'method'=> 'PATCH', 'action' => ['PersonController@update', $person->id]]) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.firstName') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" value="{{ $person->first_name }}" maxlength="255" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.lastName') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" value="{{ $person->last_name }}" maxlength="255">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.dni') }}</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="dni" value="{{ $person->dni }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.birthdate') }}</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="birthdate" value="{{ $person->birthdate }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.gender') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('gender', array('male' => trans('messages.male'), 'female' => trans('messages.female')), $person->gender, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.email') }}</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ $person->email }}" maxlength="255">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.address') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{ $person->address }}" maxlength="255">
                                </div>
                            </div>

			                <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.phone') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" value="{{ $person->phone }}" maxlength="255">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.tags') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('tags[]', all_tags(), $person->tagNames(), ['id' => 'tags','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.observations') }}</label>
                                <div class="col-md-6">
                                    <textarea type="text" class="form-control" name="other" maxlength="255">{{ $person->other }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary" style="width:100px;">{{ trans('messages.save') }}</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('PersonController@show', $person->id) }}" class="btn btn-primary" style="width:100px;">{{ trans('messages.cancel') }}</a></td>
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
