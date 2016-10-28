@extends($layout)

@push('content')
{{ Form::open(['url' => urlTenant('receipts/new'), 'v-ajax', 'gotonext' => urlTenant('bookings/new'), 'hidecompletemessage' => true]) }}
{{ Form::hidden('rc_bill', $bill->bil_id) }}
<div class="row">
  {{ Form::bsText('rc_amount', trans('receipt.rc_amount')) }}
  {{ Form::bsText('rc_reference', trans('receipt.rc_reference')) }}
  {{ Form::bsSelect('rc_method', trans('receipt.rc_method'), $pay_methods) }}
</div>
<div class="row">
  {{ Form::bsText('rc_remark', trans('receipt.rc_remark')) }}
  {{ Form::bsText('rc_intremark', trans('receipt.rc_intremark')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

<script>
var app2 = new Vue({
    el: 'body',
    ready: function () {
      // alert('sss');
    },
    methods: {
    }
});
</script>
@endpush
