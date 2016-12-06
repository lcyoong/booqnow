@extends($layout)

@push('content')
@include('customer.profile', ['customer' => $booking->customer])
@include('booking._info_extended', ['booking' => $booking])
{{ Form::open(['url' => urlTenant('addons/new'), 'v-ajax', 'gotonext' => urlTenant(sprintf("bookings/%s", $booking->book_id)), 'hidecompletemessage' => true]) }}
{{ Form::hidden('add_booking', $booking->book_id) }}
@if('myapp.single_bill_booking')
{{ Form::hidden('add_bill', array_get($account_bill, $resource_type->rty_accounting)) }}
@endif
{{ Form::hidden('add_unit', 1) }}
{{ Form::hidden('add_customer', $booking->book_customer) }}
<div class="row">
  {{ Form::bsSelect('add_resource', trans('addon.add_resource'), $resources, null, ['class' => 'select2', 'style' => 'width: 100%']) }}
  {{ Form::bsNumber('add_pax', trans('addon.add_pax'), 1, ['min' => 1, 'max'=>20]) }}
  {{ Form::bsDate('add_date', trans('addon.add_date'), today()) }}
</div>
<div class="row">
  {{ Form::bsText('add_reference', trans('addon.add_reference')) }}
  {{ Form::bsText('add_tracking', trans('addon.add_tracking')) }}
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
