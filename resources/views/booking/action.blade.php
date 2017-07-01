@extends($layout)

@push('content')
@include('customer.profile', ['customer' => $booking->customer])
@include('booking._info_extended', ['booking' => $booking])
<div id="booking-action">
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#bill" aria-controls="bill" role="tab" data-toggle="tab"><i class="fa fa-list"></i> @lang('booking.bills')</a></li>
  @foreach($resource_types as $type)
  @if(!$type->rty_master)
  <li role="presentation"><a href="#{{ $type->rty_code }}" aria-controls="{{ $type->rty_code }}" role="tab" data-toggle="tab"><i class="fa {{ config('myapp.icon-' . $type->rty_code) }}"></i> {{ $type->rty_plural }}</a></li>
  @endif
  @endforeach
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
              #{{ $bill->display_id }} - {{ $bill->bil_description }}
            </div>
            <div class="col-md-3">
              {{ showDate($bill->bil_date) }}
            </div>
            <div class="col-md-3">
              @lang('bill.total') : {{ showMoney($bill->total_amount) }}
            </div>
            <div class="col-md-3">
              @lang('bill.outstanding') : {{ showMoney($bill->outstanding) }}
            </div>
          </div>
          </a>
        </div>
        <div id="collapse{{ $bill->bil_id }}" class="panel-collapse collapse">
          <div class="panel-body">
            @include('bill.itemized', ['items' => $bill->items])
            @include('receipt.itemized', ['rcitems' => $bill->receipts])
            <a href="{{ urlTenant('receipts/new/' . $bill->bil_id) }}" v-modal><button class="btn btn-primary btn-sm">@lang('form.pay')</button></a>
            <a href="{{ urlTenant(sprintf("bills/%s/print?" . str_random(40), $bill->bil_id)) }}" target=_blank><button class="btn btn-primary btn-sm">@lang('form.print')</button></a>
            <!-- <div class="col-md-3"><a href="{{ urlTenant(sprintf("bookings/bill/%s/addons/%s/pos", $bill->bil_id, 3)) }}" v-modal><button class="form-control btn-primary"><i class="fa fa-glass"></i> @lang('form.add_fnb')</button></a></div> -->
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @foreach($resource_types as $type)
  @if(!$type->rty_master)
  <div role="tabpanel" class="tab-pane" id="{{ $type->rty_code }}">
    @include('addon.itemized.' . $type->rty_code, ['items' => $addons, 'type' => $type])
  </div>
  @endif
  @endforeach

</div>

</div>

<script>
var app3 = new Vue({
  el: '#booking-action',
  created: function () {
  },
});
</script>

@endpush
