<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-complete=true>
{{ Form::hidden('rep_function', 'occupancy_by_day') }}
{{ Form::hidden('rep_class', 'Reports\OccupancyByDayExcel') }}
<div class="row">
  {{ Form::bsYear("rep_filter[year]", trans('report.pnl_year'), null, ['placeholder' => trans('report.pnl_year')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}

<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/occupancy_by_day') }}"></redirect-btn>
</form-ajax>
