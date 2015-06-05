@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Listado de asistidos</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(array('method' => 'POST', 'class' => 'form-horizontal', 'action' => array('ReportController@downloadPeopleList'))) !!}
                            <div class="form-group">
                                <label class="col-md-4 control-label">Desde fecha</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="fromDate" value="{{ date('Y-m-01') }}" autofocus="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Hasta fecha</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="toDate" value="{{ date("Y-m-t", strtotime(date('Y-m-d'))) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Sexo</label>
                                <div class="col-md-6">
                                    {!! Form::select('gender', array('select' => '- Seleccionar -', 'male' => 'Hombre', 'female' => 'Mujer'), 'select', array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Asistidos creados por</label>
                                <div class="col-md-6">
                                    {!! Form::select('users[]', all_users(), '', ['id' => 'users','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Etiquetas</label>
                                <div class="col-md-6">
                                    {!! Form::select('tags[]', all_tags(), '', ['id' => 'tags','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            @include('report/exportTypes')

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        Descargar
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
    @include('user.select2List')
    @include('tag.select2List')
@endsection

@stop
