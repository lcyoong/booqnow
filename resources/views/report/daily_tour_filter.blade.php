<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-complete=true>
  {{ Form::hidden('rep_function', $type) }}
  {{ Form::hidden('rep_class', 'Reports\DailyTourExcel') }}
<div class="row">
  {{ Form::filterDate('rep_filter[fromDate]', trans('addon.from_date'), null, ['placeholder' => trans('addon.from_date')]) }}
  {{ Form::filterDate('rep_filter[toDate]', trans('addon.to_date'), null, ['placeholder' => trans('addon.to_date')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/daily_tour') }}"></redirect-btn>
</form-ajax>
