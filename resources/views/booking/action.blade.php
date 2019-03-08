@extends($layout)

@push('content')
@include('customer.profile', ['customer' => $booking->customer])
<div id="booking-action">

  @include('booking._info_extended', ['booking' => $booking])

  <div>
    <a href="{{ urlTenant("/bookings/{$booking->book_id}/edit") }}">{{ Form::button('Edit booking', ['class' => 'btn
      btn-primary btn-sm']) }}</a>
    @if($booking->book_status == 'confirmed')
    <post-ajax :post-to="'{{ urlTenant("bookings/checkin/{$booking->book_id}") }}'" reload-on-completex="1"
      @completesuccess="redirectToDate">{{ Form::button(trans('form.checkin'), ['class' => 'btn btn-primary btn-sm',
      'style'=>'background: #8DC63F; border: #8DC63F']) }}</post-ajax>
    <post-ajax :post-to="'{{ urlTenant("bookings/cancel/{$booking->book_id}") }}'" reload-on-completex="1"
      @completesuccess="redirectToDate">{{ Form::button(trans('form.cancel_booking'), ['class' => 'btn btn-primary
      btn-sm', 'style'=>'background: #636b6f; border: #636b6f']) }}</post-ajax>
    @elseif($booking->book_status == 'checkedin')
    <post-ajax :post-to="'{{ urlTenant("bookings/checkout/{$booking->book_id}") }}'" reload-on-completex="1"
      @completesuccess="redirectToDate">{{ Form::button(trans('form.checkout'), ['class' => 'btn btn-primary btn-sm',
      'style'=>'background: #FF0000; border: #FF0000']) }}</post-ajax>
    @elseif($booking->book_status == 'hold')
    <post-ajax :post-to="'{{ urlTenant("bookings/confirm/{$booking->book_id}") }}'" reload-on-completex="1"
      @completesuccess="redirectToDate">{{ Form::button(trans('form.confirm'), ['class' => 'btn btn-primary btn-sm',
      'style'=>'background: #00ceff; border: #00ceff']) }}</post-ajax>
    <post-ajax :post-to="'{{ urlTenant("bookings/cancel/{$booking->book_id}") }}'" reload-on-completex="1"
      @completesuccess="redirectToDate">{{ Form::button(trans('form.cancel_booking'), ['class' => 'btn btn-primary
      btn-sm', 'style'=>'background: #636b6f; border: #636b6f']) }}</post-ajax>
    @endif
  </div>
  <br />

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#bill" aria-controls="bill" role="tab" data-toggle="tab"><i class="fa fa-list"></i>
        @lang('booking.bills')</a></li>
    @foreach($resource_types as $type)
    @if(!$type->rty_master)
    <li role="presentation"><a href="#{{ $type->rty_code }}" aria-controls="{{ $type->rty_code }}" role="tab"
        data-toggle="tab"><i class="fa {{ config('myapp.icon-' . $type->rty_code) }}"></i> {{ $type->rty_plural }}</a></li>
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
              @permitted('bill')
              <a href="{{ url("bills/{$bill->bil_id}/edit") }}"><i class="fa fa-edit"></i> Edit bill</a>
              @endpermitted
              @include('bill.itemized', ['items' => $bill->items])
              @include('receipt.itemized', ['rcitems' => $bill->receipts])
              <a href="{{ urlTenant('receipts/new/' . $bill->bil_id) }}" v-modal><button class="btn btn-primary btn-sm">@lang('form.pay')</button></a>
              <a href="{{ urlTenant(sprintf("bills/%s/print?" . str_random(40), $bill->bil_id)) }}" target=_blank><button
                  class="btn btn-primary btn-sm">@lang('form.print')</button></a>
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
      @if (view()->exists('addon.itemized.' . $type->rty_code))
      @include('addon.itemized.' . $type->rty_code, ['items' => $addons, 'type' => $type])
      @endif
    </div>
    @endif
    @endforeach

  </div>

</div>

@endpush

@prepend('scripts')
<script>
  var app3 = new Vue({
    el: '#booking-action',
    created: function () {},
    methods: {
      redirectToDate: function (value) {
        if (value.data && value.data.redirect_to) {
          window.location.replace("{{ url('?date=') }}" + value.data.redirect_to);
        }
      }
    }
  });
</script>
@endprepend