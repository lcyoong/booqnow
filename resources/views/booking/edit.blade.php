@extends($layout)

@prepend('content')
<div id="booking-edit">
  <a v-modal href="{{ urlTenant(sprintf('trail/bookings/%s', $booking->book_id)) }}"><i class="fa fa-history"></i></a>
  <a class="icon-button-margin" v-modal href="{{ urlTenant(sprintf('comments/bookings/%s', $booking->book_id)) }}" title="@lang('form.comments')"><i class="fa fa-comment-o"></i></a>
  <!-- Customer info -->
  <h4>
    <i class="fa fa-user"></i> {{ $booking->customer->full_name }}
  </h4>
  <div class="row">
    <div class="col-md-3"><i class="fa fa-envelope-o"></i> {{ $booking->customer->cus_email }}</div>
    <div class="col-md-3"><i class="fa fa-phone"></i> {{ $booking->customer->cus_contact1 }}</div>
    <div class="col-md-3"><i class="fa fa-globe"></i> {{ $booking->customer->cus_country }}</div>
  </div>

  <form-ajax action = "{{ urlTenant('bookings/update') }}" method="POST" @startwait="startWait" @endwait="endWait">
    {{ Form::hidden('book_id', $booking->book_id) }}
    <div class="row">
      {{ Form::bsSelect('book_resource', trans('booking.book_resource'), $rooms, $booking->book_resource, ['style' => 'width:100%', 'vmodel' => 'booking.book_resource', 'class'=>'select2']) }}
      {{ Form::bsDate('book_from', trans('booking.book_from'), $booking->book_from, ['vmodel' => 'booking.book_from']) }}
      {{ Form::bsDate('book_to', trans('booking.book_to'), $booking->book_to, ['vmodel' => 'booking.book_to']) }}
    </div>
    <div class="row">
      {{ Form::bsSelect('book_source', trans('booking.book_source'), $booking_sources, $booking->book_source) }}
      {{ Form::bsNumber('book_pax', trans('booking.book_pax'), $booking->book_pax, ['min' => 1, 'max'=>20]) }}
      {{ Form::bsText('book_reference', trans('booking.book_reference'), $booking->book_reference) }}
    </div>
    <div class="row">
      {{ Form::bsTextarea('book_remarks', trans('booking.book_remarks'), $booking->book_remarks, ['rows' => 4]) }}
      {{ Form::bsSelect('book_status', trans('booking.book_status'), $book_status, $booking->book_status, ['style' => 'width:100%', 'vmodel' => 'booking.book_status']) }}
      <div class="col-md-3">
        <div class="form-group">
          <label for="book_special" class="control-label">@lang('booking.book_special')</label>
          <div>
            {{ Form::hidden('book_special', 0) }}
            {{ Form::checkbox('book_special', 1, $booking->book_special ? true : false, ['data-toggle' => 'toggle']) }}
          </div>
        </div>
      </div>
    </div>
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
    <a href="{{ url('bookings') }}">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a>
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#booking-edit",

  mixins: [mixForm],

  created: function () {
  },

  data: {
    book_special: Boolean({{ $booking->book_special }})
  },

  methods: {
  }
})
</script>
@endprepend
