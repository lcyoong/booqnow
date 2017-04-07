<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait">
{{ Form::hidden('rep_function', $type) }}
{{ Form::hidden('rep_class', 'Reports\OccupancyByNationalExcel') }}
<div class="row">
  {{ Form::bsYear("rep_filter[year]", trans('report.pnl_year'), null, ['placeholder' => trans('report.pnl_year')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/occupancy_by_national') }}"></redirect-btn>
</form-ajax>
