{{ Form::open(['url' => 'bills', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('customer_name', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('customer_email', trans('customer.cus_email'), array_get($filter, 'customer_email'), ['placeholder' => trans('customer.cus_email')]) }}
  {{ Form::filterText('booking', trans('bill.bil_booking'), array_get($filter, 'booking'), ['placeholder' => trans('bill.bil_booking')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="bills"></redirect-btn>
{{ Form::close() }}
