<div class="form-group">
    <label class="col-md-4 control-label">Tipo de exportación</label>
    <div class="col-md-6">
        {!! Form::select('exportTypes', array('pdf'=>'Formato PDF','csv'=>'Formato CSV'), 'pdf', array('class' => 'form-control')) !!}
    </div>
</div>