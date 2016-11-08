<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordionx" href="#collapse-book{{ $booking->book_id }}">
    <div class="row">
      <div class="col-md-3">
        <i class="fa fa-bed"></i> {{ $booking->resource->rs_name }}
      </div>
      <div class="col-md-3">
        {{ showDate($booking->book_from) }} - {{ showDate($booking->book_to) }}
      </div>
      <div class="col-md-3">
        <span class="label label-info">{{ dayDiff($booking->book_from, $booking->book_to) }} @lang('booking.nights')</span>
      </div>
      <div class="col-md-3">
        <i class="fa fa-circle status-{{ $booking->book_status }}"></i> {{ array_get($book_status, $booking->book_status) }}
      </div>
    </div>
    </a>
  </div>
  <div id="collapse-book{{ $booking->book_id }}" class="panel-collapse collapse in">
    <div class="panel-body">
      <div class="row">
        {{ Form::showField($booking->book_pax, trans('booking.book_pax')) }}
        {{ Form::showField($booking->book_reference, trans('booking.book_reference')) }}
        {{ Form::showField($booking->book_tracking, trans('booking.book_tracking')) }}
      </div>

      <div class="row">
        @if (config('maypp.enable_checkin'))
        <div class="col-md-3"><button class="form-control btn-primary" v-post successreload="true" postto="{{ urlTenant('bookings/checkin/' . $booking->book_id) }}"><i class="fa fa-sign-in"></i> @lang('form.check_in')</button></div>
        @endif
        @if (config('maypp.enable_checkout'))
        <div class="col-md-3"><button class="form-control btn-primary" v-post successreload="true" postto="{{ urlTenant('bookings/checkout/' . $booking->book_id) }}"><i class="fa fa-sign-out"></i> @lang('form.check_out')</button></div>
        @endif
      </div>
    </div>
  </div>
</div>