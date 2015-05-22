@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Actualizar interacción con {{ $person->first_name }} {{ $person->last_name }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($interaction,['class' => 'form-horizontal', 'method' => 'PATCH', 'action' => ['InteractionController@update', $interaction->id]]) !!}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Descripción</label>
                                <div class="col-md-6">
                                    <textarea type="text" class="form-control" name="text" style="height:150px;" autofocus="true">{{ $interaction->text }}</textarea>
                                </div>
                            </div>
                            {!! Form::hidden('person_id', $interaction->person_id) !!}

                            <div class="form-group">
                                <label class="col-md-4 control-label">Fecha</label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date" value="{{ $interaction->date }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Etiquetas</label>
                                <div class="col-md-6">
                                    {!! Form::select('tags[]', all_tags(), $interaction->tagNames(), ['id' => 'tags','class' => 'form-control','multiple']) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Estado de la interacción</label>
                                <div class="col-md-6">
                                    {!! Form::select('fixed', array(0 => 'Pendiente', 1 => 'Finalizada'), $interaction->fixed, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <table width="100%">
                                    <tr>
                                        <td align="right"><button type="submit" class="btn btn-primary form-control"  style="width:100px;">Guardar</button></td>
                                        <td width="20"></td>
                                        <td align="left"><a href="{{ action('PersonController@show', $interaction->person_id) }}" class="btn btn-primary" style="width:100px;">Cancelar</a></td>
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

@stop
