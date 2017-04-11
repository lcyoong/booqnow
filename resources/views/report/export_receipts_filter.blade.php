<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-complete=true>
  {{ Form::hidden('rep_function', $type) }}
  {{ Form::hidden('rep_class', 'Reports\ExportReceiptsExcel') }}
<div class="row">
  {{ Form::filterText('rep_filter[bill]', trans('receipt.rc_bill'), array_get($filter, 'bill'), ['placeholder' => trans('receipt.rc_bill')]) }}
  {{ Form::filterText('rep_filter[customer_name]', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('rep_filter[start]', trans('bill.from_bil_date'), array_get($filter, 'start'), ['placeholder' => trans('bill.from_bill_date'), 'class' => 'datepicker form-control']) }}
  {{ Form::filterText('rep_filter[end]', trans('bill.to_bil_date'), array_get($filter, 'end'), ['placeholder' => trans('bill.to_bill_date'), 'class' => 'datepicker form-control']) }}
  {{ Form::filterSelect('rep_filter[method]', trans('receipt.rc_method'), $pay_methods, array_get($filter, 'method'), ['class' => 'select2', 'style' => 'width: 100%']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/export_bills') }}"></redirect-btn>
</form-ajax>
