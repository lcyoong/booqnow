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
  <!-- {{ Form::showField($booking->book_tracking, trans('booking.book_tracking')) }} -->
</div>
