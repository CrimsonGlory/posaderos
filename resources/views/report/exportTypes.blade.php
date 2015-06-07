<div class="form-group">
    <label class="col-md-4 control-label">{{ trans('messages.exportType') }}</label>
    <div class="col-md-6">
        {!! Form::select('exportType', array('csv' => trans('messages.csvFormat'), 'pdf' => trans('messages.pdfFormat'), 'xls' => trans('messages.xlsFormat'), 'xlsx' => trans('messages.xlsxFormat')), 'pdf', array('class' => 'form-control')) !!}
    </div>
</div>
