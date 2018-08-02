<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-complete=true>
  {{ Form::hidden('rep_function', $type) }}
  {{ Form::hidden('rep_class', 'Reports\ExportBillsExcel') }}
<div class="row">
  <!-- {{ Form::filterText('rep_filter[id]', trans('bill.bil_id'), array_get($filter, 'id'), ['placeholder' => trans('bill.bil_id')]) }} -->
  {{ Form::filterText('rep_filter[customer_name]', trans('customer.full_name'), array_get($filter, 'customer_name'), ['placeholder' => trans('customer.full_name')]) }}
  <!-- {{ Form::filterText('rep_filter[customer_email]', trans('customer.cus_email'), array_get($filter, 'customer_email'), ['placeholder' => trans('customer.cus_email')]) }} -->
  {{ Form::filterText('rep_filter[booking]', trans('bill.bil_booking'), array_get($filter, 'booking'), ['placeholder' => trans('bill.bil_booking')]) }}
  {{ Form::filterText('rep_filter[start]', trans('bill.from_bil_date'), array_get($filter, 'start'), ['placeholder' => trans('bill.from_bill_date'), 'class' => 'datepicker form-control']) }}
  {{ Form::filterText('rep_filter[end]', trans('bill.to_bil_date'), array_get($filter, 'end'), ['placeholder' => trans('bill.to_bill_date'), 'class' => 'datepicker form-control']) }}
  {{ Form::filterSelect('rep_filter[status]', trans('bill.bil_status'), $rs_status, array_get($filter, 'status'), ['class' => 'select2 form-control']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/export_bills') }}"></redirect-btn>
</form-ajax>
