<div class="panel panel-default" id = "booking-extended">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordionx" href="#collapse-book{{ $booking->book_id }}">
    <div class="row">
      <div class="col-md-3">
        {{ $booking->display_id }}
      </div>
      <div class="col-md-3">
        <i class="fa fa-bed"></i> {{ $booking->resource->rs_name }} @if($booking->book_special) <i class="fa fa-star special-color"></i> @endif
        <div>{{ showDate($booking->book_from) }} - {{ showDate($booking->book_to) }}</div>
      </div>
      <div class="col-md-3">
        {{ dayDiff($booking->book_from, $booking->book_to) }} @lang('booking.nights') x {{ $booking->book_pax }} @lang('booking.book_pax') + {{ $booking->book_pax_child }} @lang('booking.book_pax_child_simple')
        @if($booking->book_extra_bed > 0) + <span class="label label-default">{{ $booking->book_extra_bed }} extra bed</span>  @endif
      </div>
      <div class="col-md-3">
        <i class="fa fa-circle status-{{ $booking->book_status }}"></i> {{ array_get($book_status, $booking->book_status) }}
      </div>
    </div>
    </a>
  </div>
  <div id="collapse-book{{ $booking->book_id }}" class="panel-collapse collapse">
    <div class="panel-body">
      <div class="row">
        {{ Form::showField(array_get($booking_sources, $booking->book_source), trans('booking.book_source')) }}
        {{ Form::showField( isset($booking->agent) ? $booking->agent->ag_name : '', trans('booking.book_agent')) }}
        {{ Form::showField(!is_null($booking->book_expiry) ? $booking->book_expiry . ' <span class="label label-info">' . showHumanDiff($booking->book_expiry) .'</span>' : null, trans('booking.book_expiry')) }}
        {{ Form::showField( @$book_leads[$booking->book_lead_from], trans('booking.book_lead_from')) }}
      </div>

      <div class="row">
        {{ Form::showField($booking->creator->name, trans('form.created_by')) }}
        {{ Form::showField($booking->created_at, trans('form.created_at')) }}
        {{ Form::showField($booking->book_remarks, trans('booking.book_remarks')) }}
        {{ Form::showField($booking->book_reference, trans('booking.book_reference')) }}
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

@push('scripts')
<script>
new Vue({
  el: '#booking-extended',
});
</script>
@endpush
