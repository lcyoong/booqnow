@extends($layout)

@prepend('content')
@if($bill->customer)
@include('customer.profile', ['customer' => $bill->customer])
@endif
<div id="receipt-new">
<h4>{{ $bill->bil_description }}</h4>
@include('bill.basic', ['bill' => $bill])
<hr/>
<form-ajax action = "{{ urlTenant('receipts/new') }}" method="POST" go-to-next ="{{ urlTenant(sprintf("bookings/%s", $bill->bil_booking)) }}" @startwait="startWait" @endwait="endWait">
{{ Form::hidden('rc_bill', $bill->bil_id) }}
<div class="row">
  {{ Form::bsSelect('rc_method', trans('receipt.rc_method'), $pay_methods, null, ['class' => 'select2', 'style' => 'width:100%']) }}
  {{ Form::bsText('rc_amount', trans('receipt.rc_amount'), $bill->outstanding) }}
  {{ Form::bsDate('rc_date', trans('receipt.rc_date'), today()) }}
  {{ Form::bsSelect('rc_type', trans('receipt.rc_type'), $rc_type, null, ['class' => 'select2', 'style' => 'width:100%']) }}
</div>
<div class="row">
  {{ Form::bsText('rc_remark', trans('receipt.rc_remark'), null, ['placeholder' => trans('receipt.rc_remark_placeholder')]) }}
  {{ Form::bsText('rc_reference', trans('receipt.rc_reference')) }}
  <!-- {{ Form::bsText('rc_intremark', trans('receipt.rc_intremark')) }} -->
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
<!-- {{ Form::close() }} -->
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
$(function() {
  $('.select2').select2();

  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
  });
});

new Vue({
  el: '#receipt-new',

  mixins: [mixForm],

  created: function () {
  },
});

</script>
@endprepend
