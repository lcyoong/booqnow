{{ Form::open(['url' => 'bookings', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('customer_name', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('customer_email', trans('customer.cus_email'), array_get($filter, 'customer_email'), ['placeholder' => trans('customer.cus_email')]) }}
  <!-- {{ Form::filterText('tracking', trans('booking.book_tracking'), array_get($filter, 'tracking'), ['placeholder' => trans('booking.book_tracking')]) }} -->
  {{ Form::filterText('reference', trans('booking.book_reference'), array_get($filter, 'reference'), ['placeholder' => trans('booking.book_reference')]) }}
  {{ Form::filterText('agent_name', trans('booking.book_agent'), array_get($filter, 'agent_name'), ['placeholder' => trans('booking.book_agent')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<redirect-btn label="@lang('form.clear')" redirect="bookings" class="btn-sm"></redirect-btn>
{{ Form::close() }}
