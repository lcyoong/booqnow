@extends($layout)

@push('content')
<div id="temp">
{{ Form::open(['url' => urlTenant('customers/new'), 'v-ajax', 'gotonext' => urlTenant('bookings/new'), 'hidecompletemessage' => true]) }}
<div class="row">
  {{ Form::bsEmail('cus_email', trans('customer.cus_email')) }}
  {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries) }}
  {{ Form::bsText('cus_first_name', trans('customer.cus_first_name')) }}
  {{ Form::bsText('cus_last_name', trans('customer.cus_last_name')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
</div>

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
