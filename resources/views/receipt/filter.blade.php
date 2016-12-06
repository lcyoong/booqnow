{{ Form::open(['url' => 'receipts', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('customer_name', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('bill', trans('receipt.rc_bill'), array_get($filter, 'bill'), ['placeholder' => trans('receipt.rc_bill')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('receipts') }}"></redirect-btn>
{{ Form::close() }}
