@extends($layout)

@push('content')
@include('customer.profile')
@include('booking._info_extended', ['booking' => $booking])
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#bill" aria-controls="bill" role="tab" data-toggle="tab"><i class="fa fa-list"></i> @lang('booking.bills')</a></li>
  <li role="presentation"><a href="#itinerary" aria-controls="itinerary" role="tab" data-toggle="tab"><i class="fa fa-cab"></i> Tour ( {{ $itineraries->count() }} )</a></li>
  <!-- <li role="presentation"><a href="#fnb" aria-controls="fnb" role="tab" data-toggle="tab"><i class="fa fa-glass"></i> F&B</a></li> -->
</ul>

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="bill">
    <div class="panel-group" id="accordion">
      @foreach($bills as $bill)
      <div class="panel panel-default">
        <div class="panel-heading">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $bill->bil_id }}">
          <div class="row">
            <div class="col-md-3">
              <h4 class="panel-title">
                  # {{ $bill->bil_id }}
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
          </a>
        </div>
        <div id="collapse{{ $bill->bil_id }}" class="panel-collapse collapse in">
          <div class="panel-body">
            @include('bill.itemized', ['items' => $bill->items])
            @include('receipt.itemized', ['rcitems' => $bill->receipts])
            <div class="row">
              <div class="col-md-3"><a href="{{ urlTenant(sprintf("bookings/bill/%s/addons/%s/new", $bill->bil_id, 2)) }}" v-modal><button class="form-control btn-primary"><i class="fa fa-cab"></i> @lang('form.add_itinerary')</button></a></div>
              <div class="col-md-3"><a href="{{ urlTenant(sprintf("bookings/bill/%s/addons/%s/pos", $bill->bil_id, 3)) }}" v-modal><button class="form-control btn-primary"><i class="fa fa-glass"></i> @lang('form.add_fnb')</button></a></div>
              <div class="col-md-3"><a href="{{ urlTenant('receipts/new/' . $bill->bil_id) }}" v-modal><button class="form-control btn-primary"><i class="fa fa-money"></i> @lang('form.pay')</button></a></div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="itinerary">
    @include('addon.itemized', ['items' => $itineraries])
  </div>
  <!-- <div role="tabpanel" class="tab-pane" id="fnb">...</div> -->
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
