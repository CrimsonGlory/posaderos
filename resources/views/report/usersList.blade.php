@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Listado de usuarios</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(array('method' => 'POST', 'class' => 'form-horizontal', 'action' => array('ReportController@downloadUsersList'))) !!}
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
                                <label class="col-md-4 control-label">Tipo de usuario</label>
                                <div class="col-md-6">
                                    {!! Form::select('role', array('select'=>'- Seleccionar -','admin'=>'Administrador','posadero'=>'Posadero','explorer'=>'Explorador','new-user'=>'Nuevo usuario'), 'select', array('class' => 'form-control')) !!}
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
    @include('tag.select2List')
@endsection

@stop
