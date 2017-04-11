{{ Form::open(['url' => 'receipts', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('customer_name', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('bill', trans('receipt.rc_bill'), array_get($filter, 'bill'), ['placeholder' => trans('receipt.rc_bill')]) }}
  {{ Form::filterDate('start', trans('receipt.from_rc_date'), array_get($filter, 'start'), ['placeholder' => trans('receipt.from_rc_date')]) }}
  {{ Form::filterDate('end', trans('receipt.to_rc_date'), array_get($filter, 'end'), ['placeholder' => trans('receipt.to_rc_date')]) }}
  {{ Form::filterSelect('method', trans('receipt.rc_method'), $pay_methods, array_get($filter, 'method'), ['class' => 'select2', 'style' => 'width: 100%']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('receipts') }}" class="btn-sm"></redirect-btn>
<redirect-btn label="@lang('form.export')" redirect="{{ urlTenant('reports/export_receipts') }}" class="btn-sm"></redirect-btn>
{{ Form::close() }}
