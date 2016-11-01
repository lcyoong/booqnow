@extends($layout)

@push('content')
@include('customer.profile')
<hr/>
<h4><i class="fa fa-bed"></i> {{ $booking->resource->rs_name }}</h4>
<div class="row">
  {{ Form::showField(showDate($booking->book_from), trans('booking.book_from')) }}
  <div class="col-md-3">
    @lang('booking.book_to')
    <div class="value">{{ showDate($booking->book_to) }} <span class="label label-info">{{ dayDiff($booking->book_from, $booking->book_to) }} @lang('booking.nights')</span></div>
  </div>
  {{ Form::showField($booking->book_pax, trans('booking.book_pax')) }}
  {{ Form::showField($booking->book_status, trans('booking.book_status')) }}
</div>
<div class="row">
  {{ Form::showField($booking->book_reference, trans('booking.book_reference')) }}
  {{ Form::showField($booking->book_tracking, trans('booking.book_tracking')) }}
</div>
<div class="row">
  <div class="col-md-3"><button class="form-control btn-primary" v-post successreload="true" postto="{{ urlTenant('bookings/checkin/' . $booking->book_id) }}"><i class="fa fa-sign-in"></i> @lang('form.check_in')</button></div>
  <div class="col-md-3"><button class="form-control btn-primary" v-post successreload="true" postto="{{ urlTenant('bookings/checkout/' . $booking->book_id) }}"><i class="fa fa-sign-out"></i> @lang('form.check_out')</button></div>
</div>
<hr/>
<h4><i class="fa fa-dollar"></i> @lang('booking.bills')</h4>
<div class="panel-group" id="accordion">
  @foreach($bills as $bill)
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="row">
        <div class="col-md-3">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $bill->bil_id }}">
              # {{ $bill->bil_id }}
            </a>
          </h4>
        </div>
        <div class="col-md-3">
          {{ showDate($bill->bil_date) }}
        </div>
        <div class="col-md-3">
          <span class="label label-success">@lang('bill.total') {{ showMoney($bill->bil_gross + $bill->bil_tax, true) }}</span>
        </div>
        <div class="col-md-3">
          <span class="label label-info">@lang('bill.bil_paid') {{ showMoney($bill->bil_paid, true) }}</span>
        </div>
        <!-- <div class="col-md-3">
          {{ $bill->bil_status }}
        </div> -->
      </div>
    </div>
    <div id="collapse{{ $bill->bil_id }}" class="panel-collapse collapse in">
      <div class="panel-body">
        @include('bill.itemized', ['items' => $bill->items])
        @include('receipt.itemized', ['rcitems' => $bill->receipts])
        <div class="row">
          <div class="col-md-3"><button class="form-control btn-primary"><i class="fa fa-asterisk"></i> @lang('form.add_itinerary')</button></div>
          <div class="col-md-3"><button class="form-control btn-primary"><i class="fa fa-glass"></i> @lang('form.add_fnb')</button></div>
          <div class="col-md-3"><a href="{{ urlTenant('receipts/new/' . $bill->bil_id) }}" v-modal><button class="form-control btn-primary"><i class="fa fa-money"></i> @lang('form.pay')</button></a></div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
<script>
var app3 = new Vue({
    el: 'body',
    ready: function () {
      // alert('sss');
    },
});
</script>

@endpush
