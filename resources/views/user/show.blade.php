@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <script src="{{ asset('js/confirmDelete.js') }}"></script>
			        @include('flash::message')
                    <div class="panel-heading">
                        <table width="100%">
                            <tr>
                                <td><h4>{{ $userShown->name }}</h4></td>
                                @if (Auth::user()->can('edit-users') || $userShown->id == Auth::user()->id || Auth::user()->hasRole('admin'))
                                    <td align="right">
                                        <table>
                                            <tr>
                                                @if (Auth::user()->can('edit-users') || $userShown->id == Auth::user()->id)
                                                    <td>
                                                        <a class="btn btn-primary" href="{{ action('UserController@edit',$userShown) }}">
                                                            <i class="glyphicon glyphicon-pencil"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                                @if (Auth::user()->hasRole('admin') && $userShown->id != Auth::user()->id)
                                                    <td>
                                                        <div style="width:5px;"></div>
                                                    </td>
                                                    {!! Form::open(array('route' => array('user.destroy', $userShown->id), 'method' => 'delete', 'onsubmit' => 'return confirmDeleteUser()')) !!}
                                                        <td align="right">
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                            </button>
                                                        </td>
                                                    {!! Form::close() !!}
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                @endif
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

                        <form class="form-horizontal" role="form" action="{{ url('person') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group" align="center">
                                <img src="{{ $gravatar }}" alt="" onerror="this.src='{{ asset("no-photo.png") }}';" class="img-circle" style="max-width:150px; max-height:150px;">
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('messages.email') }}</label>
                                <div class="col-md-6">
                                    <label class="form-control" name="email">{{ $userShown->email }}</label>
                                </div>
                            </div>

			                @if ($userShown->phone != null)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ trans('messages.phone') }}</label>
                                    <div class="col-md-6">
                                        <label class="form-control" name="phone">{{ $userShown->phone }}</label>
                                    </div>
                                </div>
                            @endif

                            @if (count($userShown->tagNames()) > 0)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ trans('messages.tags') }}</label>
                                    <div class="col-md-6">
                                        <label class="form-control" style="overflow:auto;">
                                            @include('tag.list_tags',['tagNames' => $userShown->tagNames()])
                                        </label>
                                    </div>
                                </div>
                            @endif

                            @if ($userShown->roles() != NULL && $userShown->roles()->first() != NULL)
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ trans('messages.userRole') }}</label>
                                    <div class="col-md-6">
                                        <label class="form-control" name="rol">{{ $userShown->roles()->first()->display_name }}</label>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1">
        <div class="panel-group" id="personasCreadasPorUsuario" role="tablist" aria-multiselectable="false">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="PersonasCreadas">
                    <table width="100%">
                        <tr>
                            <td><h4>{{ trans('messages.peopleAddedBy') }} {{ $userShown->name }}</h4></td>
                        </tr>
                    </table>
                </div>
                @include('person.list_people',['people' => $people])
                @include('paginator',['paginator' => $paginator])
            </div>
        </div>
    </div>

@endsection
