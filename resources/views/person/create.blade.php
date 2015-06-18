@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ trans('messages.savePerson') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('person') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.firstName') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" value="{{ $firstName }}" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.lastName') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.dni') }}</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="dni" value="{{ $dni }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.birthdate') }}</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="birthdate" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.gender') }}</label>
                                <div class="col-md-6">
                                    <select name="gender" class="form-control">
                                        <option value="male">{{ trans('messages.male') }}</option>
                                        <option value="female">{{ trans('messages.female') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.email') }}</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.address') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.phone') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.tags') }}</label>
                                <div class="col-md-6">
                                    {!! Form::select('tags[]', all_tags(), '', ['id' => 'tags','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.observations') }}</label>
                                <div class="col-md-6">
                                    <textarea type="text" class="form-control" name="other" value="{{ old('other') }}"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary"  style="width:100px;">{{ trans('messages.save') }}</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('PersonController@index') }}" class="btn btn-primary"  style="width:100px;">{{ trans('messages.cancel') }}</a></td>
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

@section('footer')
    @include('tag.select2')
@endsection
