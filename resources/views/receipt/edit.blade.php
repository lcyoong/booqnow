@extends($layout)

@prepend('content')
<div id="receipt-edit">
  @include('bill.basic', ['bill' => $receipt->bill])
  <form-ajax action = "{{ urlTenant('receipts/update') }}" method="POST" @startwait="startWait" @endwait="endWait" reload-on-complete = "1">
  {{ Form::hidden('rc_id', $receipt->rc_id) }}
  <div class="row">
    {{ Form::bsDate('rc_date', trans('receipt.rc_date'), $receipt->rc_date) }}
    {{ Form::bsText('rc_amount', trans('receipt.rc_amount'), $receipt->rc_amount) }}
    {{ Form::bsSelect('rc_method', trans('receipt.rc_method'), $pay_methods, $receipt->rc_method, ['class' => 'select2', 'style' => 'width:100%']) }}
    {{ Form::bsSelect('rc_status', trans('receipt.rc_status'), $rs_status, $receipt->rc_status, ['style' => 'width:100%']) }}
  </div>
  <div class="row">
    {{ Form::bsText('rc_reference', trans('receipt.rc_reference'), $receipt->rc_reference) }}
    {{ Form::bsTextarea('rc_remark', trans('receipt.rc_remark'), $receipt->rc_remark, ['rows' => 4]) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <!-- <a href="{{ url('receipts') }}">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a> -->
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
$(function () {
  $('.select2').select2();

  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
  });

});

new Vue ({

  el: "#receipt-edit",

  mixins: [mixForm],
})
</script>
@endprepend
