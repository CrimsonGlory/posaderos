@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Guardar interacción con {{ $person->first_name }} {{ $person->last_name }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('person/'.$person->id.'/interaction') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Descripción</label>
                                <div class="col-md-6">
                                    <textarea type="text" class="form-control" name="text" style="height:150px;" autofocus="true"></textarea>
                                </div>
                            </div>
                            {!! Form::hidden('person_id', $person->id) !!}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Derivar a</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="destination" placeholder="alguien@ejemplo.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary form-control"  style="width:100px;">Guardar</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('PersonController@show', $person->id) }}" class="btn btn-primary" style="width:100px;">Cancelar</a></td>
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

@stop