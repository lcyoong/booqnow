{{ Form::open(['url' => isset($filter_url) ? $filter_url : 'bills', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('id', trans('bill.bil_id'), array_get($filter, 'id'), ['placeholder' => trans('bill.bil_id')]) }}
  {{ Form::filterText('customer_name', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('customer_email', trans('customer.cus_email'), array_get($filter, 'customer_email'), ['placeholder' => trans('customer.cus_email')]) }}
  {{ Form::filterText('booking', trans('bill.bil_booking'), array_get($filter, 'booking'), ['placeholder' => trans('bill.bil_booking')]) }}
  {{ Form::filterDate('start', trans('bill.from_bil_date'), array_get($filter, 'start'), ['placeholder' => trans('bill.from_bill_date')]) }}
  {{ Form::filterDate('end', trans('bill.to_bil_date'), array_get($filter, 'end'), ['placeholder' => trans('bill.to_bill_date')]) }}
</div>
<div class="row">
{{ Form::filterSelect('status', trans('bill.bil_status'), $rs_status, array_get($filter, 'status'), ['class' => 'select2 form-control']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant(isset($filter_url) ? $filter_url : 'bills') }}" class="btn-sm"></redirect-btn>
<redirect-btn label="@lang('form.export')" redirect="{{ urlTenant('reports/export_bills') }}" class="btn-sm"></redirect-btn>
<!-- <post-ajax :post-to="'{{ urlTenant(sprintf("bills/export")) }}'"><button class="btn btn-primary btn-sm">@lang('form.export')</button></post-ajax> -->
<!-- <button v-post class="btn btn-primary btn-sm" postto="{{ urlTenant('bills/export') }}"><i class="fa fa-download"></i> @lang('form.export')</button> -->
{{ Form::close() }}
