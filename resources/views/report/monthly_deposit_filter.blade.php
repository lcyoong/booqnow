<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-completex=true>
{{ Form::hidden('rep_function', $type) }}
{{ Form::hidden('rep_class', 'Reports\MonthlyDepositExcel') }}
<div class="row">
  {{ Form::bsYear("rep_filter[fr_year]", trans('report.from_year'), null, ['placeholder' => trans('report.from_year')]) }}
  {{ Form::bsYear("rep_filter[to_year]", trans('report.to_year'), null, ['placeholder' => trans('report.to_year')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}

<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant("reports/$type") }}"></redirect-btn>
</form-ajax>
