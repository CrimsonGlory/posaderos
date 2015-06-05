<div class="form-group">
    <label class="col-md-4 control-label">{{ trans('messages.exportType') }}</label>
    <div class="col-md-6">
        {!! Form::select('exportTypes', array('pdf' => trans('messages.pdfFormat'), 'csv' => trans('messages.csvFormat')), 'pdf', array('class' => 'form-control')) !!}
    </div>
</div>
