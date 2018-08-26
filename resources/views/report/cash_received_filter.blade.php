<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-complete=true>
  {{ Form::hidden('rep_function', $type) }}
  {{ Form::hidden('rep_class', 'Reports\CashReceivedExcel') }}
<div class="row">
  {{ Form::filterText('rep_filter[bookCheckOutFrom]', trans('bill.from_bil_date'), array_get($filter, 'bookCheckOutFrom'), ['placeholder' => trans('booking.from_check_out'), 'class' => 'datepicker form-control']) }}
  {{ Form::filterText('rep_filter[bookCheckOutTo]', trans('bill.to_bil_date'), array_get($filter, 'bookCheckOutTo'), ['placeholder' => trans('booking.to_check_out'), 'class' => 'datepicker form-control']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/cash_received') }}"></redirect-btn>
</form-ajax>
